<?php

namespace Ang3\Bundle\ApiBasicAuthBundle\EventListener\Doctrine;

use Ang3\Bundle\ApiBasicAuthBundle\Model\ApiUserInterface;
use Ang3\Bundle\ApiBasicAuthBundle\Manager\ApiUserManager;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;

/**
 * @author Joanis ROUANET
 */
class UserSubscriber implements EventSubscriber
{
    /**
     * Générateur de clés.
     *
     * @var ApiUserManager
     */
    protected $apiUserManager;

    /**
     * Constructor of the subscriber.
     *
     * @param ApiUserManager $apiUserManager
     */
    public function __construct(ApiUserManager $apiUserManager)
    {
        $this->apiUserManager = $apiUserManager;
    }

    /**
     * {@inheritdoc}.
     */
    public function getSubscribedEvents()
    {
        return array(
            Events::prePersist,
        );
    }

    /**
     * A chaque enregistrement d'un nouvel utilisateur.
     *
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        // Récupération de l'entité
        $entity = $args->getEntity();

        // Si l'entité est un utilisateur API
        if ($entity instanceof ApiUserInterface) {
            // Si l'entité ne possède pas de clé API
            if (!$entity->getApiKey()) {
                // Mise-à-jour de l'API key
                $this->apiUserManager->updateApiKey($entity);
            }
        }
    }
}
