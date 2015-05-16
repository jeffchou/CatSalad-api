<?php
namespace catsalad\V1\Rest\Boss;

use ZF\ApiProblem\ApiProblem;

use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Paginator\Adapter\DbSelect;

use catsalad\V1\Exception\ResourceNotFoundException;
use catsalad\V1\Exception\AccessTokenExpiredException;

use catsalad\V1\Utility\DateTimeHelper;

use catsalad\V1\Model\Context;

class BossMapper
{
	protected $context;
	protected $adapter;

    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    public function setContext($context)
    {
    	$this->context = $context;
    }

    public function getContext()
    {
    	return $this->context;
    }

 	public function getAdapter()
 	{
 		return $this->adapter;
 	}

    public function fetchAll()
    {
    	$sql = new Sql($this->adapter);
    	$select = $sql->select();
    	$select->from('boss');

        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new BossCollectionEntity());

        $paginatorAdapter = new BossCollectionDbSelect($select, $this->adapter, $resultSetPrototype);
        $paginatorAdapter->setContext($this->context);
		$collection = new BossCollection($paginatorAdapter);
        return $collection;
    }

    public function fetch($id)
    {
        $manager = $this->context->getBossManager();
        $result = $manager->findById($id);
        if (!$result) {
            throw new ResourceNotFoundException($id);
            return null;
        }

        $attackPatternMapper = $this->context->getAttackPatternMapper();
        $result[BossJsonKey::AttackPattern] = $attackPatternMapper->fetch($result[BossJsonKey::AttackPatternId]);

        $entity = new BossEntity();
        $entity->exchangeArray($result);

        return $entity;
    }

    // public function fetchActiveBoss()
    // {
    //     $sql = new Sql($this->adapter);
    //     $select = $sql->select();
    //     $select->from('active_boss');

    //     $sqlString = $sql->getSqlStringForSqlObject($select);
    //     $resultSet = $this->adapter->query($sqlString, 
    //         \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
    //     if ($resultSet->count() <= 0) {
    //         return new BossEntity();
    //     }
    //     $resultArray = $resultSet->toArray();
    //     $result = $resultArray[0];
        
    //     return $this->fetch($result[BossJsonKey::BossId]);
    // }

    public function fetchBossCandidate()
    {
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->from('boss');
        $select->join(
            'boss_candidate',
            'boss_candidate.boss_id = boss.id',
            array(),
            $select::JOIN_INNER
            );
        $select->order('order ASC');

        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new BossCollectionEntity());

        $paginatorAdapter = new BossCollectionDbSelect($select, $this->adapter, $resultSetPrototype);
        $paginatorAdapter->setContext($this->context);
        $collection = new BossCollection($paginatorAdapter);

        return $collection;
    }

    public function fetchByBattleId($id)
    {
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->from('boss');
        $select->where(array('battle_boss.battle_id' => $id), false);
        $select->join(
            'battle_boss',
            'battle_boss.boss_id = boss.id',
            array(),
            $select::JOIN_LEFT);

        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new BossCollectionEntity());

        $paginatorAdapter = new BossCollectionDbSelect($select, $this->adapter, $resultSetPrototype);
        $paginatorAdapter->setContext($this->context);
        $collection = new BossCollection($paginatorAdapter);
        
        return $collection;
    }

    public function fetchByBattleIdAndType($id, $content_type)
    {
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->from('boss');
        $select->where(array('battle_boss.battle_id' => $id), false);
        $select->join(
            'battle_boss',
            'battle_boss.boss_id = boss.id',
            array(),
            $select::JOIN_LEFT);

        $sqlString = $sql->getSqlStringForSqlObject($select);
        $resultSet = $this->adapter->query($sqlString, 
                \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        return $resultSet;
    }

    public function insert($data)
    {
        $manager = $this->context->getBossManager();
        return $manager->insert($data);
    }

    public function update($id, $data)
    {
        $manager = $this->context->getBossManager();
        $result = $manager->update($id, $data);
        if (!$result) {
            throw new ResourceNotFoundException($id);
            return null;
        }
        return $this->fetch($id);
    }

    public function delete($id)
    {
        $manager = $this->context->getBossManager();
        return $manager->delete($id);
    }
}