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
            'title' => 'Human Resources',
            'icon' => '',
            'children' => [
                [
                    'title' => 'Developers',
                    'route' => 'hr.developers',
                    'icon' => 'ellipsis-vertical',
                ],
                [
                    'title' => 'Salesforce',
                    'route' => 'hr.salesforce',
                    'icon' => 'ellipsis-vertical',
                ],
            ],
        ],
        [
            'title' => 'Sales',
            'icon' => 'users',
            'route' => 'sales.index',
            'children' => [],
        ],
    ]
];
