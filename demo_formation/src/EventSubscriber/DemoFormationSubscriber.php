<?php
namespace Drupal\demo_formation\EventSubscriber;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DemoFormationSubscriber implements EventSubscriberInterface  {
  /**
   * Registers the methods in this class that should be listeners.
   *
   * @return array
   *   An array of event listener definitions.
   */
  static function getSubscribedEvents() {
  	$events['my_event.view'] = 'onResponse';
  	return $events;
  }

  static function onResponse(Event $event) {
    drupal_set_message('La reponse a été trouvée.', 'status', TRUE);
  }
}
