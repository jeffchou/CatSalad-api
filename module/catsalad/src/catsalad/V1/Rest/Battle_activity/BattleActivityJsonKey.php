<?php
namespace catsalad\V1\Rest\Battle_activity;

use catsalad\V1\Rest\AbstractClass\AbstractJsonKey;

class BattleActivityJsonKey extends AbstractJsonKey
{
	const Id = 'id';
	const CatId = 'cat_id';
	const BattleId = 'battle_id';
	const Time = 'time';
	const HitType = 'hit_type';
	const Exp = 'exp';
	const Score = 'score';

	const ParticipantId = 'participant_id';

	const Distance = 'distance';
	const Date = 'date';
	const DateHour = 'date_hour';
}