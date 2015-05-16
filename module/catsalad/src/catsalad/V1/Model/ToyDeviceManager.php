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
use catsalad\V1\Rest\Toy_device\ToyDeviceJsonKey;

use catsalad\V1\Utility\DateTimeHelper;

class ToyDeviceManager
{
    protected $table_name = 'toy_device';
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
    	$select->where(array(ToyDeviceJsonKey::Id => $id));

		$sqlString = $sql->getSqlStringForSqlObject($select);
        $resultSet = $this->adapter->query($sqlString, 
            \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
       	if ($resultSet->count() <= 0) {
       		return null;
       	}
		$resultArray = $resultSet->toArray();
        return $resultArray[0];
    }

    public function findByDeviceId($device_id)
    {
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->from($this->table_name);
        $select->where(array(ToyDeviceJsonKey::DeviceId => $device_id));

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
        $select->where(array(ToyDeviceJsonKey::UserId => $userId));
        $select->columns(array(
            ToyDeviceJsonKey::Id,
            ToyDeviceJsonKey::IsEnableSound,
            ToyDeviceJsonKey::IsUseSystemRecommendedTime,
            ToyDeviceJsonKey::SystemRecommendedTime,
            ToyDeviceJsonKey::UserScheduledTime,
            ToyDeviceJsonKey::Latitude,
            ToyDeviceJsonKey::Longitude,
            ToyDeviceJsonKey::CreatedAt,
            ToyDeviceJsonKey::UpdatedAt,
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
        $data[UserJsonKey::ToyDeviceId] = UuidHelper::uuid();

        $user = array();
        $user[UserJsonKey::Id] = null;
        return $this->insertByUser($user, $data);
    }

    public function insertByUser($user, $data)
    {
        $toyDeviceId = $data[UserJsonKey::ToyDeviceId];

        $sql = new Sql($this->adapter);
        $insert = $sql->insert($this->table_name);
        $insert->values(array(
            ToyDeviceJsonKey::Id => $toyDeviceId,
            ToyDeviceJsonKey::UserId => $user[UserJsonKey::Id],
            ToyDeviceJsonKey::SystemRecommendedTime => DateTimeHelper::nowWithTimeUTC("Y-m-d H:i:s", 20, 0, 0),
            ToyDeviceJsonKey::UserScheduledTime => DateTimeHelper::nowWithTimeUTC("Y-m-d H:i:s", 20, 0, 0),
            ToyDeviceJsonKey::Latitude => empty($data[ToyDeviceJsonKey::Latitude]) ? null : $data[ToyDeviceJsonKey::Latitude],
            ToyDeviceJsonKey::Longitude => empty($data[ToyDeviceJsonKey::Longitude]) ? null : $data[ToyDeviceJsonKey::Longitude],
            ToyDeviceJsonKey::CreatedAt => DateTimeHelper::nowDateTimeUTC("Y-m-d H:i:s"),
            ));

        $sqlString = $sql->getSqlStringForSqlObject($insert);
        $result = $this->adapter->query($sqlString, 
            \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        if (!$result) {
            return null;
        }
        return $this->findById($toyDeviceId);
    }

    public function update($id, $data)
    {
        if (isset($data[ToyDeviceJsonKey::IsEnableSound])) {
            $data[ToyDeviceJsonKey::IsEnableSound] = (int) $data[ToyDeviceJsonKey::IsEnableSound];
        }
        if (isset($data[ToyDeviceJsonKey::IsUseSystemRecommendedTime])) {
            $data[ToyDeviceJsonKey::IsUseSystemRecommendedTime] = (int) $data[ToyDeviceJsonKey::IsUseSystemRecommendedTime];
        }
        
        $sql = new Sql($this->adapter);
        $update = $sql->update($this->table_name);
        $update->where(array(ToyDeviceJsonKey::Id => $id));
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
        $delete->where(array(ToyDeviceJsonKey::Id => $id));

        $sqlString = $sql->getSqlStringForSqlObject($delete);
        $resultSet = $this->adapter->query($sqlString, 
            \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        if ($resultSet->count() > 0) {
            return true;
        }
        return false;
    }

    private function valueOfBool($val)
    {
        return $val ? intval(1) : intval(0);
    }
}
