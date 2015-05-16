<?php
namespace catsalad\V1\Rest\Boss;

class BossEntity
{
	public $id;
	public $name;
	public $hp;
	public $description;
	public $attack_pattern;
	public $image_url;
	public $created_at;
	public $updated_at;

	public function getArrayCopy()
    {
        return array(
            BossJsonKey::Id 		 	=> $this->id,
            BossJsonKey::Name 			=> $this->name,
            BossJsonKey::Hp 			=> $this->hp,
            BossJsonKey::Description 	=> $this->description,
            BossJsonKey::AttackPattern 	=> $this->attack_pattern,
            BossJsonKey::ImageUrl       => $this->image_url,
            BossJsonKey::CreatedAt      => $this->created_at,
            BossJsonKey::UpdatedAt      => $this->updated_at,
        );
    }
 
    public function exchangeArray(array $array)
    {
    	$this->id = $array[BossJsonKey::Id];
    	$this->name = $array[BossJsonKey::Name];
    	$this->hp = $array[BossJsonKey::Hp];
    	$this->description = $array[BossJsonKey::Description];
    	$this->attack_pattern = $array[BossJsonKey::AttackPattern];
        $this->image_url = $array[BossJsonKey::ImageUrl];
    	$this->created_at = $array[BossJsonKey::CreatedAt];
    	$this->updated_at = $array[BossJsonKey::UpdatedAt];
    }
}
