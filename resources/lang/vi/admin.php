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
            'username' => 'Username',
            'last_name' => 'Last name',
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
            'create' => 'Thêm server',
            'edit' => 'Sửa :name',
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
        'create-disabled' => 'Bạn không thể thêm một cuộc họp mới',

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
        'HOU' => 'Trường Đại học Mở Hà Nội'
    ]

    // Do not delete me :) I'm used for auto-generation
];
