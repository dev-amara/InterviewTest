<?php

namespace App\Helpers\Utils;

use App\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Templating\EngineInterface;

class EmailSender
{
    /**
     * @var Mailer
     */
    protected $mailer;
    /**
     * @var EngineInterface
     */
    protected $template;
    /**
     * @var string
     */
    protected $prefixAdminConfirmUrl;
    /**
     * @var string
     */
    protected $prefixExpertConfirmUrl;

    public function __construct(
        Mailer $mailer,
        EngineInterface $template,
        ContainerInterface $container
    ) {
        $this->mailer = $mailer;

        $this->template = $template;
    }

    public function sendEmail($to, $user, $code)
    {
        $body = $this->template
            ->render(
                'mails/account_creation.html.twig',
                [
                    'user'=>$user,
                    'code'=>$code
                ]
            );

        return $this->mailer->send(
            $to,
            'Code de vérification',
            $body,
            'code_de_verification'
        );
    }

    public function sendEmailInvitationAccountCreation(User $user = null, $token = null) {
        $body = $this->template->render(
            'mails/account_creation_confirmation.html.twig',
            ['request'=>null, 'user'=>$user, 'token'=>$token]
        );

        return $this->mailer->send(
            $user->getEmail(),
            'Confirmation de la creation de compte!',
            $body,
            'confirmation_service_request'
        );
    }

}
