<?php
namespace Drupal\demo_formation\Event;

use Symfony\Component\EventDispatcher\Event;

class DemoFormationEvent extends Event {
  const SUBMIT = 'my_event.view';
  protected $title;

  public function __construct(  ) {
    $this->title = 'title';
  }

  public function getTitle() {
    return $this->title;
  }

  public function setTitle($title) {
    $this->title = $title;
  }
}
