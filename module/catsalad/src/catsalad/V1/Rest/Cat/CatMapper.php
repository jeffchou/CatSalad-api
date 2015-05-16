<?php
namespace catsalad\V1\Rest\Cat;

use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;

use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Paginator\Adapter\DbSelect;

use catsalad\V1\Exception\ResourceNotFoundException;
use catsalad\V1\Exception\AccessTokenExpiredException;

use catsalad\V1\Utility\DateTimeHelper;

use catsalad\V1\Model\Context;
use catsalad\V1\Rest\User\UserJsonKey;
use catsalad\V1\Rest\Weapon\WeaponJsonKey;
use catsalad\V1\Rest\Battle_partner\BattlePartnerJsonKey;
use catsalad\V1\Rest\Cat_activity\CatActivityJsonKey;
use catsalad\V1\Rest\Social_provider\SocialProviderJsonKey;
use catsalad\V1\Rest\Cat\CatCollectionEntity;

use catsalad\V1\Validator\FloatValue;

class CatMapper
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
        $resultSetPrototype->setArrayObjectPrototype(new CatCollectionEntity());

        $paginatorAdapter = new CatCollectionDbSelect($select, $this->adapter, $resultSetPrototype);
        $paginatorAdapter->setContext($this->context);
		$collection = new CatCollection($paginatorAdapter);
        return $collection;
    }

    public function fetch($id)
    {
        $manager = $this->context->getCatManager();
        $result = $manager->findById($id);
        if (!$result) {
            throw new ResourceNotFoundException($id);
            return null;
        }

        $weaponMapper = $this->context->getWeaponMapper();
        $weaponId = $result[CatJsonKey::EquippedWeaponId];
        $result[CatJsonKey::EquippedWeapon] = $weaponMapper->fetch($weaponId);
        unset($result[CatJsonKey::EquippedWeaponId]);

        $entity = new CatEntity();
        $entity->exchangeArray($result);

        return $entity;
    }

    public function fetchByType($id, $type)
    {
        $manager = $this->context->getCatManager();
        $result = $manager->findById($id);
        if (!$result) {
            throw new ResourceNotFoundException($id);
            return null;
        }

        if ($type == "simple") {
            $entity = new SimpleCatEntity();
            $entity->exchangeArray($result);
        }
        else {
            $weaponMapper = $this->context->getWeaponMapper();
            $catId = $result[CatJsonKey::Id];
            $weaponId = $result[CatJsonKey::EquippedWeaponId];
            $result[CatJsonKey::EquippedWeapon] = $weaponMapper->fetch($weaponId);
            unset($result[CatJsonKey::EquippedWeaponId]);
            
            $entity = new CatEntity();
            $entity->exchangeArray($result);
        }

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
            CatJsonKey::Score,
            CatJsonKey::CreatedAt,
            CatJsonKey::UpdatedAt,
        ));

        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new CatCollectionEntity());

        $paginatorAdapter = new CatCollectionDbSelect($select, $this->adapter, $resultSetPrototype);
        $paginatorAdapter->setContext($this->context);
        $collection = new CatCollection($paginatorAdapter);
        return $collection;
    }

    public function fetchByBattleId($id)
    {
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->from('cat');
        $select->where(array('battle_partner.battle_id' => $id), false);
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
            CatJsonKey::Score,
            CatJsonKey::CreatedAt,
            CatJsonKey::UpdatedAt)
        );
        $select->join(
            'battle_partner',
            'battle_partner.cat_id = cat.id',
            array(),
            $select::JOIN_LEFT);

        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new CatCollectionEntity());

        $paginatorAdapter = new CatCollectionDbSelect($select, $this->adapter, $resultSetPrototype);
        $paginatorAdapter->setContext($this->context);
        $collection = new CatCollection($paginatorAdapter);
        return $collection;
    }

    public function fetchByBattleIdWithSortType($id, $sortType)
    {
        $sql = new Sql($this->adapter);
        $select = $sql->select();

        if ($sortType == BattlePartnerJsonKey::Score) {
            $select->from('cat');
            $select->where(array('battle_partner.battle_id' => $id), false);
            $select->columns(array(CatActivityJsonKey::Score => new \Zend\Db\Sql\Expression('SUM(score)')));
            $select->join(
                'battle_partner',
                'battle_partner.cat_id = cat.id',
                array(),
                $select::JOIN_LEFT);
            $select->join(
                'cat_activity',
                'cat_activity.cat_id = cat.id',
                array(),
                $select::JOIN_LEFT);
        }
        else {
            $select->from('cat');
            $select->where(array('battle_partner.battle_id' => $id), false);
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
                CatJsonKey::Score,
                CatJsonKey::CreatedAt,
                CatJsonKey::UpdatedAt)
            );
            $select->join(
                'battle_partner',
                'battle_partner.cat_id = cat.id',
                array(),
                $select::JOIN_LEFT);
        }

        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new CatCollectionEntity());

        $paginatorAdapter = new CatCollectionDbSelect($select, $this->adapter, $resultSetPrototype);
        $paginatorAdapter->setContext($this->context);
        $collection = new CatCollection($paginatorAdapter);
        return $collection;
    }

    public function fetchExistedPartner($battleId, $catId)
    {
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->from('battle_partner');
        $select->where(array(
            BattlePartnerJsonKey::CatId => $catId,
            BattlePartnerJsonKey::BattleId => $battleId
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

    public function fetchByUserAccessToken($token)
    {
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->from('cat');
        $select->where(array('user.access_token' => $token), false);
        $select->join(
            'user',
            'user.id = cat.user_id',
            $select::SQL_STAR,
            $select::JOIN_LEFT);
        
        $sqlString = $sql->getSqlStringForSqlObject($select);
        $resultSet = $this->adapter->query($sqlString, 
            \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        if ($resultSet->count() <= 0) {
            return null;
        }
        $resultArray = $resultSet->toArray();
        return $resultArray[0];
    }

    public function findDefinitionByLevel($level)
    {
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->from('level_table');
        $select->where(array('level' => $level));
        
        $sqlString = $sql->getSqlStringForSqlObject($select);
        $resultSet = $this->adapter->query($sqlString, 
            \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        if ($resultSet->count() <= 0) {
            return null;
        }
        $resultArray = $resultSet->toArray();
        return $resultArray[0];
    }

    public function examLevel($cat, $exp)
    {
        $level = $cat->level;
        $levelDefinition = $this->findDefinitionByLevel($level);

        if ($data[CatJsonKey::Exp] > $levelDefinition['next_exp']) {
            $cat->level = $levelDefinition['level'] + 1;
        }

        return $cat;
    }

    public function addExp($id, $exp)
    {
        $cat = $this->fetch($id);
        $cat = $this->examLevel($cat, $exp);

        $data = array(
            CatJsonKey::Exp => ($exp + $cat->exp)
        );
        
        $catManager = $this->context->getCatManager();
        $catManager->update($id, $data);
        return $this->fetch($id);
    }

    public function addScore($id, $score)
    {
        $cat = $this->fetch($id);

        $data = array(
            CatJsonKey::Score => ($score + $cat->score)
        );
        $catManager = $this->context->getCatManager();
        $catManager->update($id, $data);
        return $this->fetch($id);
    }

    public function insert($data)
    {
        $location = $data[CatJsonKey::Location];
        $data[CatJsonKey::Latitude] = $location[CatJsonKey::Latitude];
        $data[CatJsonKey::Longitude] = $location[CatJsonKey::Longitude];
        unset($data[CatJsonKey::Location]);
        
        $floatValidator = new FloatValue();
        if (!$floatValidator->isValid($data[CatJsonKey::Latitude])) {
            return new ApiProblemResponse(
                new ApiProblem(422, 'Failed Validation', null, null, array(
                    'validation_messages' => $floatValidator->getMessages(),
                ))
            );
        }
        if (!$floatValidator->isValid($data[CatJsonKey::Longitude])) {
            return new ApiProblemResponse(
                new ApiProblem(422, 'Failed Validation', null, null, array(
                    'validation_messages' => $floatValidator->getMessages(),
                ))
            );
        }

        $manager = $this->context->getCatManager();
        return $manager->insert($data);
    }

    public function update($id, $data)
    {
        $manager = $this->context->getCatManager();
        $result = $manager->update($id, $data);
        if (!$result) {
            throw new ResourceNotFoundException($id);
            return null;
        }
        return $this->fetch($id);
    }

    public function delete($id)
    {
        $manager = $this->context->getCatManager();
        return $manager->delete($id);
    }
}