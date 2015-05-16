<?php
namespace catsalad\V1\Rest\Active_boss;

use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Paginator\Adapter\DbSelect;

use catsalad\V1\Rest\Active_boss\ActiveBossJsonKey;
use catsalad\V1\Rest\Boss\BossJsonKey;
use catsalad\V1\Rest\Boss\BossEntity;

class ActiveBossDbSelect extends DbSelect
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

		$bossMapper = $this->context->getBossMapper();
		$mainResultArray = $resultSet->toArray();
		foreach ($mainResultArray as $key => $value) {
			$bossId = $value[ActiveBossJsonKey::BossId];
			$boss = $bossMapper->fetch($bossId);
			$mainResultArray[$key][ActiveBossJsonKey::Boss] = $boss;

			unset($mainResultArray[$key][ActiveBossJsonKey::BossId]);
		}
		return $mainResultArray;
	}
}