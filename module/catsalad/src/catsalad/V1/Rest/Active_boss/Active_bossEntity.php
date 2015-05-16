<?php
namespace catsalad\V1\Rest\Active_boss;

class Active_bossEntity
{
	public $id;
	public $order;
    public $boss;
    public $created_at;
    public $updated_at;

	public function getArrayCopy()
    {
        return array(
            ActiveBossJsonKey::Id 		 	  => $this->id,
            ActiveBossJsonKey::Order 		  => $this->order,
            ActiveBossJsonKey::Boss           => $this->boss,
            ActiveBossJsonKey::CreatedAt      => $this->created_at,
            ActiveBossJsonKey::UpdatedAt      => $this->updated_at,
        );
    }
 
    public function exchangeArray(array $array)
    {
    	$this->id = $array[ActiveBossJsonKey::Id];
    	$this->order = $array[ActiveBossJsonKey::Order];
        $this->boss = $array[ActiveBossJsonKey::Boss];
    	$this->created_at = $array[ActiveBossJsonKey::CreatedAt];
    	$this->updated_at = $array[ActiveBossJsonKey::UpdatedAt];
    }
}
