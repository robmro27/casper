<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;

class MenuBuilder
{
    private $factory;

    /**
     * @param FactoryInterface $factory
     *
     * Add any other dependency you need
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function createMainMenu(array $options)
    {
        $menu = $this->factory->createItem('root',
                array('childrenAttributes' => array('class' => 'sidebar-menu')));
        
        $menu->addChild('Menu')->setAttribute('class', 'header');
        
        $menu->addChild('Upcoming', array('route' => 'event_list'))
             ->setAttribute('icon', 'fa fa-calendar-times-o ');
        
        $menu->addChild('Near', array('route' => 'event_near'))
             ->setAttribute('icon', 'fa fa-map-signs');
        
        $menu->addChild('New', array('route' => 'event_new'))
             ->setAttribute('icon', 'fa fa-plus-square');
        
        $menu->addChild('My Events', array('route' => 'event_list_my'))
             ->setAttribute('icon', 'fa fa-user-md');
        
        $menu->addChild('My Invitations', array('route' => 'event_list_my_invitations'))
             ->setAttribute('icon', 'fa fa-envelope');
        
        $menu->addChild('Events With Me', array('route' => 'event_participate'))
             ->setAttribute('icon', 'fa  fa-users');
        
        $menu->addChild('Profile', array('route' => 'fos_user_profile_show'))
             ->setAttribute('icon', 'fa fa-key');
        
        $menu['Profile']->addChild('Change password', array('route' => 'fos_user_change_password'));
        
        $menu['Profile']->addChild('Profile edit', array('route' => 'fos_user_profile_edit'));
        
        return $menu;
    }
}