<?php

namespace Drupal\flag_click_counter\Service;

use Symfony\Component\HttpFoundation\Request;

interface FlagClickCounterServiceInterface{
/*    public function flag($flag, $entity, Request $request, $user_id);
    public function getUserFlagClickCounterEntity($flagId, $userId);*/
    public function countFlag($flagId, $entityDetails);
    public function getCount($entityId, $userId);
    public function setFlagIsCountable($flagMachineName, $status);
    public function isFlagCountable($flagMachineName);
}