<?php


namespace App\Domain\Auth\Interface;
use App\Domain\Annonces\Entity\Annonce;
use App\Domain\Utilisateurs\Entity\Utilisateur;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;

interface AuthRepositoryInterface
{
    public function register(Utilisateur $item): ?Utilisateur;
}