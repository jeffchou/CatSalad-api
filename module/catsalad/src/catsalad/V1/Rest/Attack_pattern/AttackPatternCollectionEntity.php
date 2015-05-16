<?php
namespace catsalad\V1\Rest\Attack_pattern;

use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\AdapterInterface;

class AttackPatternCollectionEntity
{
	public $id;
	public $name;
    public $attack_type;
	public $created_at;
	public $updated_at;

	public function getArrayCopy()
    {
        return array(
            AttackPatternJsonKey::Id 			=> $this->id,
            AttackPatternJsonKey::Name 			=> $this->name,
            AttackPatternJsonKey::AttackType    => $this->attack_type,
            AttackPatternJsonKey::CreatedAt 	=> $this->created_at,
            AttackPatternJsonKey::UpdatedAt 	=> $this->updated_at
        );
    }
 
    public function exchangeArray(array $array)
    {
    	$this->id = $array[AttackPatternJsonKey::Id];
    	$this->name = $array[AttackPatternJsonKey::Name];
        
        if (!empty($array[AttackPatternJsonKey::AttackType])) {
            $attack_type = array();
            foreach ($array[AttackPatternJsonKey::AttackType] as $key => $value) {
                array_push($attack_type, array(
                    AttackPatternJsonKey::AttackTypeAliasId => $array[AttackPatternJsonKey::AttackTypeAliasId],
                    AttackPatternJsonKey::AttackTypeAliasOrder => $array[AttackPatternJsonKey::AttackTypeAliasOrder],
                    AttackPatternJsonKey::AttackTypeAliasName => $array[AttackPatternJsonKey::AttackTypeAliasName],
                    AttackTypeJsonKey::CreatedAt => $array[AttackTypeJsonKey::CreatedAt],
                    AttackTypeJsonKey::UpdatedAt => $array[AttackTypeJsonKey::UpdatedAt],
                    ));
            }
        }

    	$this->created_at = $array[AttackPatternJsonKey::CreatedAt];
    	$this->updated_at = $array[AttackPatternJsonKey::UpdatedAt];
    }
}