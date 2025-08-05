<?php

return [
    'app' => [
        'name' => 'gimy.site',
        'made_by' => 'Made by mtex.dev',
    ],

    'nav' => [
        'dashboard' => 'Dashboard',
        'settings' => 'Settings',
        'login' => 'Login',
        'register' => 'Register',
        'logout' => 'Logout',
    ],

    'auth' => [
        'name' => 'Name',
        'email' => 'Email Address',
        'password' => 'Password',
        'confirm_password' => 'Confirm Password',
        'remember_me' => 'Remember me',
        'already_registered' => 'Already have an account?',
        'not_registered' => 'Don\'t have an account yet?',
    ],

    'dashboard' => [
        'title' => 'Dashboard',
        'welcome' => 'Welcome back, :name!',
        'no_sites' => 'You haven\'t created any sites yet.',
        'create_site' => 'Create Your First Site',
    ],

    'settings' => [
        'title' => 'User Settings',
        'locale' => [
            'heading' => 'Language Preferences',
            'label' => 'Default Application Language',
            'description' => 'Choose the language for your dashboard.',
        ],
        'danger_zone' => [
            'heading' => 'Danger Zone',
            'delete_account' => 'Delete Account',
            'delete_warning' => 'Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.',
            'delete_confirm' => 'Are you sure you want to delete your account?',
            'password_label' => 'Please enter your password to confirm.',
        ],
        'buttons' => [
            'save' => 'Save',
        ],
        'alerts' => [
            'updated' => 'Settings saved successfully.',
        ]
    ],
];
