<?php

namespace Drupal\demo_formation\Controller;

class DemoFormationController {

  protected $mailer;
  protected $logger;

  public function __construct(){
    $this->mailer = \Drupal::service('plugin.manager.mail');
    $this->logger = \Drupal::logger();
  }

  public function sendMailAndLog($expediteur, $destinataire, $module, $subject, $content, $level= INFO){
    //$current_user = \Drupal::currentUser();
    //Récupère d'abord la langue de la page courante, si vide va chercher celle de l'utilisateur courant
    $langcode = \Drupal::languageManager()->getCurrentLanguage()->getId();
    $site_name = \Drupal::config('system.site')->get('name');
    $params = array(
      'message' => $content,
      'subject' => $site_name.$subject,
    );
    $this->mailer->mail($module, 'service_mail_and_log', $destinataire, $langcode, $params, $expediteur, $send=NULL );
    $log_message = $expediteur.$destinataire.$subject.$content;
    \Drupal::logger($module)->notice($log_message);
  }
}
