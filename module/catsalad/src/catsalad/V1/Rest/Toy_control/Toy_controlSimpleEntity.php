<?php
namespace catsalad\V1\Rest\Toy_control;

class Toy_controlSimpleEntity
{
	public $id;
	public $battle_id;
	public $toy_device_id;
	public $type;

	public function getArrayCopy()
    {
        return array(
            ToyControlJsonKey::Id 				=> $this->id,
            ToyControlJsonKey::ToyDeviceId 		=> $this->toy_device_id,
            ToyControlJsonKey::BattleId         => $this->battle_id,
            ToyControlJsonKey::Type             => $this->type,
        );
    }
 
    public function exchangeArray(array $array)
    {
    	$this->id = $array[ToyControlJsonKey::Id];
    	$this->battle_id = $array[ToyControlJsonKey::BattleId];
        $this->toy_device_id = $array[ToyControlJsonKey::ToyDeviceId];
    	$this->type = $array[ToyControlJsonKey::Type];
    }
}
