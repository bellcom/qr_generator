<?php

/**
 * @file
 * Contains \Drupal\qr_generator\Form\QRGeneratorForm.
 */

namespace Drupal\qr_generator\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for QR Code edit forms.
 *
 * @ingroup qr_generator
 */
class QRGeneratorForm extends ContentEntityForm {
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\qr_generator\Entity\QRGenerator */
    $form = parent::buildForm($form, $form_state);
    $entity = $this->entity;

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = $this->entity;
    $status = parent::save($form, $form_state);

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label QR Code.', [
          '%label' => $entity->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label QR Code.', [
          '%label' => $entity->label(),
        ]));
    }
    $form_state->setRedirect('entity.qr_generator.canonical', ['qr_generator' => $entity->id()]);
  }

}
