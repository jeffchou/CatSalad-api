<?php
namespace catsalad\V1\Rest\Active_boss;

use ZF\ApiProblem\ApiProblem;

use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Paginator\Adapter\DbSelect;

use catsalad\V1\Exception\ResourceNotFoundException;
use catsalad\V1\Exception\AccessTokenExpiredException;

use catsalad\V1\Boss\BossManager;
use catsalad\V1\Utility\DateTimeHelper;

use catsalad\V1\Model\Context;

class ActiveBossMapper
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
    	$select->from('active_boss');

        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new ActiveBossCollectionEntity());

        $paginatorAdapter = new ActiveBossDbSelect($select, $this->adapter, $resultSetPrototype);
        $paginatorAdapter->setContext($this->context);
		$collection = new Active_bossCollection($paginatorAdapter);
        return $collection;
    }

    public function fetch($id)
    {
        $manager = $this->context->getActiveBossManager();
        $result = $manager->findById($id);
        if (!$result) {
            throw new ResourceNotFoundException($id);
            return null;
        }

        $bossMapper = $this->context->getBossMapper();
        $result[ActiveBossJsonKey::Boss] = $bossMapper->fetch($result[ActiveBossJsonKey::BossId]);

        $entity = new Active_bossEntity();
        $entity->exchangeArray($result);

        return $entity;
    }

    public function insert($data)
    {
        $manager = $this->context->getActiveBossManager();
        return $manager->insert($data);
    }

    public function update($id, $data)
    {
        $manager = $this->context->getActiveBossManager();
        $result = $manager->update($id, $data);
        if (!$result) {
            throw new ResourceNotFoundException($id);
            return null;
        }
        return $this->fetch($id);
    }

    public function delete($id)
    {
        $manager = $this->context->getActiveBossManager();
        return $manager->delete($id);
    }
}