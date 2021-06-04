<?php declare(strict_types=1);

namespace App\Http\Admin\Controller;

use App\Domain\Annonces\AnnoncesService;
use App\Domain\Annonces\Entity\Categorie;
use App\Domain\Annonces\Query\CategorieQuery;
use App\Domain\Annonces\Repository\CategorieRepository;
use App\Domain\Blog\BlogService;
use App\Domain\Blog\Entity\Article;
use App\Domain\Blog\Query\ArticleQuery;
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
#[Route('/admin/articles', name: 'admin-articles-')]
class AdminArticlesController extends MainController
{
    public function __construct(public MainService $mainService, private BlogService $service)
    { }

    #[NoReturn] #[Route('/', name: 'index')]
    public function index(ArticleQuery $query, Request $request): Response
    {
        return $this->render('admin/admin_articles/index.html.twig', [
            /** @var Role[] $items */
            'items' =>$this->service->listArticle($query),
        ]);
    }

    #[NoReturn] #[Route('/create', name: 'create')]
    public function create(Request $request): Response
    {
        if ($request->isMethod('post')) {
            try {
                $this->service->createArticle($request->request->all());
                $this->addFlash('success', 'Article crée avec succès.');
                return $this->redirectToRoute('admin-articles-index');
            }catch (LazyAssertionException $e){
                $formErrors = $e->getErrorExceptions();
            }catch (\Throwable $e) {
                dd($e);
                $this->addFlash('danger', 'Une erreur est survenue pendant l\'enregistrement.');
            }
        }
        return $this->render('admin/admin_articles/form.html.twig', [
            'action' => 'Création',
            'formErrors' => $formErrors ?? [],
        ]);
    }

    #[NoReturn] #[Route('/update/{id}', name: 'update')]
    public function update(Request $request, Article $item): Response
    {
        if ($request->isMethod('post')) {
            try {
                $this->service->updateArticle($item, $request->request->all());
                $this->addFlash('success', 'Article modifié avec succès.');
                return $this->redirectToRoute('admin-articles-index');
            }catch (LazyAssertionException $e){
                $formErrors = $e->getErrorExceptions();
            }catch (\Throwable $e) {
                $this->addFlash('danger', 'Une erreur est survenue pendant l\'enregistrement.');
            }
        }
        return $this->render('admin/admin_articles/form.html.twig', [
            'action' => 'Édition',
            'formErrors' => $formErrors ?? [],
            'item'=> $item,
        ]);
    }

    #[NoReturn] #[Route('/delete/{id}', name: 'delete')]
    public function delete(Article $item): Response
    {
        try {
            $this->service->deleteArticle($item);
            return $this->redirectToRoute('admin-articles-index');
        }catch (\Throwable $e) {
            $this->addFlash('danger', 'Une erreur est survenue pendant l\'enregistrement.');
        }
    }

    #[NoReturn] #[Route('/read/{id}', name: 'read')]
    public function read(Request $request, Article $item): Response
    {

        return $this->render('admin/admin_articles/read.html.twig', [
        ]);
    }
}