<?php
namespace catsalad\V1\Rest\Toy_control;

use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;

use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Paginator\Adapter\DbSelect;

use catsalad\V1\Exception\ResourceNotFoundException;
use catsalad\V1\Exception\AccessTokenExpiredException;

use catsalad\V1\Utility\DateTimeHelper;

use catsalad\V1\Model\Context;
use catsalad\V1\Rest\Battle_partner\BattlePartnerJsonKey;

use catsalad\V1\Validator\Identicals;

class ToyControlMapper
{
    protected $table_name = 'toy_control';
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
    	$select->from('toy_control');
        $select->order(ToyControlJsonKey::CreatedAt.' ASC');

        $paginatorAdapter = new DbSelect($select, $this->adapter);
		$collection = new Toy_controlCollection($paginatorAdapter);

        return $collection;
    }

    public function fetch($id)
    {
        $manager = $this->context->getToyControlManager();
        $result = $manager->findById($id);
        if (!$result) {
            throw new ResourceNotFoundException($id);
            return null;
        }

        $entity = new Toy_controlEntity();
        $entity->exchangeArray($result);

        return $entity;
    }

    public function findByBattleId_ToyDeviceId($battleId, $toyDeviceId, $params)
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

        if (!empty($params[ToyControlJsonKey::ContentType])) {
            $contentType = $params[ToyControlJsonKey::ContentType];
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Toy_controlSimpleEntity());
        }
        else {
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Toy_controlEntity());
        }

        $paginatorAdapter = new DbSelect($select, $this->adapter, $resultSetPrototype);
        $collection = new Toy_controlCollection($paginatorAdapter);

        return $collection;
    }

    public function insert($battleId, $toyDeviceId, $data)
    {
        $manager = $this->context->getToyControlManager();
        $result = $manager->insert($battleId, $toyDeviceId, $data);

        $entity = new Toy_controlEntity();
        $entity->exchangeArray($result);

        return $entity;
    }

    public function update($id, $data)
    {
        if (isset($data[ToyControlJsonKey::IsDone])) {
            $data[ToyControlJsonKey::IsDone] = (int) $data[ToyControlJsonKey::IsDone];
        }

        $manager = $this->context->getToyControlManager();
        $result = $manager->update($id, $data);
        if (!$result) {
            throw new ResourceNotFoundException($id);
            return null;
        }
        return $this->fetch($id);
    }

    public function delete($id)
    {
        $manager = $this->context->getToyControlManager();
        return $manager->delete($id);
    }

    public function deleteAllByDeviceId($toyDeviceId)
    {
        $manager = $this->context->getToyControlManager();
        return $manager->deleteAllByDeviceId($toyDeviceId);
    }
}