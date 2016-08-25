<?php

/**
 * @file
 * Contains \Drupal\qr_generator\QRGeneratorListBuilder.
 */

namespace Drupal\qr_generator;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Routing\LinkGeneratorTrait;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of QR Code entities.
 *
 * @ingroup qr_generator
 */
class QRGeneratorListBuilder extends EntityListBuilder {
  use LinkGeneratorTrait;
  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('QR Code ID');
    $header['name'] = $this->t('Name');
    $header['incoming_url'] = $this->t('URL (incoming)');
    $header['outgoing_url'] = $this->t('URL (outgoing)');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\qr_generator\Entity\QRGenerator */
    $row['id'] = $entity->id();
    $row['name'] = $this->l(
      $entity->label(),
      new Url(
        'entity.qr_generator.edit_form', array(
          'qr_generator' => $entity->id(),
        )
      )
    );
    $row['incoming_url'] = $entity->getIncomingURL();
    $row['outgoing_url'] = $entity->getOutgoingURL();
    return $row + parent::buildRow($entity);
  }

}
