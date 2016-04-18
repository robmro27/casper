<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \AppBundle\Form\Type\EventType;

class EventController extends Controller
{
    
    /**
     * List of events in witch user participate
     * @param Request $request
     * @return type
     */
    public function eventListParticipateAction(Request $request) 
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Event');
        /* @var $repository \AppBundle\Entity\EventRepository */
        
        $user = $this->container->get('security.context')->getToken()->getUser();
        /* @var $user \AppBundle\Entity\User */
        
        /* @var $user \AppBundle\Entity\User */
        $events = $repository->findFutureWithUserParticipate($user);
        
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
             $events, 
             $request->query->getInt('page', 1),
             2
        );
        
        return $this->render('AppBundle:Event:list_participate.html.twig', array(
            'pagination' => $pagination
        ));
    }
    
    /**
     * List of events witch user create
     * @param Request $request
     * @return type
     */
    public function eventListMyAction(Request $request) 
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Event');
        /* @var $repository \AppBundle\Entity\EventRepository */
        
        $user = $this->container->get('security.context')->getToken()->getUser();
        /* @var $user \AppBundle\Entity\User */
        
        /* @var $user \AppBundle\Entity\User */
        $events = $repository->findFutureEventsByUser($user);
        
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
             $events, 
             $request->query->getInt('page', 1),
             2
        );
        
        return $this->render('AppBundle:Event:list_my.html.twig', array(
            'pagination' => $pagination
        ));
    }
    
    /**
     * List of public events
     * @param Request $request
     * @return type
     */
    public function eventListAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Event');
        /* @var $repository \AppBundle\Entity\EventRepository */
        
        $events = $repository->findFuturePublicEvents(); 
        
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
             $events, 
             $request->query->getInt('page', 1),
             2
        );
        
        return $this->render('AppBundle:Event:list.html.twig', array(
            'pagination' => $pagination
        ));
    }
    
    
    
    /**
     * List of events witch user are invited for
     * @param Request $request
     * @return type
     */
    public function eventListMyInvitationsAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Event');
        /* @var $repository \AppBundle\Entity\EventRepository */
        
        $user = $this->container->get('security.context')->getToken()->getUser();
        /* @var $user \AppBundle\Entity\User */
         
        $events = $repository->findWithInvitationForUser($user); 
       
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
             $events, 
             $request->query->getInt('page', 1),
             2
        );
        
        return $this->render('AppBundle:Event:list_my_invitations.html.twig', array(
            'pagination' => $pagination
        ));
    }
    
    
    
    /**
     * Short list of events witch user are ivited for
     * @param type $maxResults
     * @return type
     */
    public function lastInvitationAction( $maxResults = 3 ) 
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Event');
        /* @var $repository \AppBundle\Entity\EventRepository */
        
        $user = $this->container->get('security.context')->getToken()->getUser();
        /* @var $user \AppBundle\Entity\User */
        
        $events = $repository->findWithInvitationForUser($user, $maxResults); 
        
        return $this->render('AppBundle:Event:Partial/last_invitations.html.twig', array(
            'events' => $events
        ));
    }
    
    
    /**
     * 
     * @param type $eventId
     * @param type $userId
     * @return type
     * @throws type
     */
    public function removeUserAction($eventId, $userId)  
    {
        $loggedUser = $this->container->get('security.context')->getToken()->getUser();
        /* @var $logUser \AppBundle\Entity\User */
        
        $em = $this->getDoctrine()->getManager();
        $event = $this->getDoctrine()->getRepository('AppBundle:Event')->find($eventId);
        
        /* @var $event \AppBundle\Entity\Event */
        if (!$event) {
            throw $this->createNotFoundException('No event found for id '.$eventId);
        }
        
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->find($userId);
        /* @var $user \AppBundle\Entity\User */
        if (!$user) {
            throw $this->createNotFoundException('No user found for id '.$user);
        }

        $validator = $this->get('app.event_validator');
        /* @var $validator \AppBundle\DependencyInjection\RemoveUserFromEventValidator */
        if (!$validator->checkPrmissionToRemove($loggedUser, $user, $event)) {
            throw $this->createAccessDeniedException();
        }
       
        $event->setEventUsersQty($event->getEventUsersQty() - 1);
        $event->removeUsersParticipate($user);
        $user->removeEventsParticipate($event);
        $em->flush();
        
        $this->addFlash('success','User ' . $user->getUsername() . ' was removed from event!');
        return $this->redirectToRoute('event_details',array('eventId' => $event->getId()));
        
    }
    
    
    
    /**
     * List o events near user
     * @param Request $request
     * @return type
     */
    public function newEventAction( Request $request )
    {
        $event = new \AppBundle\Entity\Event();
        $event->setAdded(new \DateTime());
        
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $user = $this->container->get('security.context')->getToken()->getUser();
            /* @var $user \AppBundle\Entity\User */
            
            $event->setUser($user); // adds owner
            $event->setEventUsersQty(1);// adds first user
            $event->addUsersParticipate($user); // adds owner as participant
            $user->addEventsParticipate($event); // both sides of many-to-many
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            $this->addFlash('success','Event created!');
            return $this->redirectToRoute('event_list');
        }
        
        return $this->render('AppBundle:Event:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    
    /**
     * 
     * @param type $eventId
     * @return type
     */
    public function joinEventAction( $eventId )
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        /* @var $user \AppBundle\Entity\User */
        
        $event = $this->getDoctrine()->getRepository('AppBundle:Event')->find($eventId);
        /* @var $event \AppBundle\Entity\Event */
        
        $invitationsRepository = $this->getDoctrine()->getRepository('AppBundle:Invitation');
        $invitation = $invitationsRepository->findOneBy(array('user' => $user, 'event' => $event));
        /* @var $invitation \AppBundle\Entity\Invitation */
        
        $validator = $this->get('app.event_validator');
        /* @var $validator \AppBundle\DependencyInjection\RemoveUserFromEventValidator */
        
        if(!$validator->checkPermisionToEvent($event, $invitation)) {
            throw $this->createAccessDeniedException();
        }
        
        try {
            $validator->validateJoin($event, $user, $invitation);
        } catch (\Exception $ex) {
            $this->addFlash('error',$ex->getMessage());
            return $this->redirectToRoute('event_details',array('eventId' => $eventId));
        }
        
        $user->addEventsParticipate($event); // many to many
        $event->addUsersParticipate($user); // both sides
        $event->setEventUsersQty($event->getEventUsersQty() + 1);
        
        if ($invitation) {
            $event->removeInvitation($invitation);
            $invitation->setEvent(null);
        }
        
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        
        $this->addFlash('success','You join event!');
        return $this->redirectToRoute('event_details',array('eventId' => $eventId));
    }
    
    
    /**
     * 
     * @param Request $request
     * @param int $eventId
     * @return type
     * @throws type
     */
    public function eventDetailsAction( Request $request, $eventId )
    {
        $pagination = null;
        $event = $this->getDoctrine()->getRepository('AppBundle:Event')
                                     ->find($eventId);

        $user = $this->container->get('security.context')->getToken()->getUser();
        /* @var $user \AppBundle\Entity\User */
        
        $invitationsRepository = $this->getDoctrine()->getRepository('AppBundle:Invitation');
        $invitation = $invitationsRepository->findOneBy(array('user' => $user, 'event' => $event));
        /* @var $invitation \AppBundle\Entity\Invitation */
        
        $validator = $this->get('app.event_validator');
        /* @var $validator \AppBundle\DependencyInjection\RemoveUserFromEventValidator */
        if(!$validator->checkPermisionToEvent($event, $invitation)) {
            throw $this->createAccessDeniedException();
        }
        
        if ($event->getUser()->getId() == $user->getId()) {
            
            // gets users for invitations
            $userRepository = $this->getDoctrine()->getRepository('AppBundle:User');
            /* @var $userRepository \AppBundle\Entity\UserRepository */
            
            $users = $userRepository->getWithoutUser($user);
            $paginator  = $this->get('knp_paginator');
            $pagination = $paginator->paginate($users,$request->query->getInt('page', 1),15);
        }
        
        if (!$event) {
            throw $this->createNotFoundException('No event found for id '.$eventId);
        }
        
        return $this->render('AppBundle:Event:details.html.twig', array(
            'event' => $event,
            'pagination' => $pagination
        ));
    }
    
    
    
    /**
     * List of events near location
     * @param Request $request
     * @return type
     */
    public function nearAction( Request $request )
    {
        
        $lat = $request->query->get('lat', \AppBundle\Entity\Event::DEFAULT_LAT);
        $lng = $request->query->get('lng', \AppBundle\Entity\Event::DEFAULT_LNG);
        $address = $request->query->get('address', \AppBundle\Entity\Event::DEFAAULT_CITY);

        $repository = $this->getDoctrine()->getRepository('AppBundle:Event');
        /* @var $repository \AppBundle\Entity\EventRepository */
        
        $events = $repository->findNear($lat, $lng);
        
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
             $events, 
             $request->query->getInt('page', 1),
             2
        );
            
        return $this->render('AppBundle:Event:near.html.twig', array(
            'pagination' => $pagination,
            'lat' => $lat,
            'lng' => $lng,
            'address' => $address
        ));
        
    }
    
}
