<?php

return [
    'modules' => [
        'capabilities' => [
            'name' => 'Capacidades',
            'color' => '#6E795A',
            'icon' => 'mdiLightbulbOnOutline',
        ],
        'requirements' => [
            'name' => 'Necesidades',
            'color' => '#832B56',
            'icon' => 'mdiHandCoin',
        ],
        'conferences' => [
            'name' => 'Conferencias',
            'color' => '#C79B71',
            'icon' => 'mdiPresentation',
        ],
        'technologyServices' => [
            'name' => 'Servicios Tec.',
            'color' => '#283C2A',
            'icon' => 'mdiCogOutline',
        ],
        'jobOffers' => [
            'name' => 'Ofertas Lab.',
            'color' => '#581D3A',
            'icon' => 'mdiBriefcaseOutline',
        ],
    ],

    'roles' => [
        'Institución' => [
            'label' => 'IES/CI',
            'color' => '#6E795A',
        ],
        'Academico' => [
            'label' => 'Académico',
            'color' => '#C79B71',
        ],
        'Empresa' => [
            'label' => 'Empresa',
            'color' => '#832B56',
        ],
        'Organización No Gubernamental' => [
            'label' => 'ONG',
            'color' => '#581D3A',
        ],
        'Dependencia de gobierno' => [
            'label' => 'Gobierno',
            'color' => '#283C2A',
        ],
    ],

    'duration' => [
        'max_session_seconds' => 1800,
        'min_session_seconds' => 5,
        'heartbeat_interval' => 30,
    ],

    'publications' => [
        'types' => [
            'capability' => [
                'label' => 'Capacidad',
                'label_plural' => 'Capacidades',
                'color' => '#6E795A',
            ],
            'requirement' => [
                'label' => 'Necesidad',
                'label_plural' => 'Necesidades',
                'color' => '#832B56',
            ],
        ],

        'pie_colors' => [
            '#6E795A',
            '#565E46',
            '#436547',
            '#C79B71',
            '#B77E48',
            '#8E6238',
            '#A3A081',
            '#827F5F',
            '#832B56',
            '#581D3A',
            '#F4F4F4',
            '#86857E',
        ],
    ],
    'snii' => [
        'gender' => [
            'male'   => '#6E795A',
            'female' => '#832B56',
        ],
    ],
];
