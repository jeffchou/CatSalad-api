<?php
namespace catsalad\V1\Rest\Toy_control;

use catsalad\V1\Rest\AbstractClass\AbstractJsonKey;

class ToyControlJsonKey extends AbstractJsonKey
{
	const ToyControl = 'toy_control';

	const Id = 'id';
	const BattleId = 'battle_id';
	const ToyDeviceId = 'toy_device_id';
	const Type = 'type';
	const IsDone = 'is_done';
	const CreatedAt = 'created_at';
	const UpdatedAt = 'updated_at';

	const ContentType = 'content_type';
	const Simple = 'simple';
}