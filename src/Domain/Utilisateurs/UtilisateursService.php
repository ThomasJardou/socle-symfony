<?php


namespace App\Domain\Utilisateurs;


use App\Domain\Annonces\Repository\AnnonceRepository;
use App\Domain\Auth\Validators\RegistrationValidator;
use App\Domain\Core\Interface\RoleRepositoryInterface;
use App\Domain\Core\Repository\RoleRepository;
use App\Domain\MainService;
use App\Domain\Utilisateurs\Entity\Utilisateur;
use App\Domain\Utilisateurs\Interface\UtilisateurServiceInterface;
use App\Domain\Utilisateurs\Query\UtilisateurQuery;
use App\Domain\Utilisateurs\Repository\UtilisateurRepository;
use App\Domain\Utilisateurs\Validator\UtilisateurValidator;
use App\Entity\Article;
use App\Infrastructure\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UtilisateursService extends MainService
{
    public function __construct(public EntityManagerInterface $em, public EventDispatcherInterface $dispatcher, private SerializerInterface $serializer, private EmailVerifier $emailVerifier,  public PaginatorInterface $paginator, private UtilisateurRepository $repository, private UserPasswordEncoderInterface $passwordEncoder, private RoleRepositoryInterface $roleRepository){}


    public function create(array $data): Utilisateur
    {
        UtilisateurValidator::create($data);
        $item = new Utilisateur();
        $data['password'] = $this->passwordEncoder->encodePassword($item, $data['password']);
        foreach ($data['roles'] as $key=>$role) {
            $roleToAdd = $this->roleRepository->find($role);
            $data['roles'][]= $this->serializer->toArray($roleToAdd);
            unset($data['roles'][$key]);
        }
        /** @var Utilisateur $item */
        $item =  $this->serializer->fromArray(
            $data,
            Utilisateur::class
        );

        $this->repository->create($item);


        $this->emailVerifier->sendEmailConfirmation('auth-verify_email', $item,
            (new TemplatedEmail())
                ->from(new Address('no-reply@pixelads.fr', 'PixelAds - Adopte un Projet'))
                ->to($item->getEmail())
                ->subject('Merci de confirmer votre identité !')
                ->htmlTemplate('mails/auth/register.html.twig')
        );
        return $item;
    }

    public function update(Utilisateur $item, array $data): Utilisateur
    {

        UtilisateurValidator::update($data);
        if (!empty($data['password'])){
            $data['password'] = $this->passwordEncoder->encodePassword($item, $data['password']);
        }else{
            unset($data['password']);
        }

        foreach ($data['roles'] as $key=>$role) {
            $roleToAdd = $this->roleRepository->find($role);
            $data['roles'][]= $this->serializer->toArray($roleToAdd);
            unset($data['roles'][$key]);
        }


        $item = $this->serializer->fromArray(
            array_merge($this->serializer->toArray($item), $data),
            Utilisateur::class
        );

        $this->repository->update($item);

        $this->emailVerifier->sendEmailConfirmation('auth-verify_email', $item,
            (new TemplatedEmail())
                ->from(new Address('no-reply@pixelads.fr', 'PixelAds - Adopte un Projet'))
                ->to($item->getEmail())
                ->subject('Merci de confirmer votre identité !')
                ->htmlTemplate('mails/auth/register.html.twig')
        );

        return $item;
    }

    public function delete(Utilisateur $item): Utilisateur
    {
        return $this->repository->delete($item);
    }

    public function list(UtilisateurQuery $query)
    {
        return $this->repository->list($query);
    }

    public function read(int $id): Utilisateur
    {
        return $this->repository->read($id);
    }
}