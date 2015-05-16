<?php
namespace catsalad\V1\Rest\Active_boss;

use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\AdapterInterface;

use catsalad\V1\Rest\BossJsonKey;

class ActiveBossCollectionEntity
{
	public $id;
	public $order;
    public $boss_id;
	public $created_at;
	public $updated_at;

	public function getArrayCopy()
    {
        return array(
            ActiveBossJsonKey::Id 			=> $this->id,
            ActiveBossJsonKey::Order 		=> $this->order,
            ActiveBossJsonKey::BossId       => $this->boss_id,
            ActiveBossJsonKey::CreatedAt 	=> $this->created_at,
            ActiveBossJsonKey::UpdatedAt 	=> $this->updated_at
        );
    }
 
    public function exchangeArray(array $array)
    {
    	$this->id = $array[ActiveBossJsonKey::Id];
    	$this->order = $array[ActiveBossJsonKey::Order];
        $this->boss_id = $array[ActiveBossJsonKey::BossId];
        if (!empty($array[ActiveBossJsonKey::Boss])) {
            $this->boss = $array[ActiveBossJsonKey::Boss];
        }
    	$this->created_at = $array[ActiveBossJsonKey::CreatedAt];
    	$this->updated_at = $array[ActiveBossJsonKey::UpdatedAt];
    }
}