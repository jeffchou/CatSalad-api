<?php
namespace catsalad\V1\Rest\Weapon;

class WeaponResourceFactory
{
    public function __invoke($services)
    {
        $mapper = $services->get('catsalad\V1\Rest\Weapon\WeaponMapper');
    	$context = $services->get('catsalad\V1\Model\Context');
    	$mapper->setContext($context);
        return new WeaponResource($mapper);
    }
}
