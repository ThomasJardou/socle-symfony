<?php


namespace App\Domain\Core;

use App\Domain\Core\Entity\Fichier;
use App\Domain\Core\Entity\MotifSignalement;
use App\Domain\Core\Entity\Role;
use App\Domain\Core\Entity\TypeDemandeContact;
use App\Domain\Core\Interface\RoleRepositoryInterface;
use App\Domain\Core\Query\MotifSignalementQuery;
use App\Domain\Core\Query\RoleQuery;
use App\Domain\Core\Query\TypeDemandeContactQuery;
use App\Domain\Core\Repository\MotifSignalementRepository;
use App\Domain\Core\Repository\RoleRepository;
use App\Domain\Core\Repository\TypeDemandeContactRepository;
use App\Domain\Core\Validator\TypeDemandeContactValidator;
use App\Domain\Utilisateurs\Entity\Utilisateur;
use App\Infrastructure\Uploader\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CoreService
{
    public function __construct(public EntityManagerInterface $em, public EventDispatcherInterface $dispatcher, private FileUploader $fileUploader, private RoleRepositoryInterface $roleRepository, private  SerializerInterface $serializer){}

    public function upload(UploadedFile $file, string $targetDirectory) : Fichier
    {
        $res = new Fichier();
        $res->setOriginalName($file->getClientOriginalName());
        $res->setPath($this->fileUploader->upload($file, $targetDirectory));
        $res->setMimeType($file->getMimeType());
        return $res;
    }

    public function createRole(array $data): ?Role
    {
        TypeDemandeContactValidator::create($data);

        return $this->roleRepository->create($this->serializer->fromArray(
            $data,
            Role::class
        ));
    }

    public function updateRole(Role $item, array $data): ?Role
    {
        TypeDemandeContactValidator::update($data);

        return $this->roleRepository->update($this->serializer->fromArray(
            array_merge($this->serializer->toArray($item), $data),
            Role::class
        ));
    }

    public function deleteRole(Role $item): ?Role
    {
        return $this->roleRepository->delete($item);
    }

    public function readRole(int $id): ?Role
    {
        return $this->roleRepository->read($id);
    }

    public function listRole(RoleQuery $query)
    {
        return $this->roleRepository->list($query);
    }

}