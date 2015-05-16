<?php
namespace catsalad\V1\Rest\Cat_activity;

use catsalad\V1\Rest\AbstractClass\AbstractJsonKey;

class CatActivityJsonKey extends AbstractJsonKey
{
	const CatActivity = 'cat_activity';

	const Id = 'id';
	const CatId = 'cat_id';
	const BattleId = 'battle_id';
	const Time = 'time';
	const HitType = 'hit_type';
	const Exp = 'exp';
	const Score = 'score';

	const Distance = 'distance';
	const ByMonth = 'by_month';
	const ByDay = 'by_day';
	const ByTime = 'by_time';
}