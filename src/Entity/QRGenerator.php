<?php

/**
 * @file
 * Contains \Drupal\qr_generator\Entity\QRGenerator.
 */

namespace Drupal\qr_generator\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Link;
use Drupal\Core\Routing\TrustedRedirectResponse;
use Drupal\Core\Url;
use Drupal\qr_generator\QRGeneratorInterface;
use Drupal\user\UserInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Defines the QR Code entity.
 *
 * @ingroup qr_generator
 *
 * @ContentEntityType(
 *   id = "qr_generator",
 *   label = @Translation("QR Code"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\qr_generator\QRGeneratorListBuilder",
 *     "views_data" = "Drupal\qr_generator\Entity\QRGeneratorViewsData",
 *
 *     "form" = {
 *       "default" = "Drupal\qr_generator\Form\QRGeneratorForm",
 *       "add" = "Drupal\qr_generator\Form\QRGeneratorForm",
 *       "edit" = "Drupal\qr_generator\Form\QRGeneratorForm",
 *       "delete" = "Drupal\qr_generator\Form\QRGeneratorDeleteForm",
 *     },
 *     "access" = "Drupal\qr_generator\QRGeneratorAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\qr_generator\QRGeneratorHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "qr_generator",
 *   admin_permission = "administer qr code entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "status" = "status",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/qr_generator/{qr_generator}",
 *     "add-form" = "/admin/structure/qr_generator/add",
 *     "edit-form" = "/admin/structure/qr_generator/{qr_generator}/edit",
 *     "delete-form" = "/admin/structure/qr_generator/{qr_generator}/delete",
 *     "collection" = "/admin/structure/qr_generator",
 *   },
 *   field_ui_base_route = "qr_generator.settings"
 * )
 */
class QRGenerator extends ContentEntityBase implements QRGeneratorInterface {
  use EntityChangedTrait;
  /**
   * {@inheritdoc}
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += array(
      'user_id' => \Drupal::currentUser()->id(),
    );
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
    $this->set('status', $published ? NODE_PUBLISHED : NODE_NOT_PUBLISHED);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getIncomingURL() {
    foreach ($this->get('incoming_url')->getIterator() as $url) {
      $label = $url->get('title')->getValue();
      $link = new Link($label, $url->getUrl());
      if (empty($label)) {
        return Link::fromTextAndUrl($link->getUrl()->toString(), $link->getUrl());
      } else {
        return Link::fromTextAndUrl($link->getText(), $link->getUrl());
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function setIncomingURL($url) {
    $url = '/qr/' . $url;
    $this->set('incoming_url', 'internal:' . $url);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
   public function getOutgoingURL() {
     foreach ($this->get('outgoing_url')->getIterator() as $url) {
       return $url->getUrl();
     }
   }

  /**
   * {@inheritdoc}
   */
  public function getOutgoingLink() {
    if ($this->get('outgoing_url')->isEmpty()) {
      return $this->t('N/A');
    }
    foreach ($this->get('outgoing_url')->getIterator() as $url) {
      $label = $url->get('title')->getValue();
      $link = new Link($label, $url->getUrl());
      if (empty($label)) {
        return Link::fromTextAndUrl($link->getUrl()->toString(), $link->getUrl());
      } else {
        return Link::fromTextAndUrl($link->getText(), $link->getUrl());
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function setOutgoingURL($url) {
    $this->set('outgoing_url', $url);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
   public function getURLRedirections() {
     return $this->get('url_redirections')->value;
   }

   /**
    * {@inheritdoc}
    */
   public function setURLRedirections($amount) {
     $this->set('url_redirections', $amount);
     return $this;
   }

   /**
    * {@inheritdoc}
    */
   public function setURLStatus() {
     $this->set('url_status', $status);
     return $this;
   }

   /**
    * {@inheritdoc}
    */
   public function getURLStatus() {
     return $this->get('url_status')->value;
   }

   /**
    * {@inheritdoc}
    */
    public static function getIDByIncomingURL($url) {
      $id = \Drupal::entityQuery('qr_generator')
        ->condition('status', 1)
        ->condition('incoming_url__uri', 'internal:/qr/' . $url)
        ->execute();

      return reset($id);
    }

    /**
     * {@inheritdoc}
     */
     public function increaseURLRedirectCount($id) {
       $entity = QRGenerator::load($id);
       $amount = $entity->getURLRedirections() + 1;
       $entity->setURLRedirections($amount);
       $entity->save();
     }

     /**
      * {@inheritdoc}
      */
     public function redirect() {
       return new TrustedRedirectResponse($this->getOutgoingLink()->getUrl()->toString());
     }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('The ID of the QR Code entity.'))
      ->setReadOnly(TRUE);
    $fields['uuid'] = BaseFieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setDescription(t('The UUID of the QR Code entity.'))
      ->setReadOnly(TRUE);

    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Authored by'))
      ->setDescription(t('The user ID of author of the QR Code entity.'))
      ->setRevisionable(TRUE)
      ->setRequired(true)
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setDefaultValueCallback('Drupal\node\Entity\Node::getCurrentUserId')
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', array(
        'label' => 'hidden',
        'type' => 'author',
        'weight' => 0,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'entity_reference_autocomplete',
        'weight' => 5,
        'settings' => array(
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ),
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the QR Code entity.'))
      ->setSettings(array(
        'max_length' => 50,
        'text_processing' => 0,
      ))
      ->setRequired(true)
      ->setDefaultValue('')
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'string_textfield',
        'weight' => -4,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['incoming_url'] = BaseFieldDefinition::create('link')
      ->setLabel(t('Incoming URL'))
      ->setDescription(t('The internal URL this QR code listening to.'))
      ->setDefaultValue('')
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'string_textfield',
        'weight' => -4,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['outgoing_url'] = BaseFieldDefinition::create('link')
      ->setLabel(t('Outgoing URL'))
      ->setDescription(t('The URL this QR code redirects to.'))
      ->setDefaultValue('')
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'string_textfield',
        'weight' => -4,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['url_redirections'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('URL Redirects'))
      ->setDescription(t('The amount of URL redirects.'))
      ->setReadOnly(TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['url_status'] = BaseFieldDefinition::create('string')
      ->setLabel(t('URL status'))
      ->setDescription(t('The name of the QR Code entity.'))
      ->setReadOnly(TRUE)
      ->setDisplayConfigurable('form', FALSE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['qr_image'] = BaseFieldDefinition::create('uri')
      ->setLabel(t('QR image'))
      ->setDescription(t('The QR code image.'))
      ->setReadOnly(TRUE)
      ->setDisplayConfigurable('form', FALSE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['qr_image_logo'] = BaseFieldDefinition::create('uri')
      ->setLabel(t('QR image logo'))
      ->setDescription(t('Logo placed on QR code.'))
      ->setReadOnly(TRUE)
      ->setDisplayConfigurable('form', FALSE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Publishing status'))
      ->setDescription(t('A boolean indicating whether the QR Code is published.'))
      ->setDefaultValue(TRUE);

    $fields['langcode'] = BaseFieldDefinition::create('language')
      ->setLabel(t('Language code'))
      ->setDescription(t('The language code for the QR Code entity.'))
      ->setDisplayOptions('form', array(
        'type' => 'language_select',
        'weight' => 10,
      ))
      ->setDisplayConfigurable('form', TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

}
