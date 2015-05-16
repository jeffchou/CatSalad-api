<?php
namespace catsalad\V1\Rest\Battle;

class SimpleBattleEntity
{
	public $id;
	public $name;
	public $activated_at;
	public $created_at;
	public $updated_at;

	public function getArrayCopy()
    {
        return array(
            BattleJsonKey::Id 		 		=> $this->id,
            BattleJsonKey::Name 			=> $this->name,
            BattleJsonKey::ActivatedAt      => $this->activated_at,
            BattleJsonKey::CreatedAt      	=> $this->created_at,
            BattleJsonKey::UpdatedAt      	=> $this->updated_at,
        );
    }
 
    public function exchangeArray(array $array)
    {
    	$this->id = $array[BattleJsonKey::Id];
    	$this->name = $array[BattleJsonKey::Name];
        $this->activated_at = $array[BattleJsonKey::ActivatedAt];
    	$this->created_at = $array[BattleJsonKey::CreatedAt];
    	$this->updated_at = $array[BattleJsonKey::UpdatedAt];
    }
}
