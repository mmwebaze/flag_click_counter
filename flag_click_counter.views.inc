<?php

/**
* Implements hook_views_data_alter().
*/
function flag_click_counter_views_data_alter(array &$data) {

    $data['node']['flag_click_count'] = array(
        'title' => t('Flag click counter hmmm'),
        'field' => array(
            'title' => t('Flag click count'),
            'help' => t('Flag counts.'),
            'id' => 'flag_click_counter_counts',
        ),
    );
}