<?php
namespace catsalad\V1\Rest\Battle_boss;

use catsalad\V1\Rest\Boss\BossMapper;

class Battle_bossResourceFactory
{
    public function __invoke($services)
    {
    	$mapper = $services->get('catsalad\V1\Rest\Boss\BossMapper');
    	$context = $services->get('catsalad\V1\Model\Context');
    	$mapper->setContext($context);
        return new Battle_bossResource($mapper);
    }
}
