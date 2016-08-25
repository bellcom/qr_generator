<?php

/**
 * @file
 * Contains \Drupal\qr_generator\QRGeneratorInterface.
 */

namespace Drupal\qr_generator;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining QR Code entities.
 *
 * @ingroup qr_generator
 */
interface QRGeneratorInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {
  // Add get/set methods for your configuration properties here.
  /**
   * Gets the QR Code name.
   *
   * @return string
   *   Name of the QR Code.
   */
  public function getName();

  /**
   * Sets the QR Code name.
   *
   * @param string $name
   *   The QR Code name.
   *
   * @return \Drupal\qr_generator\QRGeneratorInterface
   *   The called QR Code entity.
   */
  public function setName($name);

  /**
   * Gets the QR Code creation timestamp.
   *
   * @return int
   *   Creation timestamp of the QR Code.
   */
  public function getCreatedTime();

  /**
   * Sets the QR Code creation timestamp.
   *
   * @param int $timestamp
   *   The QR Code creation timestamp.
   *
   * @return \Drupal\qr_generator\QRGeneratorInterface
   *   The called QR Code entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the QR Code published status indicator.
   *
   * Unpublished QR Code are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the QR Code is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a QR Code.
   *
   * @param bool $published
   *   TRUE to set this QR Code to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\qr_generator\QRGeneratorInterface
   *   The called QR Code entity.
   */
  public function setPublished($published);

  /**
   * Returns the URL the QR code listens to.
   *
   * @return string
   */
   public function getIncomingURL();

   /**
    * Returns the URL the QR code redirects to.
    *
    * @return string
    */
    public function getOutgoingURL();

    /**
     * Sets the listening URL on the QR Code.
     *
     * @param bool $url
     *   The URL we listen to.
     *
     * @return \Drupal\qr_generator\QRGeneratorInterface
     *   The called QR Code entity.
     */
    public function setIncomingURL($url);

    /**
     * Sets the URL we want to redirect to on the QR Code.
     *
     * @param bool $url
     *   The URL we want to redirect to.
     *
     * @return \Drupal\qr_generator\QRGeneratorInterface
     *   The called QR Code entity.
     */
    public function setOutgoingURL($url);
}
