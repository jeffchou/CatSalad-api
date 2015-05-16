<?php
namespace catsalad\V1\Rest\Attack_pattern_content;

class Attack_pattern_contentResourceFactory
{
    public function __invoke($services)
    {
    	$mapper = $services->get('catsalad\V1\Rest\Attack_type\AttackTypeMapper');
    	$context = $services->get('catsalad\V1\Model\Context');
    	$mapper->setContext($context);
        return new Attack_pattern_contentResource($mapper);
    }
}
