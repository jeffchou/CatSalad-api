<?php
namespace catsalad\V1\Rest\Battle_boss;

class Battle_bossEntity
{
	public $id;
	public $name;
	public $hp;
	public $description;
	public $spawn_time;
	public $attack_pattern;
	public $image_url;
	public $created_at;
	public $updated_at;

	public function getArrayCopy()
    {
        return array(
            BattleBattleBossJsonKey::Id 		=> $this->id,
            BattleBossJsonKey::Name 			=> $this->name,
            BattleBossJsonKey::Hp 				=> $this->hp,
            BattleBossJsonKey::Description 		=> $this->description,
            BattleBossJsonKey::SpawnTime 		=> $this->spawn_time,
            BattleBossJsonKey::AttackPattern 	=> $this->attack_pattern,
            BattleBossJsonKey::ImageUrl       	=> $this->image_url,
            BattleBossJsonKey::CreatedAt      	=> $this->created_at,
            BattleBossJsonKey::UpdatedAt      	=> $this->updated_at,
        );
    }
 
    public function exchangeArray(array $array)
    {
    	$this->id = $array[BattleBossJsonKey::Id];
    	$this->name = $array[BattleBossJsonKey::Name];
    	$this->hp = $array[BattleBossJsonKey::Hp];
    	$this->description = $array[BattleBossJsonKey::Description];
    	$this->spawn_time = $array[BattleBossJsonKey::SpawnTime];
    	$this->attack_pattern = $array[BattleBossJsonKey::AttackPattern];
        $this->image_url = $array[BattleBossJsonKey::ImageUrl];
    	$this->created_at = $array[BattleBossJsonKey::CreatedAt];
    	$this->updated_at = $array[BattleBossJsonKey::UpdatedAt];
    }
}
