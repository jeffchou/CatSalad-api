<?php
namespace catsalad\V1\Rest\Weapon;

use catsalad\V1\Rest\AbstractClass\AbstractJsonKey;

class WeaponJsonKey extends AbstractJsonKey
{
	const Weapon = 'weapon';

	const Id = 'id';
	const Name = 'name';
	const AvailableLevel = 'available_level';
	const AttackBonus = 'attack_bonus';
	const ImageUrl = 'image_url';

	const CreatedAt = 'created_at';
	const UpdatedAt = 'updated_at';
}