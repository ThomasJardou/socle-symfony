<?php


namespace App\Domain\Blog\Validator;


use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ArticleValidator
{
    public static function create(array $data)
    {
        $validator = \Assert\Assert::lazy();

        $validator->that($data)
            ->keyExists('title', 'Le champ "Titre" est requis')
            ->keyExists('content', 'Le champ "Contenu" est requis')
        ;
        $validator->verifyNow();

        return true;
    }

    public static function update(array $data)
    {
        $validator = \Assert\Assert::lazy();

        $validator->that($data)
            ->keyExists('title', 'Le champ "Titre" est requis')
            ->keyExists('content', 'Le champ "Contenu" est requis')
        ;
        $validator->verifyNow();

        return true;
    }
}