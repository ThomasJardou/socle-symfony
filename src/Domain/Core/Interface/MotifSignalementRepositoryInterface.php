<?php


namespace App\Domain\Core\Interface;
use App\Domain\Annonces\Entity\Annonce;
use App\Domain\Core\Entity\MotifSignalement;
use App\Domain\Core\Entity\TypeDemandeContact;
use App\Domain\Partenaires\Entity\Partenaire;
use App\Domain\Publicites\Entity\Publicite;
use App\Domain\Utilisateurs\Entity\Utilisateur;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;

interface MotifSignalementRepositoryInterface
{
    public function create(MotifSignalement $item): ?MotifSignalement;
    public function update(MotifSignalement $item): ?MotifSignalement;
    public function delete(MotifSignalement $item): ?MotifSignalement;
    public function read(int $id): ?MotifSignalement;
}