<?php
namespace catsalad\V1\Rest\Toy_device;

use catsalad\V1\Rest\AbstractClass\AbstractJsonKey;

class ToyDeviceJsonKey extends AbstractJsonKey
{
	const ToyDeivce = 'toy_device';

	const Id = 'id';
	const DeviceId = 'device_id';
	const UserId = 'user_id';
	const IsEnableSound = 'is_enable_sound';
	const IsUseSystemRecommendedTime = 'is_use_system_recommended_time';
	const SystemRecommendedTime = 'system_recommended_time';
	const UserScheduledTime = 'user_scheduled_time';
	const CreatedAt = 'created_at';
	const UpdatedAt = 'updated_at';

	const Location = 'location';
	const Latitude = 'latitude';
	const Longitude = 'longitude';

	const CatLatitude = 'cat_latitude';
	const CatLongitude = 'cat_longitude';
}