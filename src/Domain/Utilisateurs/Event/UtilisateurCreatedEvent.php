<?php


namespace App\Domain\Utilisateurs\Event;


use App\Domain\Utilisateurs\Entity\Utilisateur;

class UtilisateurCreatedEvent
{
    public function __construct(private Utilisateur $utilisateur){}

    /**
     * @return Utilisateur
     */
    public function getUtilisateur(): Utilisateur
    {
        return $this->utilisateur;
    }


}