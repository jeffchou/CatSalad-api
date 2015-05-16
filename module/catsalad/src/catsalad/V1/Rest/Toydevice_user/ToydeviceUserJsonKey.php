<?php
namespace catsalad\V1\Rest\Toydevice_user;

use catsalad\V1\Rest\AbstractClass\AbstractJsonKey;

class ToydeviceUserJsonKey extends AbstractJsonKey
{
	const Id = 'id';
	const Name = 'name';
	const DeviceToken = 'device_token';
	const Cat = 'cat';
	const CreatedAt = 'created_at';
	const UpdatedAt = 'updated_at';

	const UserId = 'user_id';

	const ToyDeviceId = 'toy_device_id';

	const ToyId = 'toy_id';
	const ToyCreatedAt = 'toy_created_at';
	const ToyUpdatedAt = 'toy_updated_at';

	const CatId = 'cat_id';
	const CatName = 'cat_name';
	const CatCreatedAt = 'cat_created_at';
	const CatUpdatedAt = 'cat_updated_at';
}