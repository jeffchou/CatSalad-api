<?php
namespace catsalad\V1\Rest\Cat_weapon;

use ZF\ApiProblem\ApiProblem;

use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Paginator\Adapter\DbSelect;

use catsalad\V1\Rest\Cat\CatJsonKey;
use catsalad\V1\Rest\Cat\CatMapper;
use catsalad\V1\Rest\Cat\CatEntity;
use catsalad\V1\Rest\Weapon\WeaponMapper;

use catsalad\V1\Exception\ResourceNotFoundException;
use catsalad\V1\Exception\AccessTokenExpiredException;

class CatWeaponMapper
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

    public function fetch($id)
    {
        $manager = $this->context->getWeaponManager();
        $result = $manager->findById($id);
        if (!$result) {
        	throw new ResourceNotFoundException($id);
            return null;
        }
        
        $entity = new Cat_weaponEntity();
        $entity->exchangeArray($result);

        return $entity;
    }

    public function fetchByCatId($catId)
    {
        $catMapper = $this->context->getCatMapper();
        $cat = $catMapper->fetch($catId);

        return $cat->equipped_weapon;
    }

    public function replaceWeapon($catId, $weapon_id)
    {
        $data = array(
            CatJsonKey::EquippedWeaponId => $weapon_id
        );
        $catMapper = $this->context->getCatMapper();
        $catMapper->update($catId, $data);

        $weaponMapper = $this->context->getWeaponMapper();
        return $weaponMapper->fetch($weapon_id);
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
}