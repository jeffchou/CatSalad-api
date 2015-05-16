<?php
namespace catsalad\V1\Rest\Battle_boss;

use catsalad\V1\Rest\AbstractClass\AbstractJsonKey;

class BattleBossJsonKey extends AbstractJsonKey
{
	const Boss = 'boss';

	const Id = 'id';
	const Name = 'name';
	const Hp = 'hp';
	const Description = 'description';
	const SpawnTime = 'spawn_time';
	const AttackPatternId = 'attack_pattern_id';
	const AttackPattern = 'attack_pattern';
	const ImageUrl = 'image_url';
	const CreatedAt = 'created_at';
	const UpdatedAt = 'updated_at';

	const BattleId = 'battle_id';
	const BossId = 'boss_id';
}