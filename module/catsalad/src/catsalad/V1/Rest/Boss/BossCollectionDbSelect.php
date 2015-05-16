<?php
namespace catsalad\V1\Rest\Boss;

use Zend\Paginator\Adapter\DbSelect;

use catsalad\V1\Rest\Attack_pattern\AttackPatternMapper;

class BossCollectionDbSelect extends DbSelect
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

        $attackPatternMapper = $this->context->getAttackPatternMapper();

		$mainResultArray = $resultSet->toArray();
		foreach ($mainResultArray as $key => $boss) {
	        $mainResultArray[$key][BossJsonKey::AttackPattern] = $attackPatternMapper->fetch($boss[BossJsonKey::AttackPatternId]);
	        unset($mainResultArray[$key][BossJsonKey::AttackPatternId]);
		}

        return $mainResultArray;
	}
}