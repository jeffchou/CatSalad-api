<?php
namespace catsalad\V1\Rest\Cat_activity;

use catsalad\V1\Rest\Cat_activity\CatActivityJsonKey;
use catsalad\V1\Rest\Cat_activity\HitType;
use catsalad\V1\Rest\Cat\CatJsonKey;
use catsalad\V1\Rest\Weapon\WeaponJsonKey;

class ExpCalculator
{
	protected $context;

    public function __construct($context)
    {
        $this->context = $context;
    }

    public function getContext()
    {
        return $this->context;
    }

	/**
	 * Calculate the activity experience.
	 *
	 * @param cat_activity the cat activity that will be calcualated.
	 *
	 * @return the final experience.
	 */
	public function exp($cat_activity)
	{
		$catManager = $this->context->getCatManager();
		$cat = $catManager->findById($cat_activity[CatActivityJsonKey::CatId]);

		// score = hit_strength * attack_bonus
		$hit_type = $cat_activity[CatActivityJsonKey::HitType];
		if ($hit_type == HitType::Hit) {
			$exp = 5;
		}
		else {
			$exp = 1;
		}
		return $exp;
	}
}