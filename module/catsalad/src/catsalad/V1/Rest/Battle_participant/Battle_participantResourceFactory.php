<?php
namespace catsalad\V1\Rest\Battle_participant;

use catsalad\V1\Rest\Cat\CatMapper;

class Battle_participantResourceFactory
{
    public function __invoke($services)
    {
    	$mapper = $services->get('catsalad\V1\Rest\Battle_participant\BattleParticipantMapper');
    	$context = $services->get('catsalad\V1\Model\Context');
    	$mapper->setContext($context);
        return new Battle_participantResource($mapper);
    }
}
