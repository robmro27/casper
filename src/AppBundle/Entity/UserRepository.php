<?php

namespace AppBundle\Entity;

/**
 * UserRepository
 *
 */
class UserRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Get all users without one
     * @param \AppBundle\Entity\User $user
     * @return type
     */
    public function getWithoutUser(User $user)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT u FROM AppBundle:User u '
              . 'WHERE u.id != :owner'
            )
            ->setParameter('owner', $user);
    }
    
}
