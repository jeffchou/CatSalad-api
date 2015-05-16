<?php
namespace catsalad\V1\Rest\Cat;

use catsalad\V1\Rest\AbstractClass\AbstractJsonKey;

class CatJsonKey extends AbstractJsonKey
{
	const Cat = 'cat';

	const Id = 'id';
	const UserId = 'user_id';
	const Name = 'name';
	const Gender = 'gender';
	const Birthday = 'birthday';
	const EquippedWeaponId = 'equipped_weapon_id';
	const ImageUrl = 'image_url';
	const LVL = 'lvl';
	const Exp = 'exp';
	const Score = 'score';
	const EquippedWeapon = 'equipped_weapon';
	const CreatedAt = 'created_at';
	const UpdatedAt = 'updated_at';

	const Location = 'location';
	const Latitude = 'latitude';
	const Longitude = 'longitude';

	const Type = 'type';
	const Simple = 'simple';
}