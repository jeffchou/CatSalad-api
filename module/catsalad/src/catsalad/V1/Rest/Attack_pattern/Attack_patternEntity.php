<?php
namespace catsalad\V1\Rest\Attack_pattern;

class Attack_patternEntity
{
	public $id;
	public $name;
	public $attack_type;

	public function getArrayCopy()
    {
        return array(
            AttackPatternJsonKey::Id 				=> $this->id,
            AttackPatternJsonKey::Name 				=> $this->name,
            AttackPatternJsonKey::AttackType 		=> $this->attack_type,
            AttackPatternJsonKey::CreatedAt       	=> $this->created_at,
            AttackPatternJsonKey::UpdatedAt       	=> $this->updated_at,
        );
    }
 
    public function exchangeArray(array $array)
    {
    	$this->id = $array[AttackPatternJsonKey::Id];
    	$this->name = $array[AttackPatternJsonKey::Name];
    	$this->attack_type = $array[AttackPatternJsonKey::AttackType];
    	$this->created_at = $array[AttackPatternJsonKey::CreatedAt];
    	$this->updated_at = $array[AttackPatternJsonKey::UpdatedAt];
    }
}
