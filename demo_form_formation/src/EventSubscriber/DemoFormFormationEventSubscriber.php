<?php
namespace Drupal\demo_form_formation\EventSubscriber;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DemoFormFormationEventSubscriber implements EventSubscriberInterface
{

  static function getSubscribedEvents(){
    $events['submit_set_message'] = 'showFormResult';
    return $events;
  }

  static function showFormResult(Event $event){
    $subject = $event->getSubject();
    $expediteur = $event->getExpediteur();
    drupal_set_message('Votre message ayant pour sujet'. $subject . 'et pour expediteur ' . $expediteur, status, TRUE);
  }
}
