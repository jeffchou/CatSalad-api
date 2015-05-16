<?php
namespace catsalad\V1\Rest\Attack_pattern;

class Attack_patternResourceFactory
{
    public function __invoke($services)
    {
    	$mapper = $services->get('catsalad\V1\Rest\Attack_pattern\AttackPatternMapper');
    	$context = $services->get('catsalad\V1\Model\Context');
    	$mapper->setContext($context);
        return new Attack_patternResource($mapper);
    }
}
