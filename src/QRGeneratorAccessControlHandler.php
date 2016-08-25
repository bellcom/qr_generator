<?php

/**
 * @file
 * Contains \Drupal\qr_generator\QRGeneratorAccessControlHandler.
 */

namespace Drupal\qr_generator;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the QR Code entity.
 *
 * @see \Drupal\qr_generator\Entity\QRGenerator.
 */
class QRGeneratorAccessControlHandler extends EntityAccessControlHandler {
  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\qr_generator\QRGeneratorInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished qr code entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published qr code entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit qr code entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete qr code entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add qr code entities');
  }

}
