<?php

namespace AppBundle\Entity;

/**
 * Event
 */
class Event
{
    /**
     * Earth radius
     */
    const EARTH_RADIUS = 6371;
    
    /**
     * Distance to check on near events page
     */
    const DISTANCE_TO_CHECK = 5;
    
    /**
     * Public label, value
     */
    const EVENT_PUBLIC = 0;
    const EVENT_PUBLIC_NAME = 'Public';
    
    /**
     * Private label value
     */
    const EVENT_PRIVATE = 1;
    const EVENT_PRIVATE_NAME = 'Private';
    
    /**
     * Default Localizatin Katowice
     */
    const DEFAULT_LAT = 50.26489189999999;
    const DEFAULT_LNG = 19.02378150000004;
    const DEFAAULT_CITY = 'Katowice';
    
    
    private static $eventTypesNames = array(
        self::EVENT_PUBLIC => self::EVENT_PUBLIC_NAME,
        self::EVENT_PRIVATE => self::EVENT_PRIVATE_NAME,
    );
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $event_name;

    /**
     * @var string
     */
    private $event_location;

    /**
     * @var string
     */
    private $event_description;

    /**
     * @var \DateTime
     */
    private $event_start;

    /**
     * @var integer
     */
    private $event_duration;

    /**
     * @var integer
     */
    private $event_max_users;

    /**
     * @var integer
     */
    private $event_users_qty;

    /**
     * @var \DateTime
     */
    private $event_invitations_end;

    /**
     * @var boolean
     */
    private $event_type;

    /**
     * @var string
     */
    private $event_lat;

    /**
     * @var string
     */
    private $event_lng;

    /**
     * @var \DateTime
     */
    private $added;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $invitations;

    /**
     * @var \AppBundle\Entity\User
     */
    private $user;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $users_participate;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->invitations = new \Doctrine\Common\Collections\ArrayCollection();
        $this->users_participate = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set eventName
     *
     * @param string $eventName
     *
     * @return Event
     */
    public function setEventName($eventName)
    {
        $this->event_name = $eventName;
    
        return $this;
    }

    /**
     * Get eventName
     *
     * @return string
     */
    public function getEventName()
    {
        return $this->event_name;
    }

    /**
     * Set eventLocation
     *
     * @param string $eventLocation
     *
     * @return Event
     */
    public function setEventLocation($eventLocation)
    {
        $this->event_location = $eventLocation;
    
        return $this;
    }

    /**
     * Get eventLocation
     *
     * @return string
     */
    public function getEventLocation()
    {
        return $this->event_location;
    }

    /**
     * Set eventDescription
     *
     * @param string $eventDescription
     *
     * @return Event
     */
    public function setEventDescription($eventDescription)
    {
        $this->event_description = $eventDescription;
    
        return $this;
    }

    /**
     * Get eventDescription
     *
     * @return string
     */
    public function getEventDescription()
    {
        return $this->event_description;
    }

    /**
     * Set eventStart
     *
     * @param \DateTime $eventStart
     *
     * @return Event
     */
    public function setEventStart($eventStart)
    {
        $this->event_start = $eventStart;
    
        return $this;
    }

    /**
     * Get eventStart
     *
     * @return \DateTime
     */
    public function getEventStart()
    {
        return $this->event_start;
    }

    /**
     * Set eventDuration
     *
     * @param integer $eventDuration
     *
     * @return Event
     */
    public function setEventDuration($eventDuration)
    {
        $this->event_duration = $eventDuration;
    
        return $this;
    }

    /**
     * Get eventDuration
     *
     * @return integer
     */
    public function getEventDuration()
    {
        return $this->event_duration;
    }

    /**
     * Set eventMaxUsers
     *
     * @param integer $eventMaxUsers
     *
     * @return Event
     */
    public function setEventMaxUsers($eventMaxUsers)
    {
        $this->event_max_users = $eventMaxUsers;
    
        return $this;
    }

    /**
     * Get eventMaxUsers
     *
     * @return integer
     */
    public function getEventMaxUsers()
    {
        return $this->event_max_users;
    }

    /**
     * Set eventUsersQty
     *
     * @param integer $eventUsersQty
     *
     * @return Event
     */
    public function setEventUsersQty($eventUsersQty)
    {
        $this->event_users_qty = $eventUsersQty;
    
        return $this;
    }

    /**
     * Get eventUsersQty
     *
     * @return integer
     */
    public function getEventUsersQty()
    {
        return $this->event_users_qty;
    }

    /**
     * Set eventInvitationsEnd
     *
     * @param \DateTime $eventInvitationsEnd
     *
     * @return Event
     */
    public function setEventInvitationsEnd($eventInvitationsEnd)
    {
        $this->event_invitations_end = $eventInvitationsEnd;
    
        return $this;
    }

    /**
     * Get eventInvitationsEnd
     *
     * @return \DateTime
     */
    public function getEventInvitationsEnd()
    {
        return $this->event_invitations_end;
    }

    /**
     * Set eventType
     *
     * @param boolean $eventType
     *
     * @return Event
     */
    public function setEventType($eventType)
    {
        $this->event_type = $eventType;
    
        return $this;
    }

    /**
     * Get eventType
     *
     * @return boolean
     */
    public function getEventType()
    {
        return $this->event_type;
    }

    /**
     * Set eventLat
     *
     * @param string $eventLat
     *
     * @return Event
     */
    public function setEventLat($eventLat)
    {
        $this->event_lat = $eventLat;
    
        return $this;
    }

    /**
     * Get eventLat
     *
     * @return string
     */
    public function getEventLat()
    {
        return $this->event_lat;
    }

    /**
     * Set eventLng
     *
     * @param string $eventLng
     *
     * @return Event
     */
    public function setEventLng($eventLng)
    {
        $this->event_lng = $eventLng;
    
        return $this;
    }

    /**
     * Get eventLng
     *
     * @return string
     */
    public function getEventLng()
    {
        return $this->event_lng;
    }

    /**
     * Set added
     *
     * @param \DateTime $added
     *
     * @return Event
     */
    public function setAdded($added)
    {
        $this->added = $added;
    
        return $this;
    }

    /**
     * Get added
     *
     * @return \DateTime
     */
    public function getAdded()
    {
        return $this->added;
    }

    /**
     * Add invitation
     *
     * @param \AppBundle\Entity\Invitation $invitation
     *
     * @return Event
     */
    public function addInvitation(\AppBundle\Entity\Invitation $invitation)
    {
        $this->invitations[] = $invitation;
    
        return $this;
    }

    /**
     * Remove invitation
     *
     * @param \AppBundle\Entity\Invitation $invitation
     */
    public function removeInvitation(\AppBundle\Entity\Invitation $invitation)
    {
        $this->invitations->removeElement($invitation);
    }

    /**
     * Get invitations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInvitations()
    {
        return $this->invitations;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Event
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add usersParticipate
     *
     * @param \AppBundle\Entity\User $usersParticipate
     *
     * @return Event
     */
    public function addUsersParticipate(\AppBundle\Entity\User $usersParticipate)
    {
        $this->users_participate[] = $usersParticipate;
    
        return $this;
    }

    /**
     * Remove usersParticipate
     *
     * @param \AppBundle\Entity\User $usersParticipate
     */
    public function removeUsersParticipate(\AppBundle\Entity\User $usersParticipate)
    {
        $this->users_participate->removeElement($usersParticipate);
    }

    /**
     * Get usersParticipate
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsersParticipate()
    {
        return $this->users_participate;
    }
    
    public function getEventTypeName( $type ) 
    {
        return self::$eventTypesNames[$type];
    }
}
