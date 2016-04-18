<?php

namespace AppBundle\DependencyInjection;

/**
 * Description of RemoveUserFromEventValidator
 *
 * @author rmroz
 */
class EventValidator {
    
    
    /**
     * 
     * @param \AppBundle\Entity\User $loggedUser
     * @param \AppBundle\Entity\User $userToRemove
     * @param \AppBundle\Entity\Event $event
     * @return boolean
     */
    public function checkPrmissionToRemove(\AppBundle\Entity\User $loggedUser,
                              \AppBundle\Entity\User $userToRemove,
                              \AppBundle\Entity\Event $event) {
        
        // can't remove another member if not ower
        if ($loggedUser->getId() != $event->getUser()->getId()) {
            return false;
        }
        
        // can't remove self
        if ($loggedUser->getId() == $userToRemove->getId()) {
            return false;
        }
        
        return true;
        
    } 
    
    
    /**
     * 
     * @param \AppBundle\Entity\Event $event
     * @param \AppBundle\Entity\Invitation $invitation
     * @return boolean
     */
    public function checkPermisionToEvent($event, $invitation) {
     
        if ($event->getEventType() == \AppBundle\Entity\Event::EVENT_PRIVATE &&
            empty($invitation)) {
            return false;
        }
        
        return true;
        
    }
    
    /**
     * 
     * @param \AppBundle\Entity\Event $event
     * @param \AppBundle\Entity\User $user
     * @throws \Exception
     */
    public function validateJoin($event, $user) {
        
        if (new \DateTime() >= $event->getEventStart()) {
            throw new \Exception('This event is old!');
        }
        
        if (new \DateTime() >= $event->getEventInvitationsEnd()) {
            throw new \Exception('Time to join this event passed!');
        }
        
        if ($event->getUsersParticipate()->contains($user)) {
            throw new \Exception('You are already member of this event!');
        }
        
        if ($event->getUser()->getId() == $user->getId()) {
            throw new \Exception('You can\'t join to your event!');
        }
        
        if ($event->getEventUsersQty() >= $event->getEventMaxUsers()) {
            throw new \Exception('You can\'t join to event is\'s full!');
        }
        
    }
    
}
