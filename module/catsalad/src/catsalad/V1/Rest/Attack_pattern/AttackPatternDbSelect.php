<?php
namespace catsalad\V1\Rest\Attack_pattern;

use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Paginator\Adapter\DbSelect;

use catsalad\V1\Rest\Attack_pattern\AttackPatternJsonKey;
use catsalad\V1\Rest\Attack_type\AttackTypeJsonKey;
use catsalad\V1\Rest\Attack_type\AttackTypeMapper;

class AttackPatternDbSelect extends DbSelect
{
	protected $context;
 
    public function setContext($context)
    {
        $this->context = $context;
    }

	public function getItems($offset, $itemCountPerPage)
	{
		$select = clone $this->select;
		$select->offset($offset);
		$select->limit($itemCountPerPage);

		$statement = $this->sql->prepareStatementForSqlObject($select);
		$result    = $statement->execute();

		$resultSet = clone $this->resultSetPrototype;
		$resultSet->initialize($result);

		$attackTypeMapper = $this->context->getAttackTypeMapper();

		$mainResultArray = $resultSet->toArray();
		foreach ($mainResultArray as $key => $value) {
			$patternId = $value[AttackPatternJsonKey::Id];
			$attackTypeResult = $attackTypeMapper->fetchByPatternId($patternId);
			$mainResultArray[$key][AttackPatternJsonKey::AttackType] = $attackTypeResult;
		}

		return $mainResultArray;
	}
}