<?php declare(strict_types=1);

namespace App\Http\Admin\Controller;

use App\Domain\Core\CoreService;
use App\Domain\Core\Query\RoleQuery;
use App\Domain\MainService;
use App\Domain\Utilisateurs\Entity\Utilisateur;
use App\Domain\Utilisateurs\Query\UtilisateurQuery;
use App\Domain\Utilisateurs\UtilisateursService;
use App\Http\Controller\MainController;
use Assert\LazyAssertionException;
use JetBrains\PhpStorm\NoReturn;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @IsGranted(Utilisateur::ROLE_ADMINISTRATEUR)
 */
#[Route('/admin/utilisateurs', name: 'admin-utilisateurs-')]
class AdminUtilisateursController extends MainController
{
    public function __construct(public MainService $mainService, private UtilisateursService $utilisateursService, private CoreService $coreService)
    { }

    #[NoReturn] #[Route('/', name: 'index')]
    public function index(UtilisateurQuery $utilisateurQuery, Request $request): Response
    {
        return $this->render('admin/admin_utilisateurs/index.html.twig', [
            /** @var Utilisateur[] $items */
            'items' =>$this->utilisateursService->list($utilisateurQuery),
            'roles' =>$this->coreService->listRole(new RoleQuery())
        ]);
    }

    #[NoReturn] #[Route('/create', name: 'create')]
    public function create(Request $request): Response
    {
        if ($request->isMethod('post')) {
            try {
                $this->utilisateursService->create($request->request->all());
                $this->addFlash('success', 'La personne que vous venez d\'inscrire va recevoir un mail de confirmation.');

                return $this->redirectToRoute('admin-utilisateurs-index');
            }catch (LazyAssertionException $e){
                $formErrors = $e->getErrorExceptions();
            }catch (\Throwable $e) {
                $this->addFlash('danger', 'Une erreur est survenue pendant l\'enregistrement.');
            }
        }
        return $this->render('admin/admin_utilisateurs/form.html.twig', [
            'action' => 'Création',
            'formErrors' => $formErrors ?? [],
            'roles' =>$this->coreService->listRole(new RoleQuery())
        ]);
    }

    #[NoReturn] #[Route('/update/{id}', name: 'update')]
    public function update(Request $request, Utilisateur $item): Response
    {
        if ($request->isMethod('post')) {
            try {
                $this->utilisateursService->update($item, $request->request->all());
                return $this->redirectToRoute('admin-utilisateurs-index');
            }catch (LazyAssertionException $e){
                $formErrors = $e->getErrorExceptions();
            }catch (\Throwable $e) {
                $this->addFlash('danger', 'Une erreur est survenue pendant l\'enregistrement.');
            }
        }
        return $this->render('admin/admin_utilisateurs/form.html.twig', [
            'action' => 'Édition',
            'formErrors' => $formErrors ?? [],
            'item'=> $item,
            'roles' =>$this->coreService->listRole(new RoleQuery())
        ]);
    }

    #[NoReturn] #[Route('/delete/{id}', name: 'delete')]
    public function delete(Utilisateur $item): Response
    {
        try {
            $this->utilisateursService->delete($item);
            return $this->redirectToRoute('admin-utilisateurs-index');
        }catch (\Throwable $e) {
            $this->addFlash('danger', 'Une erreur est survenue pendant l\'enregistrement.');
        }
    }

    #[NoReturn] #[Route('/read/{id}', name: 'read')]
    public function read(Request $request, Utilisateur $item): Response
    {

        return $this->render('admin/admin_utilisateurs/read.html.twig', [
            'item'=> $this->utilisateursService->read($item->getId())
        ]);
    }
}