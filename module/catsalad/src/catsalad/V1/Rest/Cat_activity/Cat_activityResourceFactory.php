<?php
namespace catsalad\V1\Rest\Cat_activity;

class Cat_activityResourceFactory
{
    public function __invoke($services)
    {
		$mapper = $services->get('catsalad\V1\Rest\Cat_activity\CatActivityMapper');
    	$context = $services->get('catsalad\V1\Model\Context');
    	$mapper->setContext($context);
        return new Cat_activityResource($mapper);
    }
}
