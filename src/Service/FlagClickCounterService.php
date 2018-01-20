<?php

namespace Drupal\flag_click_counter\Service;


use Drupal\Core\Database\Connection;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\flag\FlagService;
use Drupal\flag_click_counter\Entity\FlagClickCounter;
use Symfony\Component\HttpFoundation\Request;

class FlagClickCounterService implements FlagClickCounterServiceInterface {
    protected $flagService;
    protected $entityTypeManager;
    protected $currentUser;
    protected $connection;

    /**
     * Constructs a new FlagClickCounterService object.
     */
    public function __construct(FlagService $flag,
                                EntityTypeManagerInterface $entity_type_manager, Connection $connection) {
        $this->flagService = $flag;

        $this->entityTypeManager = $entity_type_manager;
        $this->connection = $connection;
    }
    public function flag($flagId, $entityId, Request $request, $user_id){
        //drupal_set_message($flagId.' -> '.$entityId.' <> '.$user_id.'--'.$this->flagService->getFlagById($flagId)->label());
        $this->countFlag($flagId, $user_id);
    }
    public function getUserFlagClickCounterEntity($flagId, $userId){
        //$this->flagService->getFlagById($flagId)->id();
        $storage = $this->entityTypeManager->getStorage('flag_click_counter');
        $ids = $storage->getQuery()
            ->condition('user_id', $userId, '=')
            ->condition('flag_id', $flagId, '=')
            ->execute();
        return $storage->loadMultiple($ids);
    }
    public function countFlag($flagId, $userId){
        $flagClickCounterEntities = $this->getUserFlagClickCounterEntity($flagId, $userId);
        if (count($flagClickCounterEntities) == 0){
            FlagClickCounter::create([
                'uid' => $userId,
                'name' => $this->flagService->getFlagById($flagId)->label(),
                'flag_id' => $this->flagService->getFlagById($flagId)->id(),
                'total_clicks' => 1,
            ])->save();
        }
        else if (count($flagClickCounterEntities) == 1){
            $flagClickCounter = current($flagClickCounterEntities);
            $total_clicks = $flagClickCounter->getTotalClicks();
            $flagClickCounter->setTotalClicks($total_clicks);
            $flagClickCounter->save();
        }
        else{

        }
    }
}