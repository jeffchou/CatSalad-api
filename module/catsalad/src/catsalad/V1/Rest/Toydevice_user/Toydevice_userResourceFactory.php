<?php
namespace catsalad\V1\Rest\Toydevice_user;

class Toydevice_userResourceFactory
{
    public function __invoke($services)
    {
    	$mapper = $services->get('catsalad\V1\Rest\Toydevice_user\ToydeviceUserMapper');
    	$context = $services->get('catsalad\V1\Model\Context');
    	$mapper->setContext($context);
        return new Toydevice_userResource($mapper);
    }
}
