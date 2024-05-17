<?php
return [
    'menu' => [
        [
            'title' => 'Dashboard',
            'icon' => 'home',
            'route' => 'dashboard',
            'children' => [],
        ],
        [
            'title' => 'Production',
            'icon' => '',
            'children' => [
                [
                    'title' => 'Projects',
                    'route' => 'production.projects.index',
                    'icon' => 'bars-arrow-up',
                ],
                [
                    'title' => 'Developers',
                    'route' => 'production.developers.index',
                    'icon' => 'command-line',
                ],
            ],
        ],
        [
            'title' => 'Sales',
            'icon' => 'presentation-chart-line',
            'route' => 'sales.index',
            'children' => [],
        ],
        [
            'title' => 'Human Resources',
            'icon' => 'users',
            'route' => 'hr',
            'children' => [],
        ],
    ]
];
