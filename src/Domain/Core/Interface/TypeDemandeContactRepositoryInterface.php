<?php


namespace App\Domain\Core\Interface;
use App\Domain\Annonces\Entity\Annonce;
use App\Domain\Core\Entity\TypeDemandeContact;
use App\Domain\Partenaires\Entity\Partenaire;
use App\Domain\Publicites\Entity\Publicite;
use App\Domain\Utilisateurs\Entity\Utilisateur;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;

interface TypeDemandeContactRepositoryInterface
{
    public function create(TypeDemandeContact $item): ?TypeDemandeContact;
    public function update(TypeDemandeContact $item): ?TypeDemandeContact;
    public function delete(TypeDemandeContact $item): ?TypeDemandeContact;
    public function read(int $id): ?TypeDemandeContact;
}