<?php
namespace catsalad\V1\Rest\Battle_participant;

use Zend\Paginator\Adapter\DbSelect;

use catsalad\V1\Rest\Weapon\WeaponMapper;
use catsalad\V1\Rest\Cat\CatJsonKey;

class BattleParticipantCollectionDbSelect extends DbSelect
{
	protected $context;
 
    public function setContext($context)
    {
        $this->context = $context;
    }

	public function getItems($offset, $itemCountPerPage)
	{
		$mainSelect = clone $this->select;
        $mainSelect->offset($offset);
        $mainSelect->limit($itemCountPerPage);

        $statement = $this->sql->prepareStatementForSqlObject($mainSelect);
        $result    = $statement->execute();

        $resultSet = clone $this->resultSetPrototype;
        $resultSet->initialize($result);

        $weaponMapper = $this->context->getWeaponMapper();

		$mainResultArray = $resultSet->toArray();
		foreach ($mainResultArray as $key => $cat) {
			$catId = $cat[CatJsonKey::Id];
			$weaponId = $cat[CatJsonKey::EquippedWeaponId];
	    	
	        $mainResultArray[$key][CatJsonKey::EquippedWeapon] = $weaponMapper->fetch($weaponId);
	        unset($mainResultArray[$key][CatJsonKey::EquippedWeaponId]);
		}

        return $mainResultArray;
	}
}