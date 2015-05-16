<?php
namespace catsalad\V1\Model;

use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Paginator\Adapter\DbSelect;

use catsalad\V1\Utility\UuidHelper;

use catsalad\V1\Exception\ResourceNotFoundException;
use catsalad\V1\Exception\AccessTokenExpiredException;

use catsalad\V1\Rest\Toy_control\ToyControlJsonKey;

use catsalad\V1\Utility\DateTimeHelper;

class ToyControlManager
{
    protected $table_name = 'toy_control';
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
        $select->order(ToyControlJsonKey::CreatedAt.' ASC');

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
    	$select->where(array(ToyControlJsonKey::Id => $id));

		$sqlString = $sql->getSqlStringForSqlObject($select);
        $resultSet = $this->adapter->query($sqlString, 
            \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
       	if ($resultSet->count() <= 0) {
       		return null;
       	}
		$resultArray = $resultSet->toArray();
        return $resultArray[0];
    }

    public function findByBattleId($battleId)
    {
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->from($this->table_name);
        $select->order(ToyControlJsonKey::CreatedAt.' ASC');
        $select->where(array(ToyControlJsonKey::BattleId => $battleId));

        $sqlString = $sql->getSqlStringForSqlObject($select);
        $resultSet = $sql->getAdapter()->query($sqlString, 
                \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        if ($resultSet->count() <= 0) {
            return null;
        }
        return $resultSet->toArray();
    }

    public function findByBattleId_ToyDeviceId($battleId, $toyDeviceId)
    {
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->from($this->table_name);
        $select->order(ToyControlJsonKey::CreatedAt.' ASC');
        $select->where(array(
            ToyControlJsonKey::BattleId => $battleId,
            ToyControlJsonKey::ToyDeviceId => $toyDeviceId,
            ToyControlJsonKey::IsDone => false,
        ));

        $sqlString = $sql->getSqlStringForSqlObject($select);
        $resultSet = $sql->getAdapter()->query($sqlString, 
                \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        if ($resultSet->count() <= 0) {
            return null;
        }
        return $resultSet->toArray();
    }

    public function insert($battleId, $toyDeviceId, $data)
    {
        $data[ToyControlJsonKey::Id] = UuidHelper::uuid();

        $sql = new Sql($this->adapter);
        $insert = $sql->insert($this->table_name);
        $insert->values(array(
            ToyControlJsonKey::Id => $data[ToyControlJsonKey::Id],
            ToyControlJsonKey::BattleId => $battleId,
            ToyControlJsonKey::ToyDeviceId => $toyDeviceId,
            ToyControlJsonKey::Type => $data[ToyControlJsonKey::Type],
            ToyControlJsonKey::CreatedAt => DateTimeHelper::nowDateTimeUTC("Y-m-d H:i:s"),
            ));

        $sqlString = $sql->getSqlStringForSqlObject($insert);
        $result = $this->adapter->query($sqlString, 
            \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        if (!$result) {
            return null;
        }
        return $this->findById($data[ToyControlJsonKey::Id]);
    }

    public function update($id, $data)
    {
        $sql = new Sql($this->adapter);
        $update = $sql->update($this->table_name);
        $update->where(array(ToyControlJsonKey::Id => $id));
        $update->set($data);

        $sqlString = $sql->getSqlStringForSqlObject($update);
        $resultSet = $sql->getAdapter()->query($sqlString, 
                \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        return $this->findById($id);
    }

    public function delete($id)
    {
        $sql = new Sql($this->adapter);
        $delete = $sql->delete();
        $delete->from($this->table_name);
        $delete->where(array(ToyControlJsonKey::Id => $id));

        $sqlString = $sql->getSqlStringForSqlObject($delete);
        $resultSet = $this->adapter->query($sqlString, 
            \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        if ($resultSet->count() > 0) {
            return true;
        }
        return false;
    }

    public function deleteAllByDeviceId($toyDeviceId)
    {
        $sql = new Sql($this->adapter);
        $delete = $sql->delete();
        $delete->from($this->table_name);
        $delete->where(array(
            ToyControlJsonKey::ToyDeviceId => $toyDeviceId
        ));

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
