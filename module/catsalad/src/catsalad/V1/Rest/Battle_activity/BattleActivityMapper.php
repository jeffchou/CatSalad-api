<?php
namespace catsalad\V1\Rest\Battle_activity;

use ZF\ApiProblem\ApiProblem;

use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Paginator\Adapter\DbSelect;

use catsalad\V1\Exception\ResourceNotFoundException;
use catsalad\V1\Exception\AccessTokenExpiredException;

use catsalad\V1\Rest\Cat\CatJsonKey;
use catsalad\V1\Rest\Cat_activity\CatActivityJsonKey;

use catsalad\V1\Rest\Cat_activity\ExpCalculator;
use catsalad\V1\Rest\Cat_activity\ScoreCalculator;

class BattleActivityMapper
{
    protected $context;
    protected $adapter;
    protected $exp_calulator;
    protected $score_calulator;

    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    public function setContext($context)
    {
        $this->context = $context;
        $this->exp_calulator = new ExpCalculator($this->context);
        $this->score_calulator = new ScoreCalculator($this->context);
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
        $select->from('cat_activity');

        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Battle_activityEntity());

        $paginatorAdapter = new DbSelect($select, $this->adapter, $resultSetPrototype);
        $collection = new Battle_activityCollection($paginatorAdapter);
        return $collection;
    }

    public function fetchByCatId($id)
    {
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->from('cat_activity');
        $select->where(array(CatActivityJsonKey::CatId => $id));

        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Battle_activityEntity());

        $paginatorAdapter = new DbSelect($select, $this->adapter, $resultSetPrototype);
        $collection = new Battle_activityCollection($paginatorAdapter);
        return $collection;
    }

    public function fetchWithFilterType($battleId, $catId, $filterType, $params)
    {
        $sql = new Sql($this->adapter);
        $select = $sql->select();

        $param_strings = explode(',', $params);

        if ($filterType == CatActivityJsonKey::ByMonth) {
            $param = $param_strings[1];

            $select->from('cat_activity');
            $select->where(array(
                CatActivityJsonKey::CatId => $catId,
                CatActivityJsonKey::BattleId => $battleId,
                new \Zend\Db\Sql\Predicate\Expression('YEAR(time) = ?', date('Y', strtotime($param))),
                new \Zend\Db\Sql\Predicate\Expression('MONTH(time) = ?', date('m', strtotime($param))),
                )
            );
            $select->columns(array(
                CatActivityJsonKey::Id,
                CatActivityJsonKey::BattleId,
                CatActivityJsonKey::CatId,
                CatActivityJsonKey::HitType,
                CatActivityJsonKey::Exp => new \Zend\Db\Sql\Expression('SUM(exp)'),
                CatActivityJsonKey::Score => new \Zend\Db\Sql\Expression('SUM(score)'),
                CatActivityJsonKey::Time,
                CatActivityJsonKey::CreatedAt
            ));
            $select->group(array(
                CatActivityJsonKey::HitType,
                new \Zend\Db\Sql\Expression('YEAR('.CatActivityJsonKey::Time.')'), 
                new \Zend\Db\Sql\Expression('MONTH('.CatActivityJsonKey::Time.')'),
                new \Zend\Db\Sql\Expression('DAY('.CatActivityJsonKey::Time.')'),
            ));
            $select->order(CatActivityJsonKey::Time.' ASC');
        }
        else if ($filterType == CatActivityJsonKey::ByDay) {
            $param = $param_strings[1];

            $select->from('cat_activity');
            $select->where(array(
                CatActivityJsonKey::CatId => $catId,
                CatActivityJsonKey::BattleId => $battleId,
                new \Zend\Db\Sql\Predicate\Expression('DATE(time) = ?', date('Y-m-d', strtotime($param))))
            );
            $select->columns(array(
                CatActivityJsonKey::Id,
                CatActivityJsonKey::BattleId,
                CatActivityJsonKey::CatId,
                CatActivityJsonKey::HitType,
                CatActivityJsonKey::Exp => new \Zend\Db\Sql\Expression('SUM(exp)'),
                CatActivityJsonKey::Score => new \Zend\Db\Sql\Expression('SUM(score)'),
                CatActivityJsonKey::Time,
                CatActivityJsonKey::CreatedAt
            ));
            $select->group(array(
                CatActivityJsonKey::HitType,
                new \Zend\Db\Sql\Expression('YEAR('.CatActivityJsonKey::Time.')'), 
                new \Zend\Db\Sql\Expression('MONTH('.CatActivityJsonKey::Time.')'),
                new \Zend\Db\Sql\Expression('DAY('.CatActivityJsonKey::Time.')'),
                new \Zend\Db\Sql\Expression('HOUR('.CatActivityJsonKey::Time.')'),
            ));
            $select->order(CatActivityJsonKey::Time.' ASC');
        }
        else if ($filterType == CatActivityJsonKey::ByTime) {
            $start_time = $param_strings[1];
            $end_time = $param_strings[2];

            $select->from('cat_activity');
            $select->where(array(
                CatActivityJsonKey::CatId => $catId,
                CatActivityJsonKey::BattleId => $battleId,
                new \Zend\Db\Sql\Predicate\Between(CatActivityJsonKey::Time, $start_time, $end_time)
                )
            );
            $select->columns(array(
                CatActivityJsonKey::Id,
                CatActivityJsonKey::BattleId,
                CatActivityJsonKey::CatId,
                CatActivityJsonKey::HitType,
                CatActivityJsonKey::Exp,
                CatActivityJsonKey::Score,
                CatActivityJsonKey::Time,
                CatActivityJsonKey::CreatedAt
            ));
            $select->order(CatActivityJsonKey::Time.' ASC');
        }
        else {
            // Not filter
            $select->from('cat_activity');
            $select->where(array(
                CatActivityJsonKey::CatId => $catId,
                CatActivityJsonKey::BattleId => $battleId,
            ));
            $select->columns(array(
                CatActivityJsonKey::Id,
                CatActivityJsonKey::BattleId,
                CatActivityJsonKey::CatId,
                CatActivityJsonKey::HitType,
                CatActivityJsonKey::Exp,
                CatActivityJsonKey::Score,
                CatActivityJsonKey::Time,
                CatActivityJsonKey::CreatedAt
            ));
            $select->order(CatActivityJsonKey::Time.' ASC');
        }

        $sqlString = $sql->getSqlStringForSqlObject($select);
        $resultSet = $this->adapter->query($sqlString, 
            \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);

        return $resultSet;

        // $resultSetPrototype = new ResultSet();
        // $resultSetPrototype->setArrayObjectPrototype(new Cat_activityEntity());

        // $paginatorAdapter = new DbSelect($select, $this->adapter, $resultSetPrototype);
        // $collection = new Cat_activityCollection($paginatorAdapter);
        // return $collection;
    }

    public function fetch($id)
    {
        $manager = $this->context->getCatActivityManager();
        $result = $manager->findById($id);
        if (!$result) {
            throw new ResourceNotFoundException($id);
            return null;
        }
        
        $entity = new Battle_activityEntity();
        $entity->exchangeArray($result);

        return $entity;
    }

    public function insert($data)
    {
        $manager = $this->context->getCatActivityManager();
        $data[CatActivityJsonKey::Exp] = $this->exp_calulator->exp($data);
        $data[CatActivityJsonKey::Score] = $this->score_calulator->score($data);

        $catId = $data[CatActivityJsonKey::CatId];
        $catMapper = $this->context->getCatMapper();
        $catMapper->addExp($catId, $data[CatActivityJsonKey::Exp]);
        $catMapper->addScore($catId, $data[CatActivityJsonKey::Score]);

        $result = $manager->insert($data);

        $entity = new Battle_activityEntity();
        $entity->exchangeArray($result);

        return $entity;
    }

    public function update($id, $data)
    {
        $manager = $this->context->getCatActivityManager();
        $result = $manager->update($id, $data);
        if (!$result) {
            throw new ResourceNotFoundException($id);
            return null;
        }
        return $this->fetch($id);
    }

    public function delete($id)
    {
        $manager = $this->context->getCatActivityManager();
        return $manager->delete($id);
    }
}