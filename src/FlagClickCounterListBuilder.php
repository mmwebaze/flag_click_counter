<?php

namespace Drupal\flag_click_counter;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Flag click counter entities.
 *
 * @ingroup flag_click_counter
 */
class FlagClickCounterListBuilder extends EntityListBuilder {


  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Flag click counter ID');
    $header['name'] = $this->t('Flag Name');
    $header['flag_id'] = $this->t('Flag ID');
    $header['total_clicks'] = $this->t('Total clicks');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\flag_click_counter\Entity\FlagClickCounter */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.flag_click_counter.edit_form',
      ['flag_click_counter' => $entity->id()]
    );
    $row['flag_id'] = $entity->getFlagId();
    $row['total_clicks'] = $entity->getTotalClicks();
    return $row + parent::buildRow($entity);
  }

}
