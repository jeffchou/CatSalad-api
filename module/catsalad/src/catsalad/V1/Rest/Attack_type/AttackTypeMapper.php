<?php
namespace catsalad\V1\Rest\Attack_type;

use ZF\ApiProblem\ApiProblem;

use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Paginator\Adapter\DbSelect;

use catsalad\V1\Exception\ResourceNotFoundException;
use catsalad\V1\Exception\AccessTokenExpiredException;

use catsalad\V1\Model\Context;

class AttackTypeMapper
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
    	$select->from('attack_type');

        $paginatorAdapter = new DbSelect($select, $this->adapter);
		$collection = new Attack_typeCollection($paginatorAdapter);
        return $collection;
    }

    public function fetch($id)
    {
        $manager = $this->context->getAttackTypeManager();
        $result = $manager->findById($id);
        if (!$result) {
            throw new ResourceNotFoundException($id);
            return null;
        }

        $entity = new Attack_typeEntity();
        $entity->exchangeArray($result);

        return $entity;
    }

    public function fetchByPatternId($id)
    {
        $manager = $this->context->getAttackTypeManager();
        $result = $manager->findByPatternId($id);

        $resultArray = array();
        foreach ($result as $key => $value) {
            $entity = new Attack_typeCollectionEntity();
            $entity->exchangeArray($value);
            array_push($resultArray, $entity);
        }

        return $resultArray;
    }

    public function insert($data)
    {
        $manager = $this->context->getAttackTypeManager();
        return $manager->insert($data);
    }

    public function update($id, $data)
    {
        $manager = $this->context->getAttackTypeManager();
        $result = $manager->update($id, $data);
        if (!$result) {
            throw new ResourceNotFoundException($id);
            return null;
        }
        return $this->fetch($id);
    }

    public function delete($id)
    {
        $manager = $this->context->getAttackTypeManager();
        return $manager->delete($id);
    }
}