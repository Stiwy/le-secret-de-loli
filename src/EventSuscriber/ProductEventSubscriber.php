<?php

namespace App\EventSubscriber;

use App\Entity\Category;
use DateTime;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CategoryEventSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        // return the subscribed events, their methods and priorities
        return [
            BeforeEntityPersistedEvent::class => ['createCategory'],
            BeforeEntityUpdatedEvent::class => ['updateCategory']
        ];
    }

    public function createCategory(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if (!($entity instanceof Category)) {
            return;
        }

        $entity->setInsertDate(new DateTime());
    }

    public function updateCategory(BeforeEntityUpdatedEvent $event)
    {
        
    }
}