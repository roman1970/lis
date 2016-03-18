<?php
return [
    'user' => [
        'type' => 1,
        'description' => 'Пользователь',
        'ruleName' => 'roman',
    ],
    'moder' => [
        'type' => 1,
        'description' => 'Модератор',
        'ruleName' => 'roman',
        'children' => [
            'user',
        ],
    ],
    'admin' => [
        'type' => 1,
        'description' => 'Администратор',
        'ruleName' => 'roman',
        'children' => [
            'moder',
        ],
    ],
];
