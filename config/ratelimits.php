<?php

declare(strict_types=1);

return [
    'author.tests.store' => [
        'limit' => 10,
        'minutes' => 1440,
        'message' => 'Вы превысили лимит на создание тестов (:limit: в день).',
    ],
    'author.tests.update' => [
        'limit' => 200,
        'minutes' => 1440,
        'message' => 'Вы превысили лимит на обновление тестов (:limit: в день).',
    ],
    'author.tests.destroy' => [
        'limit' => 10,
        'minutes' => 1440,
        'message' => 'Вы превысили лимит на удаление тестов (:limit: в день).',
    ],
    'author.tests.restore' => [
        'limit' => 10,
        'minutes' => 1440,
        'message' => 'Вы превысили лимит на восстановление тестов (:limit: в день).',
    ],
    'author.tests.submit_moderation' => [
        'limit' => 10,
        'minutes' => 1440,
        'message' => 'Вы превысили лимит на отправку тестов на модерацию (:limit: в день).',
    ],
    'author.tests.return_draft' => [
        'limit' => 10,
        'minutes' => 1440,
        'message' => 'Вы превысили лимит на возвращение тестов в черновик (:limit: в день).',
    ],
    'author.tests.questions.store' => [
        'limit' => 200,
        'minutes' => 1440,
        'message' => 'Вы превысили лимит на создание вопросов (:limit: в день).',
    ],
    'author.tests.questions.update' => [
        'limit' => 600,
        'minutes' => 1440,
        'message' => 'Вы превысили лимит на редактирование вопросов (:limit: в день).',
    ],
    'author.tests.questions.destroy' => [
        'limit' => 200,
        'minutes' => 1440,
        'message' => 'Вы превысили лимит на удаление вопросов (:limit: в день).',
    ],
    'author.tests.questions.restore' => [
        'limit' => 200,
        'minutes' => 1440,
        'message' => 'Вы превысили лимит на восстановление вопросов (:limit: в день).',
    ],
    'author.tests.question_sequence' => [
        'limit' => 100,
        'minutes' => 1440,
        'message' => 'Вы превысили лимит на изменение порядка вопросов (:limit: в день).',
    ],
    'author.tests.result_sequence' => [
        'limit' => 100,
        'minutes' => 1440,
        'message' => 'Вы превысили лимит на изменение порядка результатов (:limit: в день).',
    ],
    'author.tests.questions.answer_sequence' => [
        'limit' => 100,
        'minutes' => 1440,
        'message' => 'Вы превысили лимит на изменение порядка ответов (:limit: в день).',
    ],
    'author.tests.questions.answers.store' => [
        'limit' => 1000,
        'minutes' => 1440,
        'message' => 'Вы превысили лимит на создание ответов (:limit: в день).',
    ],
    'author.tests.questions.answers.update' => [
        'limit' => 500,
        'minutes' => 1440,
        'message' => 'Вы превысили лимит на обновление ответов (:limit: в день).',
    ],
    'author.tests.questions.answers.destroy' => [
        'limit' => 500,
        'minutes' => 1440,
        'message' => 'Вы превысили лимит на удаление ответов (:limit: в день).',
    ],
    'author.tests.questions.answers.restore' => [
        'limit' => 500,
        'minutes' => 1440,
        'message' => 'Вы превысили лимит на восстановление ответов (:limit: в день).',
    ],

    'author.tests.variables.store' => [
        'limit' => 100,
        'minutes' => 1440,
        'message' => 'Вы превысили лимит на создание переменных (:limit: в день).',
    ],
    'author.tests.variables.update' => [
        'limit' => 200,
        'minutes' => 1440,
        'message' => 'Вы превысили лимит на редактирование переменных (:limit: в день).',
    ],
    'author.tests.variables.destroy' => [
        'limit' => 100,
        'minutes' => 1440,
        'message' => 'Вы превысили лимит на удаление переменных (:limit: в день).',
    ],

    'author.tests.variables.restore' => [
        'limit' => 100,
        'minutes' => 1440,
        'message' => 'Вы превысили лимит на восстановление переменных (:limit: в день).',
    ],

    'author.tests.questions.answers.reactions.store' => [
        'limit' => 1000,
        'minutes' => 1440,
        'message' => 'Вы превысили лимит на создание реакции (:limit: в день).',
    ],
    'author.tests.questions.answers.reactions.update' => [
        'limit' => 500,
        'minutes' => 1440,
        'message' => 'Вы превысили лимит на обновление реакции (:limit: в день).',
    ],
    'author.tests.questions.answers.reactions.destroy' => [
        'limit' => 500,
        'minutes' => 1440,
        'message' => 'Вы превысили лимит на удаление реакции (:limit: в день).',
    ],
    'author.tests.results.store' => [
        'limit' => 150,
        'minutes' => 1440,
        'message' => 'Вы превысили лимит на создание результатов (:limit: в день).',
    ],
    'author.tests.results.update' => [
        'limit' => 300,
        'minutes' => 1440,
        'message' => 'Вы превысили лимит на обновление результатов (:limit: в день).',
    ],
    'author.tests.results.destroy' => [
        'limit' => 100,
        'minutes' => 1440,
        'message' => 'Вы превысили лимит на удаление результатов (:limit: в день).',
    ],
];
