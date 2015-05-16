<?php
namespace catsalad\V1\Rest\Cat_weapon;

class Cat_weaponResourceFactory
{
    public function __invoke($services)
    {
    	$mapper = $services->get('catsalad\V1\Rest\Cat_weapon\CatWeaponMapper');
    	$context = $services->get('catsalad\V1\Model\Context');
    	$mapper->setContext($context);
        return new Cat_weaponResource($mapper);
    }
}
