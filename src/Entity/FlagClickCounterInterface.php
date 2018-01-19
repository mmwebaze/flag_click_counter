<?php

namespace Drupal\flag_click_counter\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Flag click counter entities.
 *
 * @ingroup flag_click_counter
 */
interface FlagClickCounterInterface extends  ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Flag click counter name.
   *
   * @return string
   *   Name of the Flag click counter.
   */
  public function getName();

  /**
   * Sets the Flag click counter name.
   *
   * @param string $name
   *   The Flag click counter name.
   *
   * @return \Drupal\flag_click_counter\Entity\FlagClickCounterInterface
   *   The called Flag click counter entity.
   */
  public function setName($name);

  /**
   * Gets the Flag click counter creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Flag click counter.
   */
  public function getCreatedTime();

  /**
   * Sets the Flag click counter creation timestamp.
   *
   * @param int $timestamp
   *   The Flag click counter creation timestamp.
   *
   * @return \Drupal\flag_click_counter\Entity\FlagClickCounterInterface
   *   The called Flag click counter entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Flag click counter published status indicator.
   *
   * Unpublished Flag click counter are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Flag click counter is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Flag click counter.
   *
   * @param bool $published
   *   TRUE to set this Flag click counter to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\flag_click_counter\Entity\FlagClickCounterInterface
   *   The called Flag click counter entity.
   */
  public function setPublished($published);

}
