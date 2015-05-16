<?php
namespace catsalad\V1\Rest\Weapon;

class WeaponEntity
{
	public $id;
	public $name;
	public $atack_bonus;
    public $available_level;
	public $image_url;
	public $created_at;
	public $updated_at;

	public function getArrayCopy()
    {
        return array(
            WeaponJsonKey::Id 			 	=> $this->id,
            WeaponJsonKey::Name 			=> $this->name,
            WeaponJsonKey::AttackBonus 		=> $this->attack_bonus,
            WeaponJsonKey::AvailableLevel   => $this->available_level,
            WeaponJsonKey::ImageUrl         => $this->image_url,
            WeaponJsonKey::CreatedAt        => $this->created_at,
            WeaponJsonKey::UpdatedAt        => $this->updated_at,
        );
    }
 
    public function exchangeArray(array $array)
    {
    	$this->id = $array[WeaponJsonKey::Id];
    	$this->name = $array[WeaponJsonKey::Name];
    	$this->attack_bonus = $array[WeaponJsonKey::AttackBonus];
        $this->available_level = $array[WeaponJsonKey::AvailableLevel];
        $this->image_url = $array[WeaponJsonKey::ImageUrl];
    	$this->created_at = $array[WeaponJsonKey::CreatedAt];
    	$this->updated_at = $array[WeaponJsonKey::UpdatedAt];
    }
}
