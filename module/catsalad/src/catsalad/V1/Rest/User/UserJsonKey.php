<?php
namespace catsalad\V1\Rest\User;

use catsalad\V1\Rest\AbstractClass\AbstractJsonKey;

class UserJsonKey extends AbstractJsonKey
{
	const User = 'user';

	const Id = 'id';
	const Name = 'name';
	const DeviceToken = 'device_token';
	const AccessToken = 'access_token';
	const SocialProvider = 'social_provider';
	const ToyDevice = 'toy_device';
	const Cat = 'cat';
	const CreatedAt = 'created_at';
	const UpdatedAt = 'updated_at';
	const ToyDeviceId = 'toy_device_id';

	const ToyId = 'toy_id';
	const ToyCreatedAt = 'toy_created_at';
	const ToyUpdatedAt = 'toy_updated_at';

	const CatId = 'cat_id';
	const CatName = 'cat_name';
	const CatCreatedAt = 'cat_created_at';
	const CatUpdatedAt = 'cat_updated_at';
}