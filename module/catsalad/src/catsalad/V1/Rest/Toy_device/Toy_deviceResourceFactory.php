<?php
namespace catsalad\V1\Rest\Toy_device;

class Toy_deviceResourceFactory
{
    public function __invoke($services)
    {
    	$mapper = $services->get('catsalad\V1\Rest\Toy_device\ToyDeviceMapper');
    	$context = $services->get('catsalad\V1\Model\Context');
    	$mapper->setContext($context);
        return new Toy_deviceResource($mapper);
    }
}
