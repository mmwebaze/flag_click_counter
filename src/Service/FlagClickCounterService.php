<?php

namespace Drupal\flag_click_counter\Service;


use Drupal\Core\Database\Connection;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Session\AccountInterface;

class FlagClickCounterService implements FlagClickCounterServiceInterface {
    protected $entityTypeManager;
    protected $currentUser;
    protected $connection;

    /**
     * Constructs a new FlagClickCounterService object.
     */
    public function __construct(EntityTypeManagerInterface $entity_type_manager, Connection $connection, AccountInterface $currentUser) {
        $this->entityTypeManager = $entity_type_manager;
        $this->connection = $connection;
        $this->currentUser = $currentUser;
    }
    public function countFlag($flagId, $entityDetails){
        $userId = $this->currentUser->id();
        $this->updateCount($userId, $flagId, $entityDetails);
    }
    public function getCount($entity_id, $userId){
        $result = [];
        $query = $this->connection->select('flag_click_counter', 'fcc');
        $results = $query->fields('fcc', ['uid','click_count'])
            ->condition('fcc.entity_id', $entity_id)
            ->condition('fcc.uid', $userId)->execute()->fetchAssoc();
        foreach ($results as $result){
            $result[0] = $result['click_count'];
        }
        return $result[0];
    }
    public function getEntityById($entity_id, $entity_type = 'node'){
        $storage = $this->entityTypeManager->getStorage($entity_type);
        return $storage->load($entity_id);
    }
    private function updateCount($userId, $flagId, $entityDetails){
        $query = $this->connection->select('flag_click_counter', 'fcc');
        $results = $query->fields('fcc', ['uid', 'flag','entity_id'])
            ->condition('fcc.uid', $userId)
            ->condition('fcc.flag', $flagId)
            ->condition('fcc.entity_id', $entityDetails[2])
            ->execute()->fetchall();

        if (count($results) == 0){
            $this->createRecord($userId, $flagId, $entityDetails[1], $entityDetails[2], 1);
        }
        else {
            $this->updateRecord($userId, $flagId, $entityDetails[2]);
        }
    }
    private function createRecord($uid, $flag, $entityType, $entity_id, $count){
        $this->connection->insert('flag_click_counter')
            ->fields([
                'uid',
                'flag',
                'entity_type',
                'entity_id',
                'click_count',
            ])
            ->values(array(
                $uid,
                $flag,
                $entityType,
                $entity_id,
                $count
            ))
            ->execute();
    }
    private function updateRecord($uid, $flag, $entityId){
        $this->connection->update('flag_click_counter')
            ->expression('click_count', 'click_count + 1')
            ->condition('$flag', $flag)
            ->condition('uid', $uid)
            ->condition('entity_id', $entityId)->execute();
    }
}