<?php

declare(strict_types=1);

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Breadcrumbs::for('instruction', function (BreadcrumbTrail $trail) {
    $trail->push(__('common.instruction'), route('instruction'));
});

Breadcrumbs::for('profile', function (BreadcrumbTrail $trail) {
    $trail->push(__('common.profile'), route('profile'));
});

Breadcrumbs::for('profile.notifications', function (BreadcrumbTrail $trail) {
    $trail->parent('profile');
    $trail->push(__('common.notifications'), route('profile.notifications'));
});

Breadcrumbs::for('admin.users.index', function (BreadcrumbTrail $trail) {
    $trail->push(__('common.users'), route('admin.users.index'));
});

Breadcrumbs::for('admin.users.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.users.index');
    $trail->push(__('common.create user'), route('admin.users.create'));
});

Breadcrumbs::for('admin.users.show', function (BreadcrumbTrail $trail, $user) {
    $trail->parent('admin.users.index');
    $trail->push("{$user->name}", route('admin.users.show', $user));
});

Breadcrumbs::for('admin.users.edit', function (BreadcrumbTrail $trail, $user) {
    $trail->parent('admin.users.show', $user);
    $trail->push(__('common.edit'), route('admin.users.edit', $user));
});

Breadcrumbs::for('admin.groups.index', function (BreadcrumbTrail $trail) {
    $trail->push(__('common.groups'), route('admin.groups.index'));
});
Breadcrumbs::for('admin.groups.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.groups.index');
    $trail->push(__('common.create group'), route('admin.groups.create'));
});
Breadcrumbs::for('admin.groups.show', function (BreadcrumbTrail $trail, $group) {
    $trail->parent('admin.groups.index');
    $trail->push("{$group->title}", route('admin.groups.show', $group));
});

Breadcrumbs::for('admin.groups.edit', function (BreadcrumbTrail $trail, $group) {
    $trail->parent('admin.groups.show', $group);
    $trail->push(__('common.edit group'), route('admin.groups.edit', $group));
});

Breadcrumbs::for('admin.categories.index', function (BreadcrumbTrail $trail) {
    $trail->push(__('common.categories'), route('admin.categories.index'));
});

Breadcrumbs::for('admin.categories.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.categories.index');
    $trail->push(__('common.create category'), route('admin.categories.create'));
});

Breadcrumbs::for('admin.categories.show', function (BreadcrumbTrail $trail, $category) {
    $trail->parent('admin.categories.index');
    $trail->push("{$category->title}", route('admin.categories.show', $category));
});

Breadcrumbs::for('admin.categories.edit', function (BreadcrumbTrail $trail, $category) {
    $trail->parent('admin.categories.show', $category);
    $trail->push(__('common.edit'), route('admin.categories.edit', $category));
});

Breadcrumbs::for('admin.tests.index', function (BreadcrumbTrail $trail) {
    $trail->push(__('common.tests'), route('admin.tests.index'));
});

Breadcrumbs::for('admin.tests.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.tests.index');
    $trail->push(__('common.create test'), route('admin.tests.create'));
});

Breadcrumbs::for('admin.tests.show', function (BreadcrumbTrail $trail, $test) {
    $trail->parent('admin.tests.index');
    $trail->push("{$test->title}", route('admin.tests.show', $test));
});

Breadcrumbs::for('admin.tests.edit', function (BreadcrumbTrail $trail, $test) {
    $trail->parent('admin.tests.show', $test);
    $trail->push(__('common.edit'), route('admin.tests.edit', $test));
});

Breadcrumbs::for('admin.tests.questions.create', function (BreadcrumbTrail $trail, $test) {
    $trail->parent('admin.tests.show', $test);
    $trail->push(__('common.create question'), route('admin.tests.questions.create', [
        'test_id' => $test->id,
    ]));
});

Breadcrumbs::for('admin.tests.questions.show', function (BreadcrumbTrail $trail, $question) {
    $trail->parent('admin.tests.show', $question->test);
    $trail->push(__('common.question №') . "{$question->number}", route('admin.tests.questions.show', $question));
});

Breadcrumbs::for('admin.tests.questions.answers.show', function (BreadcrumbTrail $trail, $answer) {
    $trail->parent('admin.tests.questions.show', $answer->question);
    $trail->push(__('common.answer №') . "{$answer->number}", route('admin.tests.questions.answers.show', $answer));
});

Breadcrumbs::for('admin.tests.questions.answers.reactions.create', function (BreadcrumbTrail $trail, $answer) {
    $trail->parent('admin.tests.questions.answers.show', $answer);
    $trail->push(__('common.create reaction'), route('admin.tests.questions.answers.reactions.create', [
        'answer_id' => $answer->id,
    ]));
});

Breadcrumbs::for('admin.tests.questions.answers.reactions.show', function (BreadcrumbTrail $trail, $reaction) {
    $trail->parent('admin.tests.questions.answers.show', $reaction->answer);
    $trail->push("  {$reaction->variable->name}", route('admin.tests.questions.answers.reactions.show', $reaction));
});

Breadcrumbs::for('admin.tests.questions.answers.reactions.edit', function (BreadcrumbTrail $trail, $reaction) {
    $trail->parent('admin.tests.questions.answers.show', $reaction->answer);
    $trail->push(__('common.editing'), route('admin.tests.questions.answers.reactions.edit', $reaction));
});

Breadcrumbs::for('admin.tests.questions.answers.edit', function (BreadcrumbTrail $trail, $answer) {
    $trail->parent('admin.tests.questions.show', $answer->question);
    $trail->push(__('common.editing answer №') . "{$answer->number}", route('admin.tests.questions.answers.edit', $answer));
});

Breadcrumbs::for('admin.tests.questions.answers.create', function (BreadcrumbTrail $trail, $question) {
    $trail->parent('admin.tests.questions.show', $question);
    $trail->push(__('common.create answer'), route('admin.tests.questions.answers.create', [
        'question_id' => $question->id,
    ]));
});

Breadcrumbs::for('admin.tests.questions.edit', function (BreadcrumbTrail $trail, $question) {
    $trail->parent('admin.tests.show', $question->test);
    $trail->push(__('common.editing question №') . "{$question->number}", route('admin.tests.questions.edit', $question));
});

Breadcrumbs::for('admin.tests.variables.create', function (BreadcrumbTrail $trail, $test) {
    $trail->parent('admin.tests.show', $test);
    $trail->push(__('common.create variable'), route('admin.tests.variables.create', [
        'test_id' => $test->id,
    ]));
});

Breadcrumbs::for('admin.tests.variables.show', function (BreadcrumbTrail $trail, $variable) {
    $trail->parent('admin.tests.show', $variable->test);
    $trail->push("{$variable->name}", route('admin.tests.variables.show', $variable));
});

Breadcrumbs::for('admin.tests.variables.edit', function (BreadcrumbTrail $trail, $variable) {
    $trail->parent('admin.tests.show', $variable->test);
    $trail->push(__('common.editing variable'), route('admin.tests.variables.edit', $variable));
});

Breadcrumbs::for('admin.tests.results.create', function (BreadcrumbTrail $trail, $test) {
    $trail->parent('admin.tests.show', $test);
    $trail->push(__('common.create result'), route('admin.tests.results.create', [
        'test_id' => $test->id,
    ]));
});

Breadcrumbs::for('admin.tests.results.show', function (BreadcrumbTrail $trail, $result) {
    $trail->parent('admin.tests.show', $result->test);
    $trail->push(__('common.result'), route('admin.tests.results.show', $result));
});

Breadcrumbs::for('admin.tests.results.edit', function (BreadcrumbTrail $trail, $result) {
    $trail->parent('admin.tests.show', $result->test);
    $trail->push(__('common.editing result'), route('admin.tests.results.edit', $result));
});

Breadcrumbs::for('admin.moderations.index', function (BreadcrumbTrail $trail) {
    $trail->push(__('common.moderation'), route('admin.moderations.index'));
});

Breadcrumbs::for('admin.themes.index', function (BreadcrumbTrail $trail) {
    $trail->push(__('common.themes'), route('admin.themes.index'));
});

Breadcrumbs::for('admin.themes.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.themes.index');
    $trail->push(__('common.create theme'), route('admin.themes.create'));
});

Breadcrumbs::for('admin.themes.show', function (BreadcrumbTrail $trail, $theme) {
    $trail->parent('admin.themes.index');
    $trail->push("{$theme->title}", route('admin.themes.show', $theme));
});

Breadcrumbs::for('admin.themes.edit', function (BreadcrumbTrail $trail, $theme) {
    $trail->parent('admin.themes.show', $theme);
    $trail->push(__('common.edit'), route('admin.themes.edit', $theme));
});

Breadcrumbs::for('admin.audits.index', function (BreadcrumbTrail $trail) {
    $trail->push(__('common.audit'), route('admin.audits.index'));
});

Breadcrumbs::for('author.tests.index', function (BreadcrumbTrail $trail) {
    $trail->push(__('common.tests'), route('author.tests.index'));
});

Breadcrumbs::for('author.tests.create', function (BreadcrumbTrail $trail) {
    $trail->parent('author.tests.index');
    $trail->push(__('common.create test'), route('author.tests.create'));
});

Breadcrumbs::for('author.tests.show', function (BreadcrumbTrail $trail, $test) {
    $trail->parent('author.tests.index');
    $trail->push("{$test->title}", route('author.tests.show', $test));
});

Breadcrumbs::for('author.tests.edit', function (BreadcrumbTrail $trail, $test) {
    $trail->parent('author.tests.show', $test);
    $trail->push(__('common.edit'), route('author.tests.edit', $test));
});

Breadcrumbs::for('author.tests.questions.create', function (BreadcrumbTrail $trail, $test) {
    $trail->parent('author.tests.show', $test);
    $trail->push(__('common.create question'), route('author.tests.questions.create', [
        'test_id' => $test->id,
    ]));
});

Breadcrumbs::for('author.tests.questions.show', function (BreadcrumbTrail $trail, $question) {
    $trail->parent('author.tests.show', $question->test);
    $trail->push(__('common.question №') . "{$question->number}", route('author.tests.questions.show', $question));
});

Breadcrumbs::for('author.tests.questions.answers.show', function (BreadcrumbTrail $trail, $answer) {
    $trail->parent('author.tests.questions.show', $answer->question);
    $trail->push(__('common.answer №') . "{$answer->number}", route('author.tests.questions.answers.show', $answer));
});

Breadcrumbs::for('author.tests.questions.answers.reactions.create', function (BreadcrumbTrail $trail, $answer) {
    $trail->parent('author.tests.questions.answers.show', $answer);
    $trail->push(__('common.create reaction'), route('author.tests.questions.answers.reactions.create', [
        'answer_id' => $answer->id,
    ]));
});

Breadcrumbs::for('author.tests.questions.answers.reactions.show', function (BreadcrumbTrail $trail, $reaction) {
    $trail->parent('author.tests.questions.answers.show', $reaction->answer);
    $trail->push("  {$reaction->variable->name}", route('author.tests.questions.answers.reactions.show', $reaction));
});

Breadcrumbs::for('author.tests.questions.answers.reactions.edit', function (BreadcrumbTrail $trail, $reaction) {
    $trail->parent('author.tests.questions.answers.show', $reaction->answer);
    $trail->push(__('common.editing'), route('author.tests.questions.answers.reactions.edit', $reaction));
});

Breadcrumbs::for('author.tests.questions.answers.edit', function (BreadcrumbTrail $trail, $answer) {
    $trail->parent('author.tests.questions.show', $answer->question);
    $trail->push(__('common.editing answer №') . "{$answer->number}", route('author.tests.questions.answers.edit', $answer));
});

Breadcrumbs::for('author.tests.questions.answers.create', function (BreadcrumbTrail $trail, $question) {
    $trail->parent('author.tests.questions.show', $question);
    $trail->push(__('common.create answer'), route('author.tests.questions.answers.create', [
        'question_id' => $question->id,
    ]));
});

Breadcrumbs::for('author.tests.questions.edit', function (BreadcrumbTrail $trail, $question) {
    $trail->parent('author.tests.show', $question->test);
    $trail->push(__('common.editing question №') . "{$question->number}", route('author.tests.questions.edit', $question));
});

Breadcrumbs::for('author.tests.variables.create', function (BreadcrumbTrail $trail, $test) {
    $trail->parent('author.tests.show', $test);
    $trail->push(__('common.create variable'), route('author.tests.variables.create', [
        'test_id' => $test->id,
    ]));
});

Breadcrumbs::for('author.tests.variables.show', function (BreadcrumbTrail $trail, $variable) {
    $trail->parent('author.tests.show', $variable->test);
    $trail->push("{$variable->name}", route('author.tests.variables.show', $variable));
});

Breadcrumbs::for('author.tests.variables.edit', function (BreadcrumbTrail $trail, $variable) {
    $trail->parent('author.tests.show', $variable->test);
    $trail->push(__('common.editing variable'), route('author.tests.variables.edit', $variable));
});

Breadcrumbs::for('author.tests.results.create', function (BreadcrumbTrail $trail, $test) {
    $trail->parent('author.tests.show', $test);
    $trail->push(__('common.create result'), route('author.tests.results.create', [
        'test_id' => $test->id,
    ]));
});

Breadcrumbs::for('author.tests.results.show', function (BreadcrumbTrail $trail, $result) {
    $trail->parent('author.tests.show', $result->test);
    $trail->push(__('common.result'), route('author.tests.results.show', $result));
});

Breadcrumbs::for('author.tests.results.edit', function (BreadcrumbTrail $trail, $result) {
    $trail->parent('author.tests.show', $result->test);
    $trail->push(__('common.editing result'), route('author.tests.results.edit', $result));
});
