<?php
namespace catsalad\V1\Rest\User;

class UserResourceFactory
{
    public function __invoke($services)
    {
    	$mapper = $services->get('catsalad\V1\Rest\User\UserMapper');
    	$context = $services->get('catsalad\V1\Model\Context');
    	$mapper->setContext($context);
        return new UserResource($mapper);
    }
}
