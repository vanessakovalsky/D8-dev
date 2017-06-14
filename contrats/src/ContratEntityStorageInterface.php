<?php

namespace Drupal\contrats;

use Drupal\Core\Entity\ContentEntityStorageInterface;
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
interface ContratEntityStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Contrat entity revision IDs for a specific Contrat entity.
   *
   * @param \Drupal\contrats\Entity\ContratEntityInterface $entity
   *   The Contrat entity entity.
   *
   * @return int[]
   *   Contrat entity revision IDs (in ascending order).
   */
  public function revisionIds(ContratEntityInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Contrat entity author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Contrat entity revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\contrats\Entity\ContratEntityInterface $entity
   *   The Contrat entity entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(ContratEntityInterface $entity);

  /**
   * Unsets the language for all Contrat entity with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
