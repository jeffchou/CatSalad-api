<?php
namespace catsalad\V1\Rest\Weapon;

use ZF\ApiProblem\ApiProblem;

use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Paginator\Adapter\DbSelect;

use catsalad\V1\Exception\ResourceNotFoundException;
use catsalad\V1\Exception\AccessTokenExpiredException;

class WeaponMapper
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
    	$select->from('weapon');
        $select->order(WeaponJsonKey::AvailableLevel.' ASC');

        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new WeaponEntity());

        $paginatorAdapter = new DbSelect($select, $this->adapter, $resultSetPrototype);
		$collection = new WeaponCollection($paginatorAdapter);
        return $collection;
    }

    public function fetch($id)
    {
        $manager = $this->context->getWeaponManager();
        $result = $manager->findById($id);
        if (!$result) {
        	throw new ResourceNotFoundException($id);
            return null;
        }
        
        $entity = new WeaponEntity();
        $entity->exchangeArray($result);

        return $entity;
    }

    public function insert($data)
    {
        $manager = $this->context->getWeaponManager();
        return $manager->insert($data);
    }

    public function update($id, $data)
    {
        $manager = $this->context->getWeaponManager();
        $result = $manager->update($id, $data);
        if (!$result) {
            throw new ResourceNotFoundException($id);
            return null;
        }
        return $this->fetch($id);
    }

    public function delete($id)
    {
        $manager = $this->context->getWeaponManager();
		return $manager->delete($id);
    }
}