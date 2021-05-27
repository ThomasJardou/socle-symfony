<?php


namespace App\Domain\Utilisateurs\Interface;
use App\Domain\Annonces\Entity\Annonce;
use App\Domain\Utilisateurs\Entity\Utilisateur;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;

interface UtilisateurRepositoryInterface
{
    public function create(Utilisateur $item): ?Utilisateur;
    public function update(Utilisateur $item): ?Utilisateur;
    public function delete(Utilisateur $item): ?Utilisateur;
    public function read(int $id): ?Utilisateur;
}