<?php


namespace App\Domain\Core\Validator;


use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RoleValidator
{
    public static function create(array $data)
    {
        $validator = \Assert\Assert::lazy();

        $validator->that($data)
            ->keyExists('name', 'Le champ "Nom" est requis')
            ->keyExists('slug', 'Le champ "Slug" est requis')
        ;
        $validator->verifyNow();

        return true;
    }

    public static function update(array $data)
    {
        $validator = \Assert\Assert::lazy();

        $validator->that($data)
            ->keyExists('name', 'Le champ "Nom" est requis')
            ->keyExists('slug', 'Le champ "Slug" est requis')
        ;
        $validator->verifyNow();

        return true;
    }
}