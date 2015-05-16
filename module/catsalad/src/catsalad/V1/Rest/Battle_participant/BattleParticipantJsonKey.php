<?php
namespace catsalad\V1\Rest\Battle_participant;

use catsalad\V1\Rest\AbstractClass\AbstractJsonKey;

class BattleParticipantJsonKey extends AbstractJsonKey
{
	const BattleId = 'battle_id';
	const CatId = 'cat_id';

	const Rank = 'rank';
	
	const Sort = 'sort';
	const Location = 'location';
	const Score = 'score';
}