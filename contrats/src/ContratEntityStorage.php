<?php

namespace Drupal\contrats;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\contrats\Entity\ContratEntityInterface;

/**
 * Defines the storage handler class for Contrat entity entities.
 *
 * This extends the base storage class, adding required special handling for
 * Contrat entity entities.
 *
 * @ingroup contrats
 */
class ContratEntityStorage extends SqlContentEntityStorage implements ContratEntityStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(ContratEntityInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {contrat_entity_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {contrat_entity_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(ContratEntityInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {contrat_entity_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('contrat_entity_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
