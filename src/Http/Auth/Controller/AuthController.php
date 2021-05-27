<?php declare(strict_types=1);

namespace App\Http\Auth\Controller;

use App\Domain\Auth\AuthService;
use App\Domain\Auth\Form\RegistrationFormType;
use App\Domain\Auth\Validators\RegistrationValidator;
use App\Domain\Utilisateurs\Entity\Utilisateur;
use App\Http\Controller\MainController;
use App\Infrastructure\Security\EmailVerifier;
use App\Validator\Exists;
use Assert\LazyAssertionException;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

#[Route('/auth', name: 'auth-')]
class AuthController extends MainController
{
    public function __construct(private EmailVerifier $emailVerifier, private AuthService $authService)
    {}

    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return Response::create("ok");
    }

    #[Route('/register', name: 'register')]
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        if ($request->isMethod('post')) {
            try {
                $this->authService->register($request->request->all());
                $this->addFlash('success', 'Merci de votre inscription, vous allez recevoir un mail avec un lien de confirmation de compte.');

                return $this->redirectToRoute('auth-login');
            }catch (LazyAssertionException $e){
                $formErrors = $e->getErrorExceptions();
            }catch (\Throwable $e) {
                $this->addFlash('danger', 'Une erreur est survenue pendant l\'enregistrement.');
            }
        }

        return $this->render('auth/registration/register.html.twig', [
            'formErrors' => $formErrors ?? [],
        ]);
    }

    #[Route('/verify/email', name: 'verify_email')]
    public function verifyUserEmail(Request $request): Response
    {
        $id = $request->get('id');

        if (null === $id) {
            return $this->redirectToRoute('auth-register');
        }


        $user = $this->authService->em->getRepository(Utilisateur::class)->find($id);

        if (null === $user) {
            return $this->redirectToRoute('auth-register');
        }

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $user);
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());
            return $this->redirectToRoute('auth-register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Vous pouvez désormais vous connecter, merci.');

        return $this->redirectToRoute('auth-login');
    }

    #[Route('/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('auth/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route('/logout', name: 'logout')]
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}