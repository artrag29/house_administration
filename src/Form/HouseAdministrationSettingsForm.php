<?php

namespace Drupal\house_administration\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class HouseAdministrationSettingsForm.
 *
 * @ingroup house_administration
 */
class HouseAdministrationSettingsForm extends FormBase {

  /**
   * Returns a unique string identifying the form.
   *
   * @return string
   *   The unique string identifying the form.
   */
  public function getFormId() {
    return 'house_administration_settings';
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['contact_settings']['#markup'] = 'Settings form for House administration. Manage field settings here.';
    return $form;
  }

}
