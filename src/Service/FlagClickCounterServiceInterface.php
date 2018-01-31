<?php

namespace Drupal\flag_click_counter\Service;

use Symfony\Component\HttpFoundation\Request;

interface FlagClickCounterServiceInterface{
    public function countFlag($flagId, $entityDetails);
    public function getCount($entityId, $userId);
    public function getEntityById($entity_id, $entity_type = 'node');
}