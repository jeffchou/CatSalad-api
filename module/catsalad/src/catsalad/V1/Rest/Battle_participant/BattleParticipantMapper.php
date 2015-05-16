<?php
namespace catsalad\V1\Rest\Battle_participant;

use ZF\ApiProblem\ApiProblem;

use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Paginator\Adapter\DbSelect;

use catsalad\V1\Utility\UuidHelper;

use catsalad\V1\Exception\ResourceNotFoundException;
use catsalad\V1\Exception\AccessTokenExpiredException;

use catsalad\V1\Utility\DateTimeHelper;

use catsalad\V1\Model\Context;
use catsalad\V1\Rest\Cat\CatJsonKey;
use catsalad\V1\Rest\Battle_participant\BattleParticipantJsonKey;
use catsalad\V1\Rest\Cat_activity\CatActivityJsonKey;
use catsalad\V1\Rest\Social_provider\SocialProviderJsonKey;

class BattleParticipantMapper
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
    	$select->from('cat');

        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Battle_participantCollectionEntity());

        $paginatorAdapter = new BattleParticipantCollectionDbSelect($select, $this->adapter, $resultSetPrototype);
        $paginatorAdapter->setContext($this->context);
		$collection = new Battle_participantCollection($paginatorAdapter);
        return $collection;
    }

    public function fetchByCatId($catId)
    {
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->from('cat');
        $select->where(array(CatJsonKey::Id => $catId));

        $sqlString = $sql->getSqlStringForSqlObject($select);
        $resultSet = $this->adapter->query($sqlString, 
            \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        if ($resultSet->count() <= 0) {
            return null;
        }
        $resultArray = $resultSet->toArray();

        $entity = new Battle_participantEntity();
        $entity->exchangeArray($resultArray[0]);

        return $entity;
    }

    public function fetchWithBattleId($battleId, $id)
    {
        $sql = new Sql($this->adapter);
        $sqlString = sprintf("SELECT b.* FROM ( SELECT @rownum := @rownum+1 AS 'rank', a.* FROM ( SELECT `cat`.`id`,`cat`.`name`,`cat`.`equipped_weapon_id`,`cat`.`gender`,`cat`.`birthday`,`cat`.`lvl`,`cat`.`exp`,`cat`.`score`,`cat`.`image_url`,`cat`.`latitude`,`cat`.`longitude`,`cat`.`created_at`,`cat`.`updated_at` FROM cat LEFT JOIN `battle_participant` ON `cat`.`id` = `battle_participant`.`cat_id` AND `battle_participant`.`battle_id` = '%s' ORDER BY `cat`.`score` DESC ) a, (SELECT @rownum := 0) r ) b WHERE `id` = '%s'",
            $battleId, $id);

        $resultSet = $sql->getAdapter()->query($sqlString, 
                \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        $resultArray = $resultSet->toArray();
        $cat = $resultArray[0];

        $entity = new Battle_participantEntity();
        $entity->exchangeArray($cat);

        return $entity;
    }

    public function fetchByUserId($id)
    {
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->from('cat');
        $select->where(array(CatJsonKey::UserId => $id));
        $select->columns(array(
            CatJsonKey::Id,
            CatJsonKey::Name,
            CatJsonKey::Gender,
            CatJsonKey::Birthday,
            CatJsonKey::EquippedWeaponId,
            CatJsonKey::Latitude,
            CatJsonKey::Longitude,
            CatJsonKey::ImageUrl,
            CatJsonKey::LVL,
            CatJsonKey::Exp,
            CatJsonKey::CreatedAt,
            CatJsonKey::UpdatedAt,
            ));

        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Battle_participantCollectionEntity());

        $paginatorAdapter = new BattleParticipantCollectionDbSelect($select, $this->adapter, $resultSetPrototype);
        $paginatorAdapter->setContext($this->context);
        $collection = new Battle_participantCollection($paginatorAdapter);
        return $collection;
    }

    public function fetchByBattleId($id)
    {
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->from('cat');
        $select->where(array(
            'battle_participant.battle_id' => $id,
        ), false);
        $select->columns(
            array(
                CatJsonKey::Id,
                CatJsonKey::Name,
                CatJsonKey::Gender,
                CatJsonKey::Birthday,
                CatJsonKey::Latitude,
                CatJsonKey::Longitude,
                CatJsonKey::ImageUrl,
                CatJsonKey::LVL,
                CatJsonKey::Exp,
                CatJsonKey::CreatedAt,
                CatJsonKey::UpdatedAt));
        $select->join(
            'battle_participant',
            'battle_participant.cat_id = cat.id',
            array(),
            $select::JOIN_LEFT);

        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Battle_participantCollectionEntity());

        $paginatorAdapter = new BattleParticipantCollectionDbSelect($select, $this->adapter, $resultSetPrototype);
        $paginatorAdapter->setContext($this->context);
        $collection = new Battle_participantCollection($paginatorAdapter);
        return $collection;
    }

    public function fetchByBattleIdWithScoreSort($battleId)
    {
        $sql = new Sql($this->adapter);

        $select = $sql->select();
        $select->from('cat');
        $select->columns(array(
            $select::SQL_STAR,
            'r' => new \Zend\Db\Sql\Expression('@rownum := 0')
        ));
        $select->where(array('battle_participant.battle_id' => $battleId), false);
        $select->join(
            'battle_participant',
            'battle_participant.cat_id = cat.id',
            array(),
            $select::JOIN_LEFT);
        $select->order('score DESC');

        $mainselect =  clone $sql->select();
        $mainselect->from(array('a' => $select));
        $mainselect->columns(array(
            $mainselect::SQL_STAR,
            'rank' => new \Zend\Db\Sql\Expression('@rownum := @rownum + 1'),
        ));

        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Battle_participantEntity());

        $paginatorAdapter = new DbSelect($mainselect, $this->adapter, $resultSetPrototype);
        $collection = new Battle_participantCollection($paginatorAdapter);
        return $collection;
    }

    public function fetchByBattleIdWithLocationSort($battleId, $cat)
    {
        $sql = new Sql($this->adapter);
        $select = $sql->select();

        $myCatLatitude = $cat[CatJsonKey::Latitude];
        $myCatLongitude = $cat[CatJsonKey::Longitude];
        $expression = sprintf("SQRT((cat.latitude - %f)*(cat.latitude - %f) + (cat.longitude - %f)*(cat.longitude - %f))", $myCatLatitude, $myCatLongitude, $myCatLatitude, $myCatLongitude);

        $select->from('cat');
        $select->where(array('battle_participant.battle_id' => $battleId), false);
        $select->columns(array(
            $select::SQL_STAR,
            CatActivityJsonKey::Distance => new \Zend\Db\Sql\Expression($expression)));
        $select->join(
            'battle_participant',
            'battle_participant.cat_id = cat.id',
            array(),
            $select::JOIN_LEFT);
        $select->order('Distance ASC');

        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Battle_participantCollectionEntity());

        $paginatorAdapter = new DbSelect($select, $this->adapter, $resultSetPrototype);
        $collection = new Battle_participantCollection($paginatorAdapter);
        return $collection;
    }

    public function fetchExistedParticipant($battleId, $catId)
    {
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->from('battle_participant');
        $select->where(array(
            BattleParticipantJsonKey::CatId => $catId,
            BattleParticipantJsonKey::BattleId => $battleId
            ));
        
        $sqlString = $sql->getSqlStringForSqlObject($select);
        $resultSet = $this->adapter->query($sqlString, 
            \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        if ($resultSet->count() <= 0) {
            return null;
        }
        $resultArray = $resultSet->toArray();
        return $resultArray[0];
    }

    public function joinBattle($battleId, $data)
    {
        $data[BattleParticipantJsonKey::Id] = UuidHelper::uuid();
        $data[BattleParticipantJsonKey::BattleId] = $battleId;
        $catId = $data[BattleParticipantJsonKey::CatId];

        $partner = $this->fetchExistedParticipant($battleId, $catId);
        if ($partner == null) {
            $sql = new Sql($this->adapter);
            $insert = $sql->insert('battle_participant');
            $insert->values($data);

            $sqlString = $sql->getSqlStringForSqlObject($insert);
            $result = $this->adapter->query($sqlString, 
                \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
            if (!$result) {
                return null;
            }
        }
        return $this->fetchByCatId($catId);
    }

    public function insert($data)
    {
        
    }

    public function update($id, $data)
    {
        
    }

    public function delete($id)
    {
        
    }
}