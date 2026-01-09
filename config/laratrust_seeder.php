<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => false,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [
        'superadmin' => [
            'users' => 'c,r,u,d',
            'media_managers' => 'c,r,u,d',
            'role' => 'c,r,u,d',
            'our_team' => 'c,r,u,d',
            'content_management' => 'c,r,u,d',
            'member_management' => 'c,r,u,d',
            'event_management' => 'c,r,u,d',
            'news_management' => 'c,r,u,d',
            'nomination_management' => 'c,r,u,d',
            'election_management' => 'c,r,u,d',
        ],
        'admin' => [
            'users' => 'c,r,u,d',
            'media_managers' => 'c,r,u,d',
            'role' => 'c,r,u,d',
            'our_team' => 'c,r,u,d',
        ],
    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
    ],
];
