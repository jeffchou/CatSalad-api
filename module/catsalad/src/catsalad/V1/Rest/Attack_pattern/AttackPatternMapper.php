<?php
namespace catsalad\V1\Rest\Attack_pattern;

use ZF\ApiProblem\ApiProblem;

use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Paginator\Adapter\DbSelect;

use catsalad\V1\Exception\ResourceNotFoundException;
use catsalad\V1\Exception\AccessTokenExpiredException;

use catsalad\V1\Rest\Attack_pattern\AttackPatternDbSelect;
use catsalad\V1\Rest\Attack_type\Attack_typeEntity;
use catsalad\V1\Utility\DateTimeHelper;

use catsalad\V1\Model\Context;

class AttackPatternMapper
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
    	$select->from('attack_pattern');

        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new AttackPatternCollectionEntity());

        $paginatorAdapter = new AttackPatternDbSelect($select, $this->adapter, $resultSetPrototype);
        $paginatorAdapter->setContext($this->context);
		$collection = new Attack_patternCollection($paginatorAdapter);
        return $collection;
    }

    public function fetch($id)
    {
        $manager = $this->context->getAttackPatternManager();
        $result = $manager->findById($id);
        if (!$result) {
            throw new ResourceNotFoundException($id);
            return null;
        }

        $attackTypeMapper = $this->context->getAttackTypeMapper();
        $attackTypeResult = $attackTypeMapper->fetchByPatternId($id);
        $result[AttackPatternJsonKey::AttackType] = $attackTypeResult;

        $entity = new Attack_patternEntity();
        $entity->exchangeArray($result);

        return $entity;
    }

    public function insert($data)
    {
        $manager = $this->context->getAttackPatternManager();
        return $manager->insert($data);
    }

    public function update($id, $data)
    {
        $manager = $this->context->getAttackPatternManager();
        $result = $manager->update($id, $data);
        if (!$result) {
            throw new ResourceNotFoundException($id);
            return null;
        }
        return $this->fetch($id);
    }

    public function delete($id)
    {
        $manager = $this->context->getAttackPatternManager();
        return $manager->delete($id);
    }
}