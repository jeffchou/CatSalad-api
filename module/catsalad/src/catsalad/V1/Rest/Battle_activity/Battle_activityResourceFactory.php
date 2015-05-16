<?php
namespace catsalad\V1\Rest\Battle_activity;

class Battle_activityResourceFactory
{
    public function __invoke($services)
    {
    	$mapper = $services->get('catsalad\V1\Rest\Battle_activity\BattleActivityMapper');
    	$context = $services->get('catsalad\V1\Model\Context');
    	$mapper->setContext($context);
        return new Battle_activityResource($mapper);
    }
}
