<?php

namespace App\Helpers\Utils;

use Psr\Log\LoggerInterface;
use Swift_Mailer;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class Mailer
{
    /**
     * @var Swift_Mailer
     */
    private $mailer;

    /**
     * @var EngineInterface
     */
    private $templating;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var string
     */
    private $noreply;

    /**
     * Mailer constructor.
     * @param Swift_Mailer $mailer
     * @param EngineInterface $templating
     * @param LoggerInterface $logger
     * @param string $noreply
     */
    public function __construct(
        Swift_Mailer $mailer,
        EngineInterface $templating,
        LoggerInterface $logger,
        string $noreply
    ) {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->logger = $logger;
        $this->noreply = $noreply;
    }


    public function send($to, $subject, $body, $messageId)
    {
        $failedRecipients = [];
        $message = (new Swift_Message($subject))
            ->setFrom($this->noreply, 'OEC-CI')
            ->setTo($to)
            ->setBody($body, 'text/html');
        $message->getHeaders()->addTextHeader('X-Message-ID', $messageId);

        return $this->mailer->send($message, $failedRecipients);
    }
}
