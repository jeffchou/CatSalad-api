<?php
namespace catsalad\V1\Rest\Battle_boss;

class Battle_bossSimpleEntity
{
	public $id;
	public $attack_pattern;
	public $created_at;
	public $updated_at;

	public function getArrayCopy()
    {
        return array(
            BattleBattleBossJsonKey::Id 		=> $this->id,
            BattleBossJsonKey::AttackPattern 	=> $this->attack_pattern,
            BattleBossJsonKey::CreatedAt      	=> $this->created_at,
            BattleBossJsonKey::UpdatedAt      	=> $this->updated_at,
        );
    }
 
    public function exchangeArray(array $array)
    {
    	$this->id = $array[BattleBossJsonKey::Id];
    	$this->attack_pattern = $array[BattleBossJsonKey::AttackPattern];
    	$this->created_at = $array[BattleBossJsonKey::CreatedAt];
    	$this->updated_at = $array[BattleBossJsonKey::UpdatedAt];
    }
}
