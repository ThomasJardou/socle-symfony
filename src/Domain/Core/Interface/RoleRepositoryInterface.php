<?php


namespace App\Domain\Core\Interface;
use App\Domain\Annonces\Entity\Annonce;
use App\Domain\Core\Entity\Role;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;

interface RoleRepositoryInterface
{
    public function create(Role $item): ?Role;
    public function update(Role $item): ?Role;
    public function delete(Role $item): ?Role;
    public function read(int $id): ?Role;

    public function getWithSlug(string $slug): ?Role;
}