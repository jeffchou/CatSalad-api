<?php
namespace catsalad\V1\Rest\Active_boss;

class Active_bossResourceFactory
{
    public function __invoke($services)
    {
    	$mapper = $services->get('catsalad\V1\Rest\Active_boss\ActiveBossMapper');
    	$context = $services->get('catsalad\V1\Model\Context');
    	$mapper->setContext($context);
        return new Active_bossResource($mapper);
    }
}
