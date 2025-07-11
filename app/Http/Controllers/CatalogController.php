<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\IndexCatalogRequest;
use App\Models\Group;
use App\Notifications\TelegramNotification;
use App\Services\CatalogManager;
use Coderflex\LaravelTurnstile\Rules\TurnstileCheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class CatalogController extends Controller
{
    protected CatalogManager $catalogManager;

    public function __construct(CatalogManager $catalogManager)
    {
        $this->catalogManager = $catalogManager;
    }

    public function index(IndexCatalogRequest $request)
    {
        $validated = $request->validated();

        $categories = $this->catalogManager->getCategories();
        $testsData = $this->catalogManager->getTests($validated);

        return view('catalog.index', [
            'categories' => $categories,
            'tests' => $testsData['tests'],
            'selectedTagName' => $testsData['selectedTagName'],
            'selectedAuthorName' => $testsData['selectedAuthorName'],
            'q' => $validated['q'] ?? '',
            'categoryId' => $validated['category_id'] ?? null,
            'tagId' => $validated['tag_id'] ?? null,
            'authorId' => $validated['author_id'] ?? null,
            'sortBy' => $validated['sort_by'] ?? 'popular_month',
        ]);

    }

    public function openTags(Request $request)
    {
        $filters = $request->only(['tag_id', 'q']);
        $tagsData = $this->catalogManager->getTags($filters);

        return view('catalog.tags', [
            'tags' => $tagsData['tags'],
            'q' => $filters['q'] ?? '',
            'tagId' => $filters['tag_id'] ?? null,
        ]);
    }

    public function openAuthors(Request $request)
    {
        $filters = $request->only(['q', 'sort_by']);
        $authorsData = $this->catalogManager->getAuthors($filters);

        return view('catalog.authors', [
            'authors' => $authorsData['authors'],
            'q' => $filters['q'] ?? '',
            'sortBy' => $filters['sort_by'] ?? 'popular',
        ]);
    }

    public function groupsTests()
    {
        $groups = $this->catalogManager->getGroupsTests();

        return view('catalog.groups', compact('groups'));
    }

    public function openGroupTests($slug)
    {
        $group = Group::where('slug', $slug)->firstOrFail();

        $tests = $group->tests;

        return view('catalog.groupTests', compact('tests', 'group'));
    }

    public function openPageCreateTest()
    {
        return view('catalog.create');
    }

    public function openPageAboutProject()
    {
        return view('catalog.project');
    }

    public function openPageContact()
    {
        return view('catalog.contact');
    }

    public function feedbackSend(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
            'cf-turnstile-response' => env('TURNSTILE_ENABLED')
                ? ['required', new TurnstileCheck()]
                : ['nullable'],
        ]);

        $message = "💬 Новое сообщение с сайта: \n\n";
        $message .= "Имя: {$data['name']}\n";
        $message .= "Email: {$data['email']}\n";
        $message .= "Сообщение: {$data['message']}\n";

        Notification::route('telegram', config('services.telegram-bot-api.channel_id'))
            ->notify(new TelegramNotification($message));

        return back()->with('success', $data['name'] . ',' . ' Ваше сообщение отправлено!');
    }
}
