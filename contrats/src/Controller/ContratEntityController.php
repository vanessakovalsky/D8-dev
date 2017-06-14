<?php

namespace Drupal\contrats\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\contrats\Entity\ContratEntityInterface;

/**
 * Class ContratEntityController.
 *
 *  Returns responses for Contrat entity routes.
 *
 * @package Drupal\contrats\Controller
 */
class ContratEntityController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Contrat entity  revision.
   *
   * @param int $contrat_entity_revision
   *   The Contrat entity  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($contrat_entity_revision) {
    $contrat_entity = $this->entityManager()->getStorage('contrat_entity')->loadRevision($contrat_entity_revision);
    $view_builder = $this->entityManager()->getViewBuilder('contrat_entity');

    return $view_builder->view($contrat_entity);
  }

  /**
   * Page title callback for a Contrat entity  revision.
   *
   * @param int $contrat_entity_revision
   *   The Contrat entity  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($contrat_entity_revision) {
    $contrat_entity = $this->entityManager()->getStorage('contrat_entity')->loadRevision($contrat_entity_revision);
    return $this->t('Revision of %title from %date', ['%title' => $contrat_entity->label(), '%date' => format_date($contrat_entity->getRevisionCreationTime())]);
  }

  /**
   * Generates an overview table of older revisions of a Contrat entity .
   *
   * @param \Drupal\contrats\Entity\ContratEntityInterface $contrat_entity
   *   A Contrat entity  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(ContratEntityInterface $contrat_entity) {
    $account = $this->currentUser();
    $langcode = $contrat_entity->language()->getId();
    $langname = $contrat_entity->language()->getName();
    $languages = $contrat_entity->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $contrat_entity_storage = $this->entityManager()->getStorage('contrat_entity');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $contrat_entity->label()]) : $this->t('Revisions for %title', ['%title' => $contrat_entity->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all contrat entity revisions") || $account->hasPermission('administer contrat entity entities')));
    $delete_permission = (($account->hasPermission("delete all contrat entity revisions") || $account->hasPermission('administer contrat entity entities')));

    $rows = [];

    $vids = $contrat_entity_storage->revisionIds($contrat_entity);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\contrats\ContratEntityInterface $revision */
      $revision = $contrat_entity_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $contrat_entity->getRevisionId()) {
          $link = $this->l($date, new Url('entity.contrat_entity.revision', ['contrat_entity' => $contrat_entity->id(), 'contrat_entity_revision' => $vid]));
        }
        else {
          $link = $contrat_entity->link($date);
        }

        $row = [];
        $column = [
          'data' => [
            '#type' => 'inline_template',
            '#template' => '{% trans %}{{ date }} by {{ username }}{% endtrans %}{% if message %}<p class="revision-log">{{ message }}</p>{% endif %}',
            '#context' => [
              'date' => $link,
              'username' => \Drupal::service('renderer')->renderPlain($username),
              'message' => ['#markup' => $revision->getRevisionLogMessage(), '#allowed_tags' => Xss::getHtmlTagList()],
            ],
          ],
        ];
        $row[] = $column;

        if ($latest_revision) {
          $row[] = [
            'data' => [
              '#prefix' => '<em>',
              '#markup' => $this->t('Current revision'),
              '#suffix' => '</em>',
            ],
          ];
          foreach ($row as &$current) {
            $current['class'] = ['revision-current'];
          }
          $latest_revision = FALSE;
        }
        else {
          $links = [];
          if ($revert_permission) {
            $links['revert'] = [
              'title' => $this->t('Revert'),
              'url' => $has_translations ?
              Url::fromRoute('entity.contrat_entity.translation_revert', ['contrat_entity' => $contrat_entity->id(), 'contrat_entity_revision' => $vid, 'langcode' => $langcode]) :
              Url::fromRoute('entity.contrat_entity.revision_revert', ['contrat_entity' => $contrat_entity->id(), 'contrat_entity_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.contrat_entity.revision_delete', ['contrat_entity' => $contrat_entity->id(), 'contrat_entity_revision' => $vid]),
            ];
          }

          $row[] = [
            'data' => [
              '#type' => 'operations',
              '#links' => $links,
            ],
          ];
        }

        $rows[] = $row;
      }
    }

    $build['contrat_entity_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
