<?php
namespace catsalad\V1\Model;

use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Paginator\Adapter\DbSelect;

use catsalad\V1\Utility\UuidHelper;

use catsalad\V1\Exception\ResourceNotFoundException;
use catsalad\V1\Exception\AccessTokenExpiredException;

use catsalad\V1\Rest\Battle\BattleJsonKey;

use catsalad\V1\Utility\DateTimeHelper;

class BattleManager
{
    protected $table_name = 'battle';
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
    	$select->where(array(BattleJsonKey::Id => $id));

		$sqlString = $sql->getSqlStringForSqlObject($select);
        $resultSet = $this->adapter->query($sqlString, 
            \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
       	if ($resultSet->count() <= 0) {
       		return null;
       	}
		$resultArray = $resultSet->toArray();
        return $resultArray[0];
    }

    /**
     * Find all cat activity related the specified cat.
     *
     * @param id the specified cat id.
     *
     * @return Array of the Cat Activity
     */
    public function findByCatId($id)
    {
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->from($this->table_name);
        $select->where(array(BattleJsonKey::Id => $id));

        $sqlString = $sql->getSqlStringForSqlObject($select);
        $resultSet = $this->adapter->query($sqlString, 
            \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        if ($resultSet->count() <= 0) {
            return null;
        }
        $resultArray = $resultSet->toArray();
        return $resultArray;
    }

    public function insert($data)
    {
        $uuid = UuidHelper::uuid();

        $sql = new Sql($this->adapter);
        $insert = $sql->insert($this->table_name);
        $insert->values(array(
            BattleJsonKey::Id => $uuid,
            BattleJsonKey::Name => $data[BattleJsonKey::Name],
            BattleJsonKey::ActivatedAt => $data[BattleJsonKey::ActivatedAt],
            BattleJsonKey::ThumbImageUrl => $data[BattleJsonKey::ThumbImageUrl],
            BattleJsonKey::FullsizeImageUrl => $data[BattleJsonKey::FullsizeImageUrl]
            ));

        $sqlString = $sql->getSqlStringForSqlObject($insert);
        $result = $this->adapter->query($sqlString, 
            \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        if (!$result) {
            return null;
        }
        return $this->findById($uuid);
    }

    public function update($id, $data)
    {
        $sql = new Sql($this->adapter);
        $update = $sql->update($this->table_name);
        $update->where(array(BattleJsonKey::Id => $id));
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
        $delete->where(array(BattleJsonKey::Id => $id));

        $sqlString = $sql->getSqlStringForSqlObject($delete);
        $resultSet = $this->adapter->query($sqlString, 
            \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        if ($resultSet->count() > 0) {
            return true;
        }
        return false;
    }
}
