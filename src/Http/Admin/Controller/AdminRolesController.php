<?php declare(strict_types=1);

namespace App\Http\Admin\Controller;

use App\Domain\Annonces\AnnoncesService;
use App\Domain\Annonces\Entity\Categorie;
use App\Domain\Annonces\Query\CategorieQuery;
use App\Domain\Annonces\Repository\CategorieRepository;
use App\Domain\Core\CoreService;
use App\Domain\Core\Entity\MotifSignalement;
use App\Domain\Core\Entity\Role;
use App\Domain\Core\Entity\TypeDemandeContact;
use App\Domain\Core\Query\MotifSignalementQuery;
use App\Domain\Core\Query\RoleQuery;
use App\Domain\Core\Query\TypeDemandeContactQuery;
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
#[Route('/admin/roles', name: 'admin-roles-')]
class AdminRolesController extends MainController
{
    public function __construct(public MainService $mainService, private CoreService $coreService)
    { }

    #[NoReturn] #[Route('/', name: 'index')]
    public function index(RoleQuery $query, Request $request): Response
    {
        return $this->render('admin/admin_roles/index.html.twig', [
            /** @var Role[] $items */
            'items' =>$this->coreService->listRole($query),
        ]);
    }

    #[NoReturn] #[Route('/create', name: 'create')]
    public function create(Request $request): Response
    {
        if ($request->isMethod('post')) {
            try {
                $this->coreService->createRole($request->request->all());
                $this->addFlash('success', 'Rôle crée avec succès.');

                return $this->redirectToRoute('admin-roles-index');
            }catch (LazyAssertionException $e){
                $formErrors = $e->getErrorExceptions();
            }catch (\Throwable $e) {
                $this->addFlash('danger', 'Une erreur est survenue pendant l\'enregistrement.');
            }
        }
        return $this->render('admin/admin_roles/form.html.twig', [
            'action' => 'Création',
            'formErrors' => $formErrors ?? [],
        ]);
    }

    #[NoReturn] #[Route('/update/{id}', name: 'update')]
    public function update(Request $request, Role $item): Response
    {
        if ($request->isMethod('post')) {
            try {
                $this->coreService->updateRole($item, $request->request->all());
                $this->addFlash('success', 'Rôle modifié avec succès.');
                return $this->redirectToRoute('admin-roles-index');
            }catch (LazyAssertionException $e){
                $formErrors = $e->getErrorExceptions();
            }catch (\Throwable $e) {
                $this->addFlash('danger', 'Une erreur est survenue pendant l\'enregistrement.');
            }
        }
        return $this->render('admin/admin_roles/form.html.twig', [
            'action' => 'Édition',
            'formErrors' => $formErrors ?? [],
            'item'=> $item,
        ]);
    }

    #[NoReturn] #[Route('/delete/{id}', name: 'delete')]
    public function delete(Role $item): Response
    {
        try {
            $this->coreService->deleteRole($item);
            return $this->redirectToRoute('admin-roles-index');
        }catch (\Throwable $e) {
            $this->addFlash('danger', 'Une erreur est survenue pendant l\'enregistrement.');
        }
    }

    #[NoReturn] #[Route('/read/{id}', name: 'read')]
    public function read(Request $request, Role $item): Response
    {

        return $this->render('admin/admin_roles/read.html.twig', [
        ]);
    }
}