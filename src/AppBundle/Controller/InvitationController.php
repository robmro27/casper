<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\User;

class InvitationController extends Controller
{
    
    /**
     * Send invitation for user
     */
    public function inviteAction( User $user, $eventId )
    {
        
        $event = $this->getDoctrine()
                        ->getRepository('AppBundle:Event')
                        ->find($eventId);
        /* @var $event \AppBundle\Entity\Event */

        if (!$event) {
            throw $this->createNotFoundException('No event found for id '.$eventId);
        }
        
        $invitation = new \AppBundle\Entity\Invitation();
        $invitation->setUser($user);
        $invitation->setEvent($event);
        $invitation->setSent(new \DateTime());

        $em = $this->getDoctrine()->getManager();
        $em->persist($invitation);
        $em->flush();
        
        $message = \Swift_Message::newInstance()
            ->setSubject('Invitation for event')
            ->setFrom('casper@polcode.net')
            ->setTo($user->getEmail())
            ->setBody(
                $this->renderView(
                    'AppBundle:Invitation:invite.html.twig',
                    array('event' => $event)
                ),
                'text/html'
            );
        
        //$this->get('mailer')->send($message);
        
        $this->addFlash('success','Invitation for user ' . $user->getUsername(). ' sent');
        return $this->redirectToRoute('event_details',array('eventId' => $event->getId()));
    }

}
