<?php
namespace catsalad\V1\Rest\Toy_control;

class Toy_controlEntity
{
	public $id;
	public $battle_id;
	public $toy_device_id;
	public $type;
	public $is_done;
	public $created_at;
	public $updated_at;

	public function getArrayCopy()
    {
        return array(
            ToyControlJsonKey::Id 				=> $this->id,
            ToyControlJsonKey::ToyDeviceId 		=> $this->toy_device_id,
            ToyControlJsonKey::BattleId         => $this->battle_id,
            ToyControlJsonKey::Type             => $this->type,
            ToyControlJsonKey::IsDone           => $this->is_done,
            ToyControlJsonKey::CreatedAt 		=> $this->created_at,
            ToyControlJsonKey::UpdatedAt 		=> $this->updated_at
        );
    }
 
    public function exchangeArray(array $array)
    {
    	$this->id = $array[ToyControlJsonKey::Id];
    	$this->battle_id = $array[ToyControlJsonKey::BattleId];
        $this->toy_device_id = $array[ToyControlJsonKey::ToyDeviceId];
    	$this->type = $array[ToyControlJsonKey::Type];
    	$this->is_done = ($array[ToyControlJsonKey::IsDone] == intval(1)) ? true : false;
    	$this->created_at = $array[ToyControlJsonKey::CreatedAt];
    	$this->updated_at = $array[ToyControlJsonKey::UpdatedAt];
    }
}
