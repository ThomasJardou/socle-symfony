<?php


namespace App\Domain\Auth;


use App\Domain\Auth\Interface\AuthServiceInterface;
use App\Domain\Auth\Validators\RegistrationValidator;
use App\Domain\Core\Interface\RoleRepositoryInterface;
use App\Domain\MainService;
use App\Domain\Utilisateurs\Entity\Utilisateur;
use App\Domain\Utilisateurs\Interface\UtilisateurServiceInterface;
use App\Domain\Utilisateurs\UtilisateursService;
use App\Infrastructure\Mailer\Mailer;
use App\Infrastructure\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AuthService extends MainService
{
    public function __construct(
        EntityManagerInterface $em,
        EventDispatcherInterface $dispatcher,
        private UtilisateursService $utilisateurService,
        private EmailVerifier $emailVerifier,
        private RoleRepositoryInterface $roleRepository,
        private UserPasswordEncoderInterface $passwordEncoder,
        private SerializerInterface $serializer)
    {
        $this->em = $em;
        $this->dispatcher = $dispatcher;
    }

    public function register(array $data): Utilisateur
    {
        RegistrationValidator::register($data);
        $item = new Utilisateur();
        $data['password'] = $this->passwordEncoder->encodePassword($item, $data['password']);

        /** @var Utilisateur $item */
        $item =  $this->serializer->fromArray(
            $data,
            Utilisateur::class
        );
        $item->addRole($this->roleRepository->getWithSlug(Utilisateur::ROLE_MEMBRE));

        $this->em->persist($item);
        $this->em->flush();


        $this->emailVerifier->sendEmailConfirmation('auth-verify_email', $item,
            (new TemplatedEmail())
                ->from(new Address('no-reply@pixelads.fr', 'PixelAds - Adopte un Projet'))
                ->to($item->getEmail())
                ->subject('Merci de confirmer votre identité !')
                ->htmlTemplate('mails/auth/register.html.twig')
        );
        return $item;
    }
}