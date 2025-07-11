<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Category;
use App\Models\Group;
use App\Models\Tag;
use App\Models\Test;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class CatalogManager
{
    public function getCategories()
    {
        return Category::query()->orderBy('title')->get();
    }

    public function getTests(array $filters): array
    {
        $testsQuery = Test::query()
            ->where('status', 'active');

        if (!empty($filters['q'])) {
            $q = $filters['q'];
            $testsQuery->where(function ($query) use ($q) {
                $query->where('title', 'ilike', "%{$q}%")
                    ->orWhere('description', 'ilike', "%{$q}%");
            });
        }

        if (!empty($filters['category_id'])) {
            $testsQuery->whereHas('categories', function ($query) use ($filters) {
                $query->where('categories.id', $filters['category_id']);
            });
        }

        if (!empty($filters['tag_id'])) {
            $testsQuery->whereHas('tags', function ($query) use ($filters) {
                $query->where('tags.id', $filters['tag_id']);
            });
        }

        if (!empty($filters['author_id'])) {
            $testsQuery->where('tests.user_id', $filters['author_id']);
        }

        $this->applySorting($testsQuery, $filters['sort_by'] ?? 'popular_month');

        $tests = $testsQuery->paginate(36);

        $selectedTagName = !empty($filters['tag_id']) ? Tag::find($filters['tag_id'])->name ?? null : null;
        $selectedAuthorName = !empty($filters['author_id']) ? User::find($filters['author_id'])->name ?? null : null;

        return compact('tests', 'selectedTagName', 'selectedAuthorName');

    }

    public function getTags(array $filters): array
    {
        $tagsQuery = Tag::query()
            ->select('tags.*')
            ->withCount([
                'tests as active_tests_count' => function ($query) {
                    $query->where('status', 'active');
                },
            ])
            ->whereHas('tests', function ($query) {
                $query->where('status', 'active');
            })
            ->orderBy('name');

        if (!empty($filters['q'])) {
            $tagsQuery->where('name', 'ilike', "%{$filters['q']}%");
        }

        $tags = $tagsQuery->distinct()
            ->paginate(60);

        return [
            'tags' => $tags,
        ];
    }

    public function getAuthors(array $filters): array
    {
        $q = $filters['q'] ?? '';
        $sortBy = $filters['sort_by'] ?? 'popular';

        $authorsQuery = User::query()
            ->withCount([
                'tests as active_tests_count' => function ($query) {
                    $query->where('status', 'active');
                },
            ])
            ->whereHas('tests', function ($query) {
                $query->where('status', 'active');
            });

        if ($q) {
            $authorsQuery->where('name', 'ilike', "%{$q}%");
        }

        switch ($sortBy) {
            case 'popular':
                $authorsQuery
                    ->leftJoin('tests', 'users.id', '=', 'tests.user_id')
                    ->leftJoin('taking_tests', 'tests.id', '=', 'taking_tests.test_id')
                    ->select(
                        'users.*',
                        DB::raw('COUNT(taking_tests.id) as popular'),
                        DB::raw('(SELECT COUNT(*) FROM tests WHERE tests.user_id = users.id AND tests.status = \'active\' AND tests.deleted_at IS NULL) as active_tests_count')
                    )
                    ->groupBy('users.id')
                    ->orderByDesc('popular');
                break;

            case 'alphabet_asc':
                $authorsQuery->orderBy('name');
                break;

            case 'alphabet_desc':
                $authorsQuery->orderBy('name', 'desc');
                break;

            case 'new_author':
                $authorsQuery->orderBy('created_at', 'desc');
                break;

            default:
                $authorsQuery->orderBy('name');
                break;
        }

        $authors = $authorsQuery->paginate(30);

        return [
            'authors' => $authors,
        ];
    }

    public function getGroupsTests()
    {
        return Group::query()
            ->orderBy('created_at', 'desc')
            ->paginate(20);
    }

    protected function applySorting(Builder $query, string $sortBy): void
    {
        switch ($sortBy) {
            case 'popular_all_time':
                $query->leftJoin('taking_tests', 'tests.id', '=', 'taking_tests.test_id')
                    ->select('tests.*', DB::raw('count(taking_tests.id) as taking_count'))
                    ->groupBy('tests.id')
                    ->orderByDesc('taking_count');
                break;

            case 'popular_day':
                $query->leftJoin('taking_tests', 'tests.id', '=', 'taking_tests.test_id')
                    ->select('tests.*', DB::raw('count(taking_tests.id) as taking_count'))
                    ->where(function (Builder $query) {
                        $query->where('taking_tests.created_at', '>=', now()->subDay())
                            ->orWhereNull('taking_tests.created_at');
                    })
                    ->groupBy('tests.id')
                    ->orderByDesc('taking_count');
                break;

            case 'popular_week':
                $query->leftJoin('taking_tests', 'tests.id', '=', 'taking_tests.test_id')
                    ->select('tests.*', DB::raw('count(taking_tests.id) as taking_count'))
                    ->where(function (Builder $query) {
                        $query->where('taking_tests.created_at', '>=', now()->subWeek())
                            ->orWhereNull('taking_tests.created_at');
                    })
                    ->groupBy('tests.id')
                    ->orderByDesc('taking_count');
                break;

            case 'popular_month':
                $query->leftJoin('taking_tests', 'tests.id', '=', 'taking_tests.test_id')
                    ->select('tests.*', DB::raw('count(taking_tests.id) as taking_count'))
                    ->where(function (Builder $query) {
                        $query->where('taking_tests.created_at', '>=', now()->subMonth())
                            ->orWhereNull('taking_tests.created_at');
                    })
                    ->groupBy('tests.id')
                    ->orderByDesc('taking_count');
                break;

            case 'alphabet_asc':
                $query->orderBy('title');
                break;

            case 'alphabet_desc':
                $query->orderBy('title', 'desc');
                break;

            case 'new_test':
                $query->orderBy('created_at', 'desc');
                break;

            default:
                $query->orderBy('title');
                break;
        }
    }
}
