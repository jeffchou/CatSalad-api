<?php
namespace catsalad\V1\Rest\Cat;

use catsalad\V1\Rest\Cat\CatJsonKey;

class SimpleCatEntity
{
	public $id;
	public $name;
    public $equipped_weapon_id;
	public $created_at;
	public $updated_at;

	public function getArrayCopy()
    {
        return array(
            CatJsonKey::Id 				 	=> $this->id,
            CatJsonKey::Name 				=> $this->name,
            CatJsonKey::EquippedWeaponId    => $this->equipped_weapon_id,
            CatJsonKey::Location            => $this->location,
            CatJsonKey::CreatedAt 			=> $this->created_at,
            CatJsonKey::UpdatedAt 			=> $this->updated_at
        );
    }
 
    public function exchangeArray(array $array)
    {
    	$this->id = $array[CatJsonKey::Id];
    	$this->name = $array[CatJsonKey::Name];
        $this->equipped_weapon_id = $array[CatJsonKey::EquippedWeaponId];
    	$this->created_at = $array[CatJsonKey::CreatedAt];
    	$this->updated_at = $array[CatJsonKey::UpdatedAt];
    }
}
