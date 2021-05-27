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
    public function __construct(public EntityManagerInterface $em, public EventDispatcherInterface $dispatcher, private FileUploader $fileUploader, private RoleRepositoryInterface $roleRepository, private MotifSignalementRepository $motifSignalementRepository, private TypeDemandeContactRepository $typeDemandeContactRepository, private  SerializerInterface $serializer){}

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

    public function listTypeDemandeContact(TypeDemandeContactQuery $query)
    {
        return $this->typeDemandeContactRepository->list($query);
    }

    public function createTypeDemandeContact(array $data): TypeDemandeContact
    {
        TypeDemandeContactValidator::create($data);

        return $this->typeDemandeContactRepository->create($this->serializer->fromArray(
            $data,
            TypeDemandeContact::class
        ));
    }

    public function updateTypeDemandeContact(TypeDemandeContact $item, array $data) : TypeDemandeContact
    {
        TypeDemandeContactValidator::update($data);

        return $this->typeDemandeContactRepository->update($this->serializer->fromArray(
            array_merge($this->serializer->toArray($item), $data),
            TypeDemandeContact::class
        ));
    }
    public function deleteTypeDemandeContact(TypeDemandeContact $item) : TypeDemandeContact
    {
        return $this->typeDemandeContactRepository->delete($item);
    }
    public function readTypeDemandeContact(int $id) : TypeDemandeContact
    {
        return $this->typeDemandeContactRepository->read($id);
    }

    public function listMotifSignalement(MotifSignalementQuery $query)
    {
        return $this->motifSignalementRepository->list($query);
    }

    public function createMotifSignalement(array $data): MotifSignalement
    {
        TypeDemandeContactValidator::create($data);

        return $this->motifSignalementRepository->create($this->serializer->fromArray(
            $data,
            MotifSignalement::class
        ));
    }

    public function updateMotifSignalement(MotifSignalement $item, array $data) : MotifSignalement
    {
        TypeDemandeContactValidator::update($data);

        return $this->motifSignalementRepository->update($this->serializer->fromArray(
            array_merge($this->serializer->toArray($item), $data),
            MotifSignalement::class
        ));
    }
    public function deleteMotifSignalement(MotifSignalement $item) : MotifSignalement
    {
        return $this->motifSignalementRepository->delete($item);
    }
    public function readMotifSignalement(int $id) : MotifSignalement
    {
        return $this->motifSignalementRepository->read($id);
    }
}