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
use catsalad\V1\Rest\Social_provider\SocialProviderJsonKey;

class SocialProviderManager
{
    protected $table_name = 'social_provider';
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
    	$select->where(array(SocialProviderJsonKey::Id => $id));

		$sqlString = $sql->getSqlStringForSqlObject($select);
        $resultSet = $this->adapter->query($sqlString, 
            \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
       	if ($resultSet->count() <= 0) {
       		return null;
       	}
		$data = $resultSet->toArray();
        return $data[0];
    }

    public function findByUserId($userId)
    {
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->from($this->table_name);
        $select->where(array(SocialProviderJsonKey::UserId => $userId));
        $select->columns(array(
            SocialProviderJsonKey::SocialUserId,
            SocialProviderJsonKey::Name));

        $sqlString = $sql->getSqlStringForSqlObject($select);
        $resultSet = $sql->getAdapter()->query($sqlString, 
                \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        if ($resultSet->count() <= 0) {
            return null;
        }
        $data = $resultSet->toArray();
        return $data;
    }

    public function findBySocialUserId($socialUserId)
    {
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->from($this->table_name);
        $select->where(array(SocialProviderJsonKey::SocialUserId => $socialUserId));
        $select->columns(array(
            SocialProviderJsonKey::UserId,
            SocialProviderJsonKey::SocialUserId,
            SocialProviderJsonKey::Name,
            ));

        $sqlString = $sql->getSqlStringForSqlObject($select);
        $resultSet = $sql->getAdapter()->query($sqlString, 
                \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        if ($resultSet->count() <= 0) {
            return null;
        }
        $resultArray = $resultSet->toArray();
        return $resultArray[0];
    }

    public function insert($data)
    {
        $user = array();
        $user[UserJsonKey::Id] = null;
        return $this->insertByUser($user, $data);
    }

    public function insertByUser($user, $data)
    {
        $uuid = UuidHelper::uuid();

        $sql = new Sql($this->adapter);
        $insert = $sql->insert($this->table_name);
            $insert->values(array(
            SocialProviderJsonKey::Id => $uuid,
            SocialProviderJsonKey::UserId => $user[UserJsonKey::Id],
            SocialProviderJsonKey::SocialUserId => $data[SocialProviderJsonKey::SocialUserId],
            SocialProviderJsonKey::Name => $data[SocialProviderJsonKey::Name],
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
        $update->where(array(SocialProviderId::Id => $id));
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
        $delete->where(array(SocialProviderId::Id => $id));

        $sqlString = $sql->getSqlStringForSqlObject($delete);
        $resultSet = $this->adapter->query($sqlString, 
            \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        if ($resultSet->count() > 0) {
            return true;
        }
        return false;
    }
}
