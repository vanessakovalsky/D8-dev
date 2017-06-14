<?php

namespace Drupal\contrats\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\RevisionableContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;

/**
 * Defines the Contrat entity entity.
 *
 * @ingroup contrats
 *
 * @ContentEntityType(
 *   id = "contrat_entity",
 *   label = @Translation("Contrat entity"),
 *   handlers = {
 *     "storage" = "Drupal\contrats\ContratEntityStorage",
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\contrats\ContratEntityListBuilder",
 *     "views_data" = "Drupal\contrats\Entity\ContratEntityViewsData",
 *     "translation" = "Drupal\contrats\ContratEntityTranslationHandler",
 *
 *     "form" = {
 *       "default" = "Drupal\contrats\Form\ContratEntityForm",
 *       "add" = "Drupal\contrats\Form\ContratEntityForm",
 *       "edit" = "Drupal\contrats\Form\ContratEntityForm",
 *       "delete" = "Drupal\contrats\Form\ContratEntityDeleteForm",
 *     },
 *     "access" = "Drupal\contrats\ContratEntityAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\contrats\ContratEntityHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "contrat_entity",
 *   data_table = "contrat_entity_field_data",
 *   revision_table = "contrat_entity_revision",
 *   revision_data_table = "contrat_entity_field_revision",
 *   translatable = TRUE,
 *   admin_permission = "administer contrat entity entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "revision" = "vid",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "status" = "status",
 *     "title" = "title",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/contrat_entity/{contrat_entity}",
 *     "add-form" = "/admin/structure/contrat_entity/add",
 *     "edit-form" = "/admin/structure/contrat_entity/{contrat_entity}/edit",
 *     "delete-form" = "/admin/structure/contrat_entity/{contrat_entity}/delete",
 *     "version-history" = "/admin/structure/contrat_entity/{contrat_entity}/revisions",
 *     "revision" = "/admin/structure/contrat_entity/{contrat_entity}/revisions/{contrat_entity_revision}/view",
 *     "revision_revert" = "/admin/structure/contrat_entity/{contrat_entity}/revisions/{contrat_entity_revision}/revert",
 *     "translation_revert" = "/admin/structure/contrat_entity/{contrat_entity}/revisions/{contrat_entity_revision}/revert/{langcode}",
 *     "revision_delete" = "/admin/structure/contrat_entity/{contrat_entity}/revisions/{contrat_entity_revision}/delete",
 *     "collection" = "/admin/structure/contrat_entity",
 *   },
 *   field_ui_base_route = "contrat_entity.settings"
 * )
 */
class ContratEntity extends RevisionableContentEntityBase implements ContratEntityInterface {

  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += [
      'user_id' => \Drupal::currentUser()->id(),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function preSave(EntityStorageInterface $storage) {
    parent::preSave($storage);

    foreach (array_keys($this->getTranslationLanguages()) as $langcode) {
      $translation = $this->getTranslation($langcode);

      // If no owner has been set explicitly, make the anonymous user the owner.
      if (!$translation->getOwner()) {
        $translation->setOwnerId(0);
      }
    }

    // If no revision author has been set explicitly, make the contrat_entity owner the
    // revision author.
    if (!$this->getRevisionUser()) {
      $this->setRevisionUserId($this->getOwnerId());
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return $this->get('name')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setName($name) {
    $this->set('name', $name);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('user_id')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('user_id')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('user_id', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('user_id', $account->id());
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function isPublished() {
    return (bool) $this->getEntityKey('status');
  }

  /**
   * {@inheritdoc}
   */
  public function setPublished($published) {
    $this->set('status', $published ? TRUE : FALSE);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Authored by'))
      ->setDescription(t('The user ID of author of the Contrat entity entity.'))
      ->setRevisionable(TRUE)
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'author',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'weight' => 5,
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ],
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the Contrat entity entity.'))
      ->setRevisionable(TRUE)
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Publishing status'))
      ->setDescription(t('A boolean indicating whether the Contrat entity is published.'))
      ->setRevisionable(TRUE)
      ->setDefaultValue(TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    $fields['revision_translation_affected'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Revision translation affected'))
      ->setDescription(t('Indicates if the last edit of a translation belongs to current revision.'))
      ->setReadOnly(TRUE)
      ->setRevisionable(TRUE)
      ->setTranslatable(TRUE);

      $fields['title'] = BaseFieldDefinition::create('string')
        ->setLabel(t('Title'))
        ->setDescription(t('The title of the Contrat entity entity.'))
        ->setRevisionable(TRUE)
        ->setSettings([
          'max_length' => 50,
          'text_processing' => 0,
        ])
        ->setDefaultValue('')
        ->setDisplayOptions('view', [
          'label' => 'above',
          'type' => 'string',
          'weight' => -4,
        ])
        ->setDisplayOptions('form', [
          'type' => 'string_textfield',
          'weight' => -4,
        ])
        ->setDisplayConfigurable('form', TRUE)
        ->setDisplayConfigurable('view', TRUE);

    return $fields;
  }

}
