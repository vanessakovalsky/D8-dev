<?php

namespace Drupal\demo_form_formation\Event;
use Symfony\Component\EventDispatcher\Event;

class DemoSubmitEvent extends Event
{
  CONST VIEW = 'submit_set_message';
  protected $subject;
  protected $expediteur;

  public function __construct(){
    $this->subject = 'Subject';
    $this->expediteur = 'expediteur@mail.com';
  }

  public function getSubject(){
    return $this->subject;
  }

  public function setSubject($subject){
    $this->subject = $subject;
  }

  public function getExpediteur(){
    return $this->expediteur;
  }

  public function setExepediteur($expediteur){
    $this->expediteur = $expediteur;
  }
}
