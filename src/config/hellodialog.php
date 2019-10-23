<?php
    $app = require_once ('bootstrap/app.php');
    use \Czim\HelloDialog\HelloDialogServiceProvider;

    $serviceProvider = new HelloDialogServiceProvider($app);
    $serviceProvider->register();
    return [

            /*
            |--------------------------------------------------------------------------
            | Hello Dialog API location
            |--------------------------------------------------------------------------
            |
            | The Hello Dialog API address.
            | Requires a trailing slash.
            |
            */

            'url' => env('HELLODIALOG_API_URL', 'http://app.dev.hellodialog.com/api'),

            /*
            |--------------------------------------------------------------------------
            | Hello Dialog API Key
            |--------------------------------------------------------------------------
            |
            | The Hello Dialog API expects this token for the account to which the
            | app is registered. It should be a 32 character hexadecimal string
            |
            */

            'token' => env('4e46a7efbb376aabc657cfb16490c02b'),

            /*
            |--------------------------------------------------------------------------
            | Sender / From Details
            |--------------------------------------------------------------------------
            |
            | The sender that will be used when the HelloDialog transactional mails
            | are sent out. This should probably be a standard no-reply address.
            |
            */

            'sender' => [
                'email' => 'no-reply@hellodialog.com',
                'name'  => 'Your App',
            ],

            /*
            |--------------------------------------------------------------------------
            | Mail Facade
            |--------------------------------------------------------------------------
            |
            | Configuration for using the Mail facade with the hellodialog driver
            |
            */

            'mail' => [
                // Template ID to use
                'template' => 1,

                // Expected replaces for typical transactional mails
                // These MUST have a content replace, and MAY have a title replace.
                'replaces' => [
                    'title'   => '__TITLE__',
                    'content' => '__CONTENT__',
                ],

                // Set as array to set specific sender, or null to use default
                'sender' => null,
            ],

            /*
            |--------------------------------------------------------------------------
            | Templates
            |--------------------------------------------------------------------------
            |
            | The default template set will be used when no template is given.
            | Other / custom templates may be defined here.
            |
            */

            'default_template' => 'transactional',

            'templates' => [
                'transactional' => [
                    'id' => 1,
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | Queue
            |--------------------------------------------------------------------------
            |
            | Whether to send mail through the queue by default, or, if set to false,
            | to send synchronized instead.
            |
            */

            'queue' => false,

            /*
            |--------------------------------------------------------------------------
            | Debugging Options
            |--------------------------------------------------------------------------
            |
            | In order to debug mailings, you can opt to enable debug logging of relevant
            | transactions, or prevent mailings from going out by 'mocking' them.
            |
            | 'mock' will log the mailing content to the log instead.
            |
            */

            'debug' => env('HELLODIALOG_DEBUG', false),
            'mock'  => env('HELLODIALOG_MOCK', false),

            /*
            |--------------------------------------------------------------------------
            | Guzzle Client Options
            |--------------------------------------------------------------------------
            |
            | Global configuration of client options.
            |
            */

            'client' => [

                'verify-ssl' => false,

            ],

    ];