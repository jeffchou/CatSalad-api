<?php
namespace catsalad\V1\Rest\Attack_type;

class Attack_typeResourceFactory
{
    public function __invoke($services)
    {
    	$mapper = $services->get('catsalad\V1\Rest\Attack_type\AttackTypeMapper');
    	$context = $services->get('catsalad\V1\Model\Context');
    	$mapper->setContext($context);
        return new Attack_typeResource($mapper);
    }
}
