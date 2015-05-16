<?php
namespace catsalad\V1\Rest\Battle;

class BattleEntity
{
	public $id;
	public $name;
	public $thumb_image_url;
	public $fullsize_image_url;
	public $activated_at;
	public $created_at;
	public $updated_at;

	public function getArrayCopy()
    {
        return array(
            BattleJsonKey::Id 		 		=> $this->id,
            BattleJsonKey::Name 			=> $this->name,
            BattleJsonKey::ThumbImageUrl    => $this->thumb_image_url,
            BattleJsonKey::FullsizeImageUrl => $this->fullsize_image_url,
            BattleJsonKey::ActivatedAt      => $this->activated_at,
            BattleJsonKey::CreatedAt      	=> $this->created_at,
            BattleJsonKey::UpdatedAt      	=> $this->updated_at,
        );
    }
 
    public function exchangeArray(array $array)
    {
    	$this->id = $array[BattleJsonKey::Id];
    	$this->name = $array[BattleJsonKey::Name];
        $this->thumb_image_url = $array[BattleJsonKey::ThumbImageUrl];
        $this->fullsize_image_url = $array[BattleJsonKey::FullsizeImageUrl];
        $this->activated_at = $array[BattleJsonKey::ActivatedAt];
    	$this->created_at = $array[BattleJsonKey::CreatedAt];
    	$this->updated_at = $array[BattleJsonKey::UpdatedAt];
    }
}
