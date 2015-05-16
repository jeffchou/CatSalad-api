<?php
namespace catsalad\V1\Rest\Toydevice_user;

use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;

use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Paginator\Adapter\DbSelect;

use catsalad\V1\Exception\ResourceNotFoundException;
use catsalad\V1\Exception\AccessTokenExpiredException;

use catsalad\V1\Rest\Cat\CatJsonKey;

use catsalad\V1\Validator\FloatValue;

class ToydeviceUserMapper
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

    public function fetchByToyDeviceId($id)
    {
        $toyDeviceManager = $this->context->getToyDeviceManager();
        $result = $toyDeviceManager->findById($id);
        if (!$result) {
        	throw new ResourceNotFoundException($id);
            return null;
        }
        
        $userId = $result[ToydeviceUserJsonKey::UserId];

        $userManager = $this->context->getUserManager();
        $result = $userManager->findById($userId);
        if ($result == null) {
            throw new ResourceNotFoundException($id);
            return null;
        }

        // find cats
        $catManager = $this->context->getCatManager();
        $catArray = $catManager->findByUserId($userId);
        $result[ToydeviceUserJsonKey::CatId] = $catArray[0][CatJsonKey::Id];

        $entity = new Toydevice_userEntity();
        $entity->exchangeArray($result);

        return $entity;
    }
}