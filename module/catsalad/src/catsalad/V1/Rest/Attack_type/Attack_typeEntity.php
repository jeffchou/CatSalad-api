<?php
namespace catsalad\V1\Rest\Attack_type;

class Attack_typeEntity
{
	public $id;
	public $name;
	public $created_at;
	public $updated_at;

	public function getArrayCopy()
    {
        return array(
            AttackTypeJsonKey::Id 				=> $this->id,
            AttackTypeJsonKey::Name 			=> $this->name,
            AttackTypeJsonKey::CreatedAt       	=> $this->created_at,
            AttackTypeJsonKey::UpdatedAt       	=> $this->updated_at,
        );
    }
 
    public function exchangeArray(array $array)
    {
    	$this->id = $array[AttackTypeJsonKey::Id];
    	$this->name = $array[AttackTypeJsonKey::Name];
    	$this->created_at = $array[AttackTypeJsonKey::CreatedAt];
    	$this->updated_at = $array[AttackTypeJsonKey::UpdatedAt];
    }
}
