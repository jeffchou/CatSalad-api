<?php
namespace catsalad\V1\Model;

use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;

use catsalad\V1\Model\UserManager;
use catsalad\V1\Model\SocialProviderManager;
use catsalad\V1\Model\ToyDeviceManager;
use catsalad\V1\Model\CatActivityManager;
use catsalad\V1\Model\WeaponManager;
use catsalad\V1\Model\BossManager;
use catsalad\V1\Model\AttackPatternManager;
use catsalad\V1\Model\AttackTypeManager;
use catsalad\V1\Model\BattleManager;
use catsalad\V1\Model\ToyControlManager;

class Context implements ServiceManagerAwareInterface
{
	protected $userManager;
	protected $socialProviderManager;
	protected $toyDeviceManager;
	protected $catManager;
	protected $catActivityManager;
	protected $weaponManager;
	protected $bossManager;
    protected $attackPatternManager;
    protected $attackTypeManager;
    protected $battleManager;
    protected $toyControlManager;

 	/**
     * @var ServiceManager
     */
    protected $serviceManager;

	public function setServiceManager(ServiceManager $serviceManager)
	{
        $this->serviceManager = $serviceManager;
    }
    
    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    // User
    public function getUserMapper()
    {
        $mapper = $this->serviceManager->get('catsalad\V1\Rest\User\UserMapper');
        $mapper->setContext($this);
        return $mapper;
    }

    public function getUserManager()
    {
    	if ($this->userManager == null) {
    		$this->userManager = $this->serviceManager->get('catsalad\V1\Model\UserManager');
    	}
    	return $this->userManager;
    }

    // Social Provider
    public function getSocialProviderManager()
    {
		if ($this->socialProviderManager == null) {
    		$this->socialProviderManager = $this->serviceManager->get('catsalad\V1\Model\SocialProviderManager');
    	}
    	return $this->socialProviderManager;
    }

    // Toy Device
    public function getToyDeviceMapper()
    {
        $mapper = $this->serviceManager->get('catsalad\V1\Rest\Toy_device\ToyDeviceMapper');
        $mapper->setContext($this);
        return $mapper;
    }

    public function getToyDeviceManager()
    {
		if ($this->toyDeviceManager == null) {
    		$this->toyDeviceManager = $this->serviceManager->get('catsalad\V1\Model\ToyDeviceManager');
    	}
    	return $this->toyDeviceManager;
    }

    // Cat
    public function getCatMapper()
    {
        $mapper = $this->serviceManager->get('catsalad\V1\Rest\Cat\CatMapper');
        $mapper->setContext($this);
        return $mapper;
    }

    public function getCatManager()
    {
		if ($this->catManager == null) {
    		$this->catManager = $this->serviceManager->get('catsalad\V1\Model\CatManager');
    	}
    	return $this->catManager;
    }

    // Cat Activity
    public function getCatActivityMapper()
    {
        $mapper = $this->serviceManager->get('catsalad\V1\Rest\Cat_activity\CatActivityMapper');
        $mapper->setContext($this);
        return $mapper;
    }

    public function getCatActivityManager()
    {
		if ($this->catActivityManager == null) {
    		$this->catActivityManager = $this->serviceManager->get('catsalad\V1\Model\CatActivityManager');
    	}
    	return $this->catActivityManager;
    }

    // Weapon
    public function getWeaponMapper()
    {
        $mapper = $this->serviceManager->get('catsalad\V1\Rest\Weapon\WeaponMapper');
        $mapper->setContext($this);
        return $mapper;
    }

    public function getWeaponManager()
    {
    	if ($this->weaponManager == null) {
    		$this->weaponManager = $this->serviceManager->get('catsalad\V1\Model\WeaponManager');
    	}
    	return $this->weaponManager;
    }

    // Boss
    public function getBossMapper()
    {
        $mapper = $this->serviceManager->get('catsalad\V1\Rest\Boss\BossMapper');
        $mapper->setContext($this);
        return $mapper;
    }

    public function getBossManager()
    {
    	if ($this->bossManager == null) {
    		$this->bossManager = $this->serviceManager->get('catsalad\V1\Model\BossManager');
    	}
    	return $this->bossManager;
    }

    // Attack Pattern
    public function getAttackPatternMapper()
    {
        $mapper = $this->serviceManager->get('catsalad\V1\Rest\Attack_pattern\AttackPatternMapper');
        $mapper->setContext($this);
        return $mapper;
    }

    public function getAttackPatternManager()
    {
    	if ($this->attackPatternManager == null) {
    		$this->attackPatternManager = $this->serviceManager->get('catsalad\V1\Model\AttackPatternManager');
    	}
    	return $this->attackPatternManager;
    }

    // Attack Type
    public function getAttackTypeMapper()
    {
        $mapper = $this->serviceManager->get('catsalad\V1\Rest\Attack_type\AttackTypeMapper');
        $mapper->setContext($this);
        return $mapper;
    }

    public function getAttackTypeManager()
    {
        if ($this->attackTypeManager == null) {
            $this->attackTypeManager = $this->serviceManager->get('catsalad\V1\Model\AttackTypeManager');
        }
        return $this->attackTypeManager;
    }

    // Battle
    public function getBattleManager()
    {
        if ($this->battleManager == null) {
            $this->battleManager = $this->serviceManager->get('catsalad\V1\Model\BattleManager');
        }
        return $this->battleManager;
    }

    public function getBattleMapper()
    {
        $mapper = $this->serviceManager->get('catsalad\V1\Rest\Battle\BattleMapper');
        $mapper->setContext($this);
        return $mapper;
    }

    public function getBattleParticipantMapper()
    {
        $mapper = $this->serviceManager->get('catsalad\V1\Rest\Battle_participant\BattleParticipantMapper');
        $mapper->setContext($this);
        return $mapper;
    }

    public function getToyControlManager()
    {
        if ($this->toyControlManager == null) {
            $this->toyControlManager = $this->serviceManager->get('catsalad\V1\Model\ToyControlManager');
        }
        return $this->toyControlManager;
    }

    public function getToyControlMapper()
    {
        $mapper = $this->serviceManager->get('catsalad\V1\Rest\Toy_control\ToyControlMapper');
        $mapper->setContext($this);
        return $mapper;
    }

    public function getCatWeaponMapper()
    {
        $mapper = $this->serviceManager->get('catsalad\V1\Rest\Cat_weapon\CatWeaponMapper');
        $mapper->setContext($this);
        return $mapper;
    }

    public function getToydeviceUserMapper()
    {
        $mapper = $this->serviceManager->get('catsalad\V1\Rest\Toydevice_user\ToydeviceMapper');
        $mapper->setContext($this);
        return $mapper;
    }
}