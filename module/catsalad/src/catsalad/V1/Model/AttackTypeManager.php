<?php
namespace catsalad\V1\Model;

use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Paginator\Adapter\DbSelect;

use catsalad\V1\Utility\UuidHelper;

use catsalad\V1\Exception\ResourceNotFoundException;
use catsalad\V1\Exception\AccessTokenExpiredException;

use catsalad\V1\Rest\Attack_pattern\AttackPatternJsonKey;
use catsalad\V1\Rest\Attack_type\AttackTypeJsonKey;

use catsalad\V1\Utility\DateTimeHelper;

class AttackTypeManager
{
    protected $table_name = 'attack_type';
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
    	$select->where(array(AttackTypeJsonKey::Id => $id));

		$sqlString = $sql->getSqlStringForSqlObject($select);
        $resultSet = $this->adapter->query($sqlString, 
            \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
       	if ($resultSet->count() <= 0) {
       		return null;
       	}
		$resultArray = $resultSet->toArray();
        return $resultArray[0];
    }

    public function findByPatternId($id)
    {
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->from('attack_type_mapping');
        $select->where(array(AttackPatternJsonKey::AttackPatternId => $id));
        $select->columns(array(AttackPatternJsonKey::AttackTypeOrder));
        $select->order(AttackPatternJsonKey::AttackTypeOrder.' ASC');
        $select->join(
            'attack_type',
            'attack_type_mapping.attack_type_id = attack_type.id',
            array(
                AttackPatternJsonKey::AttackTypeId,
                AttackPatternJsonKey::AttackTypeName,
                AttackPatternJsonKey::CreatedAt,
                AttackPatternJsonKey::UpdatedAt),
            $select::JOIN_LEFT);
        $sqlString = $sql->getSqlStringForSqlObject($select);
        $resultSet = $sql->getAdapter()->query($sqlString, 
            \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        $resultArray = $resultSet->toArray();

        return $resultArray;
    }

    public function insert($data)
    {
        $data[AttackTypeJsonKey::Id] = UuidHelper::uuid();

        $sql = new Sql($this->adapter);
        $insert = $sql->insert($this->table_name);
            $insert->values(array(
            AttackTypeJsonKey::Id => $data[AttackTypeJsonKey::Id],
            AttackTypeJsonKey::Name => $data[AttackTypeJsonKey::Name],
            AttackTypeJsonKey::CreatedAt => DateTimeHelper::nowDateTimeUTC("Y-m-d H:i:s"),
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
        $sql = new Sql($this->adapter);
        $update = $sql->update($this->table_name);
        $update->where(array(AttackTypeJsonKey::Id => $id));
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
        $delete->where(array(AttackTypeJsonKey::Id => $id));

        $sqlString = $sql->getSqlStringForSqlObject($delete);
        $resultSet = $this->adapter->query($sqlString, 
            \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        if ($resultSet->count() > 0) {
            return true;
        }
        return false;
    }
}
