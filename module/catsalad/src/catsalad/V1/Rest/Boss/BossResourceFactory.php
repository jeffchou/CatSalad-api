<?php
namespace catsalad\V1\Rest\Boss;

class BossResourceFactory
{
    public function __invoke($services)
    {
    	$mapper = $services->get('catsalad\V1\Rest\Boss\BossMapper');
    	$context = $services->get('catsalad\V1\Model\Context');
    	$mapper->setContext($context);
        return new BossResource($mapper);
    }
}
