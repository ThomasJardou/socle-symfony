<?php


namespace App\Domain\Auth\Validators;


use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegistrationValidator
{
    public static function register(array $data)
    {
        $validator = \Assert\Assert::lazy();

        $validator->that($data)
            ->keyExists('pseudo', 'Le champ "Pseudo" est requis')
            ->keyExists('email', 'Le champ "Email" est requis')
            ->keyExists('password', 'Le champ "Mot de passe" est requis')
            ->keyExists('confirm_password', 'Le champ "Confirmation du mot de passe" est requis')
            ->keyExists('terms', 'Le champ "Termes utilisation" est requis')
        ;

        $validator->that($data['password'])
            ->notEmpty('Le champ "Mot de passe" est obligatoire', 'password')
            ->minLength(8, 'Le champ "Mot de passe" doit contenir au moins 8 caractères', 'password')
            ->regex('/[A-Z]/', 'Le champ "Mot de passe" doit contenir au moins 1 majuscule', 'password')
            ->regex('/[0-9]/', 'Le champ "Mot de passe" doit contenir au moins 1 chiffre', 'password')
            ->regex('/[a-z]/', 'Le champ "Mot de passe" doit contenir au moins 1 minuscule', 'password')
            ->eq($data['confirm_password'], 'Le mot de passe et sa confirmation doivent être identique')
        ;

        $validator->verifyNow();

        return true;
    }
}