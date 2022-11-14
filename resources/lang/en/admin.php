<?php

return [
    'admin-user' => [
        'title' => 'Users',

        'actions' => [
            'index' => 'Users',
            'create' => 'New User',
            'edit' => 'Edit :name',
            'edit_profile' => 'Edit Profile',
            'edit_password' => 'Edit Password',
        ],

        'columns' => [
            'id' => 'ID',
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
            'password_repeat' => 'Password Confirmation',
            'activated' => 'Activated',
            'forbidden' => 'Forbidden',
            'language' => 'Language',
                
            //Belongs to many relations
            'roles' => 'Roles',
                
        ],
    ],

    'server' => [
        'title' => 'Servers',

        'actions' => [
            'index' => 'Servers',
            'create' => 'New Server',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'base_url' => 'Base url',
            'sec_secret' => 'Sec secret',
            'weight' => 'Weight',
            'enabled' => 'Enabled',
            
        ],
    ],

    'server-meeting' => [
        'title' => 'Server Meetings',
        'create-disabled' => 'You are not allowed to create new meeting',

        'actions' => [
            'index' => 'Server Meetings',
            'create' => 'New Server Meeting',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'server_id' => 'Server',
            'meeting_id' => 'Meeting',
            'meeting_name' => 'Meeting name',
            'status' => 'Status',
            'start_time' => 'Start time',
            
        ],
    ],

    'custom' => [
        'HOU' => 'Ha Noi Open University'
    ]

    // Do not delete me :) I'm used for auto-generation
];
