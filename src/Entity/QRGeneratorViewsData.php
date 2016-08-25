<?php

/**
 * @file
 * Contains \Drupal\qr_generator\Entity\QRGenerator.
 */

namespace Drupal\qr_generator\Entity;

use Drupal\views\EntityViewsData;
use Drupal\views\EntityViewsDataInterface;

/**
 * Provides Views data for QR Code entities.
 */
class QRGeneratorViewsData extends EntityViewsData implements EntityViewsDataInterface {
  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    $data['qr_generator']['table']['base'] = array(
      'field' => 'id',
      'title' => $this->t('QR Code'),
      'help' => $this->t('The QR Code ID.'),
    );

    return $data;
  }

}
