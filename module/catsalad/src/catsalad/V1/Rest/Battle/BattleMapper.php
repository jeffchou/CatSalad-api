<?php
namespace catsalad\V1\Rest\Battle;

use ZF\ApiProblem\ApiProblem;

use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Paginator\Adapter\DbSelect;

use ZF\Hal\Collection;

use catsalad\V1\Exception\ResourceNotFoundException;
use catsalad\V1\Exception\AccessTokenExpiredException;

use catsalad\V1\Utility\DateTimeHelper;

use catsalad\V1\Model\Context;

class BattleMapper
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
    	return $this->fetchByFilter(null);
    }

    public function fetch($id)
    {
        $manager = $this->context->getBattleManager();
        $result = $manager->findById($id);
        if (!$result) {
            throw new ResourceNotFoundException($id);
            return null;
        }

        $entity = new BattleEntity();
        $entity->exchangeArray($result);

        return $entity;
    }

    public function fetchByFilter($filterType, $contentType)
    {
        $currentDate = DateTimeHelper::nowDateTimeUTC("Y-m-d");
        $nextDate = date('Y-m-d', strtotime($currentDate. '+ 1 days'));

        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->from('battle');
        $select->order('activated_at DESC');

        if ($filterType == BattleJsonKey::Active) {
            $select->where(array(BattleJsonKey::ActivatedAt => $currentDate));
        }
        else if ($filterType == BattleJsonKey::Upcoming) {
            $select->where->equalTo(BattleJsonKey::ActivatedAt, $nextDate);
        }
        else if ($filterType == BattleJsonKey::Finished) {
            $select->where->lessThan(BattleJsonKey::ActivatedAt, $currentDate);
        }
        else if ($filterType == BattleJsonKey::Rank) {
            $select = $sql->select();
            $select->from('battle');
            $select->where->lessThan(BattleJsonKey::ActivatedAt, $currentDate)
                ->or->equalTo(BattleJsonKey::ActivatedAt, $currentDate);
            $select->order('activated_at DESC');
        }
        else {
            $selectCombine = $sql->select();
            $selectCombine->from('battle');
            $selectCombine->where->equalTo(BattleJsonKey::ActivatedAt, $nextDate);
            $selectActive = $sql->select();
            $selectActive->from('battle');
            $selectActive->where->equalTo(BattleJsonKey::ActivatedAt, $currentDate);
            $selectCombine->combine($selectActive);

            $selectFinished = $sql->select();
            $selectFinished->from('battle');
            $selectFinished->order('activated_at DESC');
            $selectFinished->where->lessThan(BattleJsonKey::ActivatedAt, $currentDate);
            $select2 = $sql->select();
            $select2->from(array('combine2' => $selectFinished));

            $select = $sql->select();
            $select->from(array('combine' => $selectCombine));
            $select->combine($select2);

            // $selectActive = $sql->select();
            // $selectActive->from('battle');
            // $selectActive->where->equalTo(BattleJsonKey::ActivatedAt, $currentDate);
            // $selectCombine = $sql->select();
            // $selectCombine->from('battle');
            // $selectCombine->where->equalTo(BattleJsonKey::ActivatedAt, $nextDate);
            // $selectActive->combine($selectCombine);
            // $select = $sql->select();
            // $select->from(array('combine' => $selectActive));
        }
        
        if ($contentType == BattleJsonKey::Simple) {
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new SimpleBattleEntity());
            $paginatorAdapter = new DbSelect($select, $this->adapter, $resultSetPrototype);
            $collection = new BattleCollection($paginatorAdapter);
            return $collection;
        }
        
        $paginatorAdapter = new DbSelect($select, $this->adapter);
        $collection = new BattleCollection($paginatorAdapter);
        return $collection;
    }

    public function insert($data)
    {
        $manager = $this->context->getBattleManager();
        return $manager->insert($data);
    }

    public function update($id, $data)
    {
        $manager = $this->context->getBattleManager();
        $result = $manager->update($id, $data);
        if (!$result) {
            throw new ResourceNotFoundException($id);
            return null;
        }
        return $this->fetch($id);
    }

    public function delete($id)
    {
        $manager = $this->context->getBattleManager();
        return $manager->delete($id);
    }
}