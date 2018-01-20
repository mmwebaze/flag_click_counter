<?php

/**
* Implements hook_views_data_alter().
*/
function flag_click_counter_views_data_alter(array &$data) {
    $flag_click_counter_entities = \Drupal::service('flag_click_counter.service')->getFlagClickCounterEntities();
    foreach ($flag_click_counter_entities as $flag_click_counter_entity){
        print_r($flag_click_counter_entity->id());
    }
}