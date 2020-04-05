<?php

namespace Drupal\house_administration\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;
use Drupal\Core\Entity\EntityChangedTrait;

/**
 * Defines the HouseAdministration entity.
 *
 * @ingroup house_administration
 *
 * @ContentEntityType(
 *   id = "house_administration",
 *   label = @Translation("House administration"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\house_administration\Controller\HouseAdministrationListBuilder",
 *     "form" = {
 *       "default" = "Drupal\house_administration\Form\HouseAdministrationForm",
 *       "add" = "Drupal\house_administration\Form\HouseAdministrationForm",
 *       "edit" = "Drupal\house_administration\Form\HouseAdministrationForm",
 *       "delete" = "Drupal\house_administration\Form\HouseAdministrationDeleteForm",
 *     },
 *     "access" = "Drupal\house_administration\HouseAdministrationAccessControlHandler",
 *   },
 *   base_table = "house_administration",
 *   admin_permission = "administer house administration entity",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "address",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/house_administration/{house_administration}",
 *     "edit-form" = "/house_administration/{house_administration}/edit",
 *     "delete-form" = "/house/{house_administration}/delete",
 *     "collection" = "/house_administration/list"
 *   },
 *   field_ui_base_route = "house_administration.house_administration_settings",
 * )
 */
class HouseAdministration extends ContentEntityBase implements HouseAdministrationInterface {

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
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('The ID of the House administration entity.'))
      ->setReadOnly(TRUE);

    $fields['uuid'] = BaseFieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setDescription(t('The UUID of the House administration entity.'))
      ->setReadOnly(TRUE);


    $fields['address'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Adress'))
      ->setDescription(t('Adress of the House.'))
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ])
      ->setDefaultValue(NULL)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -6,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -6,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);


    $fields['attribute'] = BaseFieldDefinition::create('list_string')
      ->setLabel(t('Attribute'))
      ->setDescription(t('The attribute of the House.'))
      ->setSettings([
        'allowed_values' => [
          'renovated' => 'Renovated',
          'not_renovated' => 'Not renovated',
        ],
      ])
      ->setDefaultValue('not_renovated')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -2,
      ])
      ->setDisplayOptions('form', [
        'type' => 'options_select',
        'weight' => -2,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);


    $fields['year'] = BaseFieldDefinition::create('datetime')
      ->setLabel(t('Construction year'))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

}
