<?php

namespace AppBundle\Entity;

/**
 * EventRepository
 *
 */
class EventRepository extends \Doctrine\ORM\EntityRepository
{
    
    /**
     * Future public events
     * @return Event[]
     */
    public function findFuturePublicEvents()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT e FROM AppBundle:Event e '
              . 'WHERE e.event_type = :type '
              . 'AND e.event_start >= :currdate'
            )
            ->setParameter('type', Event::EVENT_PUBLIC)
            ->setParameter('currdate', new \DateTime())   
            ->getResult();
    }
    
    /**
     * Future Public Events
     * @param \AppBundle\Entity\User $user
     * @return Event[]
     */
    public function findFutureEventsByUser(User $user)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT e FROM AppBundle:Event e '
              . 'WHERE e.event_start >= :currdate '
              . 'AND e.user = :user'
            )
            ->setParameter('currdate', new \DateTime())
            ->setParameter('user', $user)
            ->getResult();
    }
    
    
    /**
     * Near events
     * @return type
     */
    public function findNear($lat, $lng)
    {
         return $this->getEntityManager()
            ->createQuery(
                'SELECT e FROM AppBundle:Event e WHERE
                 ACOS(SIN(RADIANS(:lat)) * 
                 SIN(RADIANS(e.event_lat)) + 
                 COS(RADIANS(:lat)) * 
                 COS(RADIANS(e.event_lat)) * 
                 COS(RADIANS(:lng) - RADIANS(e.event_lng))) * :earthRadius <= :distanceKm'
            )
            ->setParameter('lat', $lat)
            ->setParameter('lng', $lng)
            ->setParameter('earthRadius', Event::EARTH_RADIUS)
            ->setParameter('distanceKm', Event::DISTANCE_TO_CHECK)
            ->getResult();
        
    }
    
    public function findWithInvitationForUser(User $user, $maxResults = null) {
        
        $em = $this->getEntityManager();
        $query = $em->createQuery('SELECT e FROM AppBundle:Event e'
                . ' JOIN e.invitations i WHERE i.user = :user AND e.event_start >= :currDate');
        $query->setParameter('user', $user);
        $query->setParameter('currDate', new \DateTime());
                    
        if ($maxResults !== null) {
            $query->setMaxResults($maxResults);
        }
                    
        return $query->getResult();

    }
    
    public function findFutureWithUserParticipate(User $user) 
    {

        $em = $this->getEntityManager();
        $query = $em->createQuery('SELECT e FROM AppBundle:Event e '
             . 'JOIN e.users_participate ep '
             . 'WHERE ep = :user AND e.event_start >= :currDate');
        $query->setParameter('currDate', new \DateTime());
        $query->setParameter('user', $user);
        
        return $query->getResult();
    }
    
}
