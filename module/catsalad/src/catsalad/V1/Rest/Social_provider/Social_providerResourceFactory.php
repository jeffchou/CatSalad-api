<?php
namespace catsalad\V1\Rest\Social_provider;

class Social_providerResourceFactory
{
    public function __invoke($services)
    {
        return new Social_providerResource();
    }
}
