<?php
namespace catsalad\V1\Rest\Cat;

class CatResourceFactory
{
    public function __invoke($services)
    {
    	$mapper = $services->get('catsalad\V1\Rest\Cat\CatMapper');
    	$context = $services->get('catsalad\V1\Model\Context');
    	$mapper->setContext($context);
        return new CatResource($mapper);
    }
}
