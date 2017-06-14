<?php

namespace Drupal\contrats;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Contrat entity entity.
 *
 * @see \Drupal\contrats\Entity\ContratEntity.
 */
class ContratEntityAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\contrats\Entity\ContratEntityInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished contrat entity entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published contrat entity entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit contrat entity entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete contrat entity entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add contrat entity entities');
  }

}
