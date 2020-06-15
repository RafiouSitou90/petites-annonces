<?php

namespace App\Security;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

class EmailVerifier
{
    /**
     * @var VerifyEmailHelperInterface
     */
    private VerifyEmailHelperInterface $verifyEmailHelper;
    /**
     * @var MailerInterface
     */
    private MailerInterface $mailer;
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * EmailVerifier constructor.
     * @param VerifyEmailHelperInterface $helper
     * @param MailerInterface $mailer
     * @param EntityManagerInterface $manager
     */
    public function __construct(VerifyEmailHelperInterface $helper, MailerInterface $mailer, EntityManagerInterface $manager)
    {
        $this->verifyEmailHelper = $helper;
        $this->mailer = $mailer;
        $this->entityManager = $manager;
    }

    /**
     * @param string $verifyEmailRouteName
     * @param UserInterface $user
     * @param TemplatedEmail $email
     * @throws TransportExceptionInterface
     */
    public function sendEmailConfirmation(
        string $verifyEmailRouteName,
        UserInterface $user,
        TemplatedEmail $email): void
    {
        /** @var Users $email_user */
        $email_user = $user;

        $signatureComponents = $this->verifyEmailHelper->generateSignature(
            $verifyEmailRouteName,
            $email_user->getId(),
            $email_user->getEmail()
        );

        $context = $email->getContext();
        $context['signedUrl'] = $signatureComponents->getSignedUrl();
        $context['expiresAt'] = $signatureComponents->getExpiresAt();

        $email->context($context);

        $this->mailer->send($email);
    }

    /**
     * @param Request $request
     * @param UserInterface $user
     * @throws VerifyEmailExceptionInterface
     */
    public function handleEmailConfirmation(Request $request, UserInterface $user): void
    {
        /** @var Users $email_user */
        $email_user = $user;
        $this->verifyEmailHelper->validateEmailConfirmation($request->getUri(), $email_user->getId(), $email_user->getEmail());

        $email_user->setIsVerified(true);

        $this->entityManager->persist($email_user);
        $this->entityManager->flush();
    }
}
