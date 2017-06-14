<?php

namespace Drupal\contrats\Entity;

use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\RevisionableInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Contrat entity entities.
 *
 * @ingroup contrats
 */
interface ContratEntityInterface extends RevisionableInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Contrat entity name.
   *
   * @return string
   *   Name of the Contrat entity.
   */
  public function getName();

  /**
   * Sets the Contrat entity name.
   *
   * @param string $name
   *   The Contrat entity name.
   *
   * @return \Drupal\contrats\Entity\ContratEntityInterface
   *   The called Contrat entity entity.
   */
  public function setName($name);

  /**
   * Gets the Contrat entity creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Contrat entity.
   */
  public function getCreatedTime();

  /**
   * Sets the Contrat entity creation timestamp.
   *
   * @param int $timestamp
   *   The Contrat entity creation timestamp.
   *
   * @return \Drupal\contrats\Entity\ContratEntityInterface
   *   The called Contrat entity entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Contrat entity published status indicator.
   *
   * Unpublished Contrat entity are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Contrat entity is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Contrat entity.
   *
   * @param bool $published
   *   TRUE to set this Contrat entity to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\contrats\Entity\ContratEntityInterface
   *   The called Contrat entity entity.
   */
  public function setPublished($published);

  /**
   * Gets the Contrat entity revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Contrat entity revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\contrats\Entity\ContratEntityInterface
   *   The called Contrat entity entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Contrat entity revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Contrat entity revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\contrats\Entity\ContratEntityInterface
   *   The called Contrat entity entity.
   */
  public function setRevisionUserId($uid);

}
