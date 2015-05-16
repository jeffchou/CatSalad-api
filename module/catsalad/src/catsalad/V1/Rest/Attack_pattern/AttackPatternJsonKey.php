<?php
namespace catsalad\V1\Rest\Attack_pattern;

use catsalad\V1\Rest\AbstractClass\AbstractJsonKey;

class AttackPatternJsonKey extends AbstractJsonKey
{
	const AttackPattern = 'attack_pattern';

	const Id = 'id';
	const Name = 'name';
	const AttackType = 'attack_type';
	const CreatedAt = 'created_at';
	const UpdatedAt = 'updated_at';

	const AttackPatternId = 'attack_pattern_id';
	const AttackTypeId = 'id';
	const AttackTypeOrder = 'order';
	const AttackTypeName = 'name';

	const AttackTypeAliasId = 'attack_type_id';
	const AttackTypeAliasOrder = 'attack_type_order';
	const AttackTypeAliasName = 'attack_type_name';
}