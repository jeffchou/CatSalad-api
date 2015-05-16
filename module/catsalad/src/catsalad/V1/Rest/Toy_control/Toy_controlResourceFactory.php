<?php
namespace catsalad\V1\Rest\Toy_control;

class Toy_controlResourceFactory
{
    public function __invoke($services)
    {
    	$mapper = $services->get('catsalad\V1\Rest\Toy_control\ToyControlMapper');
    	$context = $services->get('catsalad\V1\Model\Context');
    	$mapper->setContext($context);
        return new Toy_controlResource($mapper);
    }
}
