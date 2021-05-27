<?php declare(strict_types=1);

namespace App\Domain\Utilisateurs\Subscriber;

use App\Domain\Utilisateurs\Event\UtilisateurCreatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UtilisateurSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents(): array
    {
        return [
            UtilisateurCreatedEvent::class => 'onUtilisateurCreated',
        ];
    }

    public function onUtilisateurCreated(UtilisateurCreatedEvent $event): void
    {
        $item = $event->getUtilisateur();
    }
}
