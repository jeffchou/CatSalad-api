<?php
namespace catsalad\V1\Rest\Cat_activity;

use catsalad\V1\Rest\Cat_activity\CatActivityJsonKey;
use catsalad\V1\Rest\Cat\CatJsonKey;
use catsalad\V1\Rest\Weapon\WeaponJsonKey;

class ScoreCalculator
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
	 * Calculate the activity score.
	 *
	 * @param cat_activity the cat activity that will be calcualated.
	 *
	 * @return the final score.
	 */
	public function score($cat_activity)
	{
		$catManager = $this->context->getCatManager();
		$cat = $catManager->findById($cat_activity[CatActivityJsonKey::CatId]);
		
		$weaponManager = $this->context->getWeaponManager();
		$weapon = $weaponManager->findById($cat[CatJsonKey::EquippedWeaponId]);;

		// score = experience * attack_bonus * 10
		// $hit_strength = floatval($cat_activity[CatActivityJsonKey::HitStrength]);
		$exp = intval($cat_activity[CatActivityJsonKey::Exp]);
		$attack_bonus = intval($weapon[WeaponJsonKey::AttackBonus]);
		$score = $exp * 10 * $attack_bonus;

		return $score;
	}
}