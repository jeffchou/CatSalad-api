<?php
namespace catsalad\V1\Rest\Battle_participant;

use catsalad\V1\Rest\Cat\CatJsonKey;

class Battle_participantEntity
{
	public $id;
	public $name;
	public $gender;
    public $birthday;
    public $location;
	public $lvl;
	public $exp;
    public $score;
    public $rank;
	public $image_url;
	public $created_at;
	public $updated_at;

	public function getArrayCopy()
    {
        return array(
            CatJsonKey::Id 				 	=> $this->id,
            CatJsonKey::Name 				=> $this->name,
            CatJsonKey::Gender 			 	=> $this->gender,
            CatJsonKey::Birthday            => $this->birthday,
            CatJsonKey::Location            => $this->location,
            CatJsonKey::LVL 			 	=> $this->lvl,
            CatJsonKey::Exp 			 	=> $this->exp,
            CatJsonKey::Score               => $this->score,
            BattleParticipantJsonKey::Rank  => $this->rank,
            CatJsonKey::ImageUrl 			=> $this->image_url,
            CatJsonKey::CreatedAt 			=> $this->created_at,
            CatJsonKey::UpdatedAt 			=> $this->updated_at
        );
    }
 
    public function exchangeArray(array $array)
    {
    	$this->id = $array[CatJsonKey::Id];
    	$this->name = $array[CatJsonKey::Name];
    	$this->gender = $array[CatJsonKey::Gender];
        $this->birthday = $array[CatJsonKey::Birthday];
        $this->location = array(
            CatJsonKey::Latitude => ($array[CatJsonKey::Latitude] == null) ? null : floatval($array[CatJsonKey::Latitude]),
            CatJsonKey::Longitude => ($array[CatJsonKey::Longitude] == null) ? null : floatval($array[CatJsonKey::Longitude]),
            );
    	$this->lvl = $array[CatJsonKey::LVL];
    	$this->exp = $array[CatJsonKey::Exp];
        $this->score = $array[CatJsonKey::Score];
        $this->rank = $array[BattleParticipantJsonKey::Rank];
    	$this->image_url = $array[CatJsonKey::ImageUrl];
    	$this->created_at = $array[CatJsonKey::CreatedAt];
    	$this->updated_at = $array[CatJsonKey::UpdatedAt];
    }
}