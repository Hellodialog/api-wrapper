<?php
namespace Hellodialog\ApiWrapper\Mail;

use Hellodialog\ApiWrapper\Contracts\HelloDialogHandlerInterface;
use Illuminate\Mail\Transport\Transport;
use Swift_Mime_Message;

class HelloDialogTransport extends Transport
{

    /**
     * @var HelloDialogHandlerInterface
     */
    protected $handler;

    /**
     * @var Swift_Mime_Message
     */
    protected $message;

    /**
     * @param HelloDialogHandlerInterface $handler
     */
    public function __construct(HelloDialogHandlerInterface $handler)
    {
        $this->handler = $handler;
    }

    /**
     * {@inheritdoc}
     */
    public function send(Swift_Mime_Message $message, &$failedRecipients = null)
    {
        $this->message = $message;

        $subject    = $message->getSubject();
        $templateId = $this->getTemplateId();
        $from       = $this->getFrom();
        $replaces   = $this->buildReplaces();

        $success = 0;

        $to = $message->getTo();

        if ( ! $to) {
            throw new \InvalidArgumentException('No to-address set for send()');
        }

        foreach ($to as $toAddress => $toName) {
            if ($this->handler->transactional($toAddress, $subject, $templateId, $from, $replaces) ) {
                $success++;
            }
        }

        return $success;
    }

    /**
     * Returns normalized from array for HelloDialog API
     * 
     * @return \string[]
     */
    protected function getFrom()
    {
        $from = $this->message->getFrom();

        if ($from && count($from)) {

            // first entry is the 'from' (address => name)
            $from = [
                'email' => array_keys($from)[0],
                'name'  => array_values($from)[0]
            ];

        } else {
            $from = config('hellodialog.mail.sender') ?: config('hellodialog.sender');
        }
        
        return $from;
    }

    /**
     * @return int
     */
    protected function getTemplateId()
    {
        return (int) (config('hellodialog.mail.template') ?: config('hellodialog.default_template'));
    }

    /**
     * @return array
     */
    protected function buildReplaces()
    {
        $replaceKeys = config('hellodialog.mail.replaces');

        return [
            array_get($replaceKeys, 'title', '__TITLE__')     => $this->message->getSubject(),
            array_get($replaceKeys, 'content', '__CONTENT__') => $this->message->getBody()
        ];
    }

}
