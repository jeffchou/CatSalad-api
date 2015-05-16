<?php
namespace catsalad\V1\Rest\Social_provider;

use catsalad\V1\Rest\AbstractClass\AbstractJsonKey;

class SocialProviderJsonKey extends AbstractJsonKey
{
	const SocialProvider = 'social_provider';
	
	const Id = 'id';
	const UserId = 'user_id';
	const SocialUserId = 'social_user_id';
	const Name = 'social_provider_name';
	const AccessToken = 'social_access_token';
}