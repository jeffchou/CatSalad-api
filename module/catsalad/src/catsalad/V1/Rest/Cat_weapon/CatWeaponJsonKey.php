<?php
namespace catsalad\V1\Rest\Cat_weapon;

use catsalad\V1\Rest\AbstractClass\AbstractJsonKey;

class CatWeaponJsonKey extends AbstractJsonKey
{
	const CatId = 'cat_id';
	
	const Id = 'id';
	const Name = 'name';
	const AvailableLevel = 'available_level';
	const AttackBonus = 'attack_bonus';
	const ImageUrl = 'image_url';

	const CreatedAt = 'created_at';
	const UpdatedAt = 'updated_at';
}