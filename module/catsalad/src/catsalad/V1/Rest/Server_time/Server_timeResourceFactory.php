<?php
namespace catsalad\V1\Rest\Server_time;

class Server_timeResourceFactory
{
    public function __invoke($services)
    {
        return new Server_timeResource();
    }
}
