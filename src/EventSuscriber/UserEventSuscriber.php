<?php

namespace App\EventSubscriber;

use App\Entity\User;
use DateTime;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserEventSubscriber implements EventSubscriberInterface
{
    private $hasher;
    
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public static function getSubscribedEvents()
    {
        // return the subscribed events, their methods and priorities
        return [
            BeforeEntityPersistedEvent::class => ['createUser'],
            BeforeEntityUpdatedEvent::class => ['updateUser']
        ];
    }

    public function createUser(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if (!($entity instanceof User)) {
            return;
        }

        $password = $this->hasher->hashPassword($entity, $entity->getPassword());
        $entity->setPassword($password);

        $entity->setInsertDate(new DateTime());
    }

    public function updateUser(BeforeEntityUpdatedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if (!($entity instanceof User)) {
            return;
        }

        if (strlen($entity->getPassword()) >= 40 ){
            $password = $this->hasher->hashPassword($entity, $entity->getPassword());
            $entity->setPassword($password);
        }
    }
}