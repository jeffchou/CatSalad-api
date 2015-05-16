<?php
namespace catsalad\V1\Model;

use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Paginator\Adapter\DbSelect;

use catsalad\V1\Utility\UuidHelper;

use catsalad\V1\Exception\ResourceNotFoundException;
use catsalad\V1\Exception\AccessTokenExpiredException;

use catsalad\V1\Rest\User\UserJsonKey;
use catsalad\V1\Rest\Cat\CatJsonKey;

use catsalad\V1\Utility\DateTimeHelper;

class CatManager
{
    protected $table_name = 'cat';
	protected $adapter;

    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    public function findAll()
    {
    	$sql = new Sql($this->adapter);
    	$select = $sql->select();
    	$select->from($this->table_name);

   		$sqlString = $sql->getSqlStringForSqlObject($select);
        $resultSet = $this->adapter->query($sqlString, 
            \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        return $resultSet;
    }

    public function findById($id)
    {
    	$sql = new Sql($this->adapter);
    	$select = $sql->select();
    	$select->from($this->table_name);
    	$select->where(array(CatJsonKey::Id => $id));

		$sqlString = $sql->getSqlStringForSqlObject($select);
        $resultSet = $this->adapter->query($sqlString, 
            \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
       	if ($resultSet->count() <= 0) {
       		return null;
       	}
		$resultArray = $resultSet->toArray();
        return $resultArray[0];
    }

    public function findByUserId($userId)
    {
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->from($this->table_name);
        $select->where(array(CatJsonKey::UserId => $userId));
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

        $sqlString = $sql->getSqlStringForSqlObject($select);
        $resultSet = $sql->getAdapter()->query($sqlString, 
                \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        if ($resultSet->count() <= 0) {
            return null;
        }
        return $resultSet->toArray();
    }

    public function insert($data)
    {
        $user = array();
        $user[CatJsonKey::Id] = null;
        return $this->insertByUser($user, $data);
    }

    public function insertByUser($user, $data)
    {
        $data[CatJsonKey::Id] = UuidHelper::uuid();
        $insertData = array(
            CatJsonKey::Id => $data[CatJsonKey::Id],
            CatJsonKey::UserId => $user[UserJsonKey::Id],
            CatJsonKey::Name => $data[UserJsonKey::CatName],
            CatJsonKey::Gender => empty($data[CatJsonKey::Gender]) ? 'boy' : $data[CatJsonKey::Gender],
            CatJsonKey::Birthday => DateTimeHelper::nowDateTimeUTC("Y-m-d H:i:s"),
            CatJsonKey::ImageUrl => empty($data[CatJsonKey::ImageUrl]) ? null : $data[CatJsonKey::ImageUrl],
            CatJsonKey::LVL => empty($data[CatJsonKey::LVL]) ? 1 : $data[CatJsonKey::LVL],
            CatJsonKey::Exp => empty($data[CatJsonKey::Exp]) ? 0 : $data[CatJsonKey::Exp],
            CatJsonKey::CreatedAt => DateTimeHelper::nowDateTimeUTC("Y-m-d H:i:s"),
            CatJsonKey::Latitude => empty($data[CatJsonKey::Latitude]) ? null : $data[CatJsonKey::Latitude],
            CatJsonKey::Longitude => empty($data[CatJsonKey::Longitude]) ? null : $data[CatJsonKey::Longitude],
            );
        if (!empty($data[CatJsonKey::EquippedWeaponId])) {
            $insertData[CatJsonKey::EquippedWeaponId] = $data[CatJsonKey::EquippedWeaponId];
        }

        $sql = new Sql($this->adapter);
        $insert = $sql->insert($this->table_name);
        $insert->values($insertData);

        $sqlString = $sql->getSqlStringForSqlObject($insert);
        $result = $this->adapter->query($sqlString, 
            \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        if (!$result) {
            return null;
        }
        return $this->findById($data[CatJsonKey::Id]);
    }

    public function update($id, $data)
    {
        $sql = new Sql($this->adapter);
        $update = $sql->update($this->table_name);
        $update->where(array(UserJsonKey::Id => $id));
        $update->set($data);

        $sqlString = $sql->getSqlStringForSqlObject($update);
        $result = $this->adapter->query($sqlString, 
            \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        if (!$result) {
            return null;
        }
        return $this->findById($id);
    }

    public function delete($id)
    {
        $sql = new Sql($this->adapter);
        $delete = $sql->delete();
        $delete->from($this->table_name);
        $delete->where(array(UserJsonKey::Id => $id));

        $sqlString = $sql->getSqlStringForSqlObject($delete);
        $resultSet = $this->adapter->query($sqlString, 
            \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        if ($resultSet->count() > 0) {
            return true;
        }
        return false;
    }
}
