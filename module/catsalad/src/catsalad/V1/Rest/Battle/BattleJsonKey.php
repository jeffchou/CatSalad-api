<?php
namespace catsalad\V1\Rest\Battle;

use catsalad\V1\Rest\AbstractClass\AbstractJsonKey;

class BattleJsonKey extends AbstractJsonKey
{
	const Battle = 'battle';

	const Id = 'id';
	const Name = 'name';
	const ThumbImageUrl = 'thumb_image_url';
	const FullsizeImageUrl = 'fullsize_image_url';
	const ActivatedAt = 'activated_at';
	const CreatedAt = 'created_at';
	const UpdatedAt = 'updated_at';

	const Active = 'active';
	const Upcoming = 'upcoming';
	const Finished = 'finished';
	const Rank = 'rank';

	const ContentType = 'content_type';
	const Simple = 'simple';
}