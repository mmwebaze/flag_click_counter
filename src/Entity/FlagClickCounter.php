<?php

namespace Drupal\flag_click_counter\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;

/**
 * Defines the Flag click counter entity.
 *
 * @ingroup flag_click_counter
 *
 * @ContentEntityType(
 *   id = "flag_click_counter",
 *   label = @Translation("Flag click counter"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\flag_click_counter\FlagClickCounterListBuilder",
 *     "views_data" = "Drupal\flag_click_counter\Entity\FlagClickCounterViewsData",
 *
 *     "form" = {
 *       "default" = "Drupal\flag_click_counter\Form\FlagClickCounterForm",
 *       "add" = "Drupal\flag_click_counter\Form\FlagClickCounterForm",
 *       "edit" = "Drupal\flag_click_counter\Form\FlagClickCounterForm",
 *       "delete" = "Drupal\flag_click_counter\Form\FlagClickCounterDeleteForm",
 *     },
 *     "access" = "Drupal\flag_click_counter\FlagClickCounterAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\flag_click_counter\FlagClickCounterHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "flag_click_counter",
 *   admin_permission = "administer flag click counter entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "status" = "status",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/flag_click_counter/{flag_click_counter}",
 *     "add-form" = "/admin/structure/flag_click_counter/add",
 *     "edit-form" = "/admin/structure/flag_click_counter/{flag_click_counter}/edit",
 *     "delete-form" = "/admin/structure/flag_click_counter/{flag_click_counter}/delete",
 *     "collection" = "/admin/structure/flag_click_counter",
 *   },
 *   field_ui_base_route = "flag_click_counter.settings"
 * )
 */
class FlagClickCounter extends ContentEntityBase implements FlagClickCounterInterface {

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
    $this->set('status', $published ? TRUE : FALSE);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

      $fields['flag_id'] = BaseFieldDefinition::create('entity_reference')
          ->setLabel(t('Flag id'))
          ->setDescription(t('The flag ID associated with this Flag click counter entity.'))
          ->setRevisionable(TRUE)
          ->setSetting('target_type', 'flag')
          ->setSetting('handler', 'default')
          ->setTranslatable(TRUE)
          ->setReadOnly(TRUE)
          ->setDisplayOptions('view', [
              'label' => 'hidden',
              'type' => 'author',
              'weight' => 0,
          ])
          ->setDisplayOptions('form', [
              'type' => 'entity_reference_autocomplete',
              'weight' => 5,
              'settings' => [
                  'match_operator' => 'CONTAINS',
                  'size' => '60',
                  'autocomplete_type' => 'tags',
                  'placeholder' => '',
              ],
          ])
          ->setDisplayConfigurable('form', TRUE)
          ->setDisplayConfigurable('view', TRUE);

    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Authored by'))
      ->setDescription(t('The user ID of author of the Flag click counter entity.'))
      ->setRevisionable(TRUE)
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'author',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'weight' => 5,
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ],
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the Flag click counter entity.'))
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

      $fields['total_clicks'] = BaseFieldDefinition::create('integer')
          ->setLabel(t('Total Clicks'))
          ->setDescription(t('The total clicks of a particular Flag associated with a user.'))
          ->setDefaultValue(0)
          ->setReadOnly(TRUE)
          ->setDisplayOptions('view', [
              'label' => 'above',
              'type' => 'string',
              'weight' => -4,
          ])
          ->setDisplayOptions('form', [
              'type' => 'string_textfield',
              'weight' => -4,
          ])
          ->setDisplayConfigurable('form', TRUE)
          ->setDisplayConfigurable('view', TRUE);

    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Publishing status'))
      ->setDescription(t('A boolean indicating whether the Flag click counter is published.'))
      ->setDefaultValue(TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }
  public function setFlagId($flagId){
      $this->set('flag_id', $flagId);
      return $this;
  }
  public function getFlagId(){
      return $this->get('flag_id')->target_id;
  }
    public function setTotalClicks($total_clicks){
        $this->set('total_clicks', $total_clicks + 1);
        return $this;
    }
    public function getTotalClicks(){
        return $this->get('total_clicks')->value;
    }
}
