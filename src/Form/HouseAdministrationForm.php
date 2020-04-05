<?php

namespace Drupal\house_administration\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Language\Language;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the house_administration entity edit forms.
 *
 * @ingroup house_administration
 */
class HouseAdministrationForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\house_administration\Entity\HouseAdministration */
    $form = parent::buildForm($form, $form_state);
    $entity = $this->entity;

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
    $house = $this->entity;
    if (!$house->isNew()) {
      return;
    }

    /** @var \Drupal\Core\Entity\EntityStorageInterface $storage */
    $storage = $this->entityTypeManager->getStorage($house->getEntityTypeId());

    $properties = [
      'address' => $form_state->getValue(['address', 0, 'value']),
    ];

    if (!!$storage->loadByProperties(array_filter($properties))) {
      $form_state->setError($form, $this->t('House with this %address address already exists.', [
        '%address' => $properties['address'] ?? '',
      ]));
      return;
    }
  }
  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $form_state->setRedirect('entity.house_administration.collection');
    $entity = $this->getEntity();
    $entity->save();
  }

}
