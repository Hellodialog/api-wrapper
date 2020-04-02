<?php
    namespace Hellodialog\ApiWrapper\config;

    $app = require_once ('../bootstrap/app.php');
    use \Hellodialog\ApiWrapper\HelloDialogServiceProvider;

    $serviceProvider = new HelloDialogServiceProvider($app);
    $serviceProvider->register();

    class Hellodialog {
        protected $token;
        protected $sender;
        protected $mail;
        protected $defaultTemplate;
        protected $templates;
        protected $debug;
        protected $queue;
        protected $url;
        protected $mock;
        protected $client;

        /**
         * Hellodialog constructor.
         */
        public function __construct()
        { /*
            |--------------------------------------------------------------------------
            | Hello Dialog API location
            |--------------------------------------------------------------------------
            |
            | The Hello Dialog API address.
            | Requires a trailing slash.
            |
            */

            $this->url = 'http://app.dev.hellodialog.com/api';

            /*
            |--------------------------------------------------------------------------
            | Hello Dialog API Key
            |--------------------------------------------------------------------------
            |
            | The Hello Dialog API expects this token for the account to which the
            | app is registered. It should be a 32 character hexadecimal string
            |
            */

            $this->token = 'fe1195de793627ab0b0e6e036c6e3a1c';

            /*
            |--------------------------------------------------------------------------
            | Sender / From Details
            |--------------------------------------------------------------------------
            |
            | The sender that will be used when the HelloDialog transactional mails
            | are sent out. This should probably be a standard no-reply address.
            |
            */

            $this->sender = ['email' => 'api@hellodialog.com',
                             'name' =>  'Your App name'];

            /*--------------------------------------------------------------------------*/

            /*
            |--------------------------------------------------------------------------
            | Mail Facade
            |--------------------------------------------------------------------------
            |
            | Configuration for using the Mail facade with the hellodialog driver
            |
            */

            $this->mail = [
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
            ];

            /*
            |--------------------------------------------------------------------------
            | Templates
            |--------------------------------------------------------------------------
            |
            | The default template set will be used when no template is given.
            | Other / custom templates may be defined here.
            |
            */

            $this->defaultTemplate = [ 'transactional',
                'templates' => [
                    'transactional' => [
                        'id' => 1,
                    ],
                ]
            ];

            /*
            |--------------------------------------------------------------------------
            | Queue
            |--------------------------------------------------------------------------
            |
            | Whether to send mail through the queue by default, or, if set to false,
            | to send synchronized instead.
            |
            */

            $this->queue = false;

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

            $this->debug = env('HELLODIALOG_DEBUG', false);
            $this->mock  = env('HELLODIALOG_MOCK', false);

            /*
            |--------------------------------------------------------------------------
            | Guzzle Client Options
            |--------------------------------------------------------------------------
            |
            | Global configuration of client options.
            |
            */

            $this->client = [
                'verify-ssl' => false,
            ];
        }


        /**
         * @return mixed
         */
        public function getUrl()
        {
            return $this->url;
        }

        /**
         * @param mixed $url
         * @return hellodialog
         */
        public function setUrl($url)
        {
            $this->url = $url;
            return $this;
        }

        /**
         * @return mixed
         */
        public function getToken()
        {
            return $this->token;
        }

        /**
         * @param mixed $token
         * @return hellodialog
         */
        public function setToken($token)
        {
            $this->token = $token;
            return $this;
        }

        /**
         * @return mixed
         */
        public function getSender()
        {
            return $this->sender;
        }

        /**
         * @param mixed $sender
         * @return hellodialog
         */
        public function setSender($sender)
        {
            $this->sender = $sender;
            return $this;
        }

        /**
         * @return mixed
         */
        public function getMail()
        {
            return $this->mail;
        }

        /**
         * @param mixed $mail
         * @return hellodialog
         */
        public function setMail($mail)
        {
            $this->mail = $mail;
            return $this;
        }

        /**
         * @return mixed
         */
        public function getDefaultTemplate()
        {
            return $this->defaultTemplate;
        }

        /**
         * @param mixed $defaultTemplate
         * @return hellodialog
         */
        public function setDefaultTemplate($defaultTemplate)
        {
            $this->defaultTemplate = $defaultTemplate;
            return $this;
        }

        /**
         * @return mixed
         */
        public function getTemplates()
        {
            return $this->templates;
        }

        /**
         * @param mixed $templates
         * @return hellodialog
         */
        public function setTemplates($templates)
        {
            $this->templates = $templates;
            return $this;
        }

        /**
         * @return mixed
         */
        public function getDebug()
        {
            return $this->debug;
        }

        /**
         * @param mixed $debug
         * @return hellodialog
         */
        public function setDebug($debug)
        {
            $this->debug = $debug;
            return $this;
        }

        /**
         * @return mixed
         */
        public function getQueue()
        {
            return $this->queue;
        }

        /**
         * @param mixed $queue
         * @return hellodialog
         */
        public function setQueue($queue)
        {
            $this->queue = $queue;
            return $this;
        }

        /**
         * @return mixed
         */
        public function getMock()
        {
            return $this->mock;
        }

        /**
         * @param mixed $mock
         */
        public function setMock($mock)
        {
            $this->mock = $mock;
        }

        /**
         * @return array
         */
        public function getClient()
        {
            return $this->client;
        }

        /**
         * @param array $client
         */
        public function setClient($client)
        {
            $this->client = $client;
        }
    }