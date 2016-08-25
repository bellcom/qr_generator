<?php

/**
 * @file
 * Contains \Drupal\qr_generator\Form\QRGeneratorSettingsForm.
 */

namespace Drupal\qr_generator\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class QRGeneratorSettingsForm.
 *
 * @package Drupal\qr_generator\Form
 *
 * @ingroup qr_generator
 */
class QRGeneratorSettingsForm extends FormBase {
  /**
   * Returns a unique string identifying the form.
   *
   * @return string
   *   The unique string identifying the form.
   */
  public function getFormId() {
    return 'QRGenerator_settings';
  }

  /**
   * Form submission handler.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Empty implementation of the abstract submit class.
  }


  /**
   * Defines the settings form for QR Code entities.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   *
   * @return array
   *   Form definition array.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['QRGenerator_settings']['#markup'] = 'Settings form for QR Code entities. Manage field settings here.';
    return $form;
  }

}
