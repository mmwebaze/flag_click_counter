<?php

namespace Drupal\flag_click_counter;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Flag click counter entity.
 *
 * @see \Drupal\flag_click_counter\Entity\FlagClickCounter.
 */
class FlagClickCounterAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\flag_click_counter\Entity\FlagClickCounterInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished flag click counter entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published flag click counter entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit flag click counter entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete flag click counter entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add flag click counter entities');
  }

}
