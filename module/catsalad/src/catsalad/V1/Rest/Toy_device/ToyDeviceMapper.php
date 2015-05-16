<?php
namespace catsalad\V1\Rest\Toy_device;

use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;

use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Paginator\Adapter\DbSelect;

use catsalad\V1\Exception\ResourceNotFoundException;
use catsalad\V1\Exception\AccessTokenExpiredException;

use catsalad\V1\Validator\FloatValue;

class ToyDeviceMapper
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
    	$select->from('toy_device');

        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Toy_deviceEntity());

        $paginatorAdapter = new DbSelect($select, $this->adapter, $resultSetPrototype);
		$collection = new Toy_deviceCollection($paginatorAdapter);
        return $collection;
    }

    public function fetch($id)
    {
        $toyDeviceManager = $this->context->getToyDeviceManager();
        $result = $toyDeviceManager->findById($id);
        if (!$result) {
        	throw new ResourceNotFoundException($id);
            return null;
        }
        
        $entity = new Toy_deviceEntity();
        $entity->exchangeArray($result);

        return $entity;
    }

    public function fetchByUserId($id)
    {
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->from('toy_device');
        $select->where(array(ToyDeviceJsonKey::UserId => $id));

        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Toy_deviceEntity());

        $paginatorAdapter = new DbSelect($select, $this->adapter, $resultSetPrototype);
        $collection = new Toy_deviceCollection($paginatorAdapter);
        return $collection;
    }

    public function insert($data)
    {
        $location = $data[ToyDeviceJsonKey::Location];
        $data[ToyDeviceJsonKey::Latitude] = $location[ToyDeviceJsonKey::Latitude];
        $data[ToyDeviceJsonKey::Longitude] = $location[ToyDeviceJsonKey::Longitude];
        unset($data[ToyDeviceJsonKey::Location]);
        
        $floatValidator = new FloatValue();
        if (!$floatValidator->isValid($data[ToyDeviceJsonKey::Latitude])) {
            return new ApiProblemResponse(
                new ApiProblem(422, 'Failed Validation', null, null, array(
                    'validation_messages' => $floatValidator->getMessages(),
                ))
            );
        }
        if (!$floatValidator->isValid($data[ToyDeviceJsonKey::Longitude])) {
            return new ApiProblemResponse(
                new ApiProblem(422, 'Failed Validation', null, null, array(
                    'validation_messages' => $floatValidator->getMessages(),
                ))
            );
        }
        
        $toyDeviceManager = $this->context->getToyDeviceManager();
        return $toyDeviceManager->insert($data);
    }

    public function update($id, $data)
    {
        $toyDeviceManager = $this->context->getToyDeviceManager();
        $result = $toyDeviceManager->update($id, $data);
        if (!$result) {
            throw new ResourceNotFoundException($id);
            return null;
        }
        return $this->fetch($id);
    }

    public function delete($id)
    {
        $toyDeviceManager = $this->context->getToyDeviceManager();
		return $toyDeviceManager->delete($id);
    }
}