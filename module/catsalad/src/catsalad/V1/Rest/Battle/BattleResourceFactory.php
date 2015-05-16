<?php
namespace catsalad\V1\Rest\Battle;

class BattleResourceFactory
{
    public function __invoke($services)
    {
    	$mapper = $services->get('catsalad\V1\Rest\Battle\BattleMapper');
    	$context = $services->get('catsalad\V1\Model\Context');
    	$mapper->setContext($context);
        return new BattleResource($mapper);
    }
}
