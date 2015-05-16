<?php
namespace catsalad\V1\Rest\Toy_device;

class Toy_deviceEntity
{
	public $id;
    public $is_enable_sound;
    public $is_use_system_recommended_time;
	public $system_recommended_time;
	public $user_scheduled_time;
    public $location;
	public $created_at;
	public $updated_at;

	public function getArrayCopy()
    {
        return array(
            ToyDeviceJsonKey::Id                            => $this->id,
            ToyDeviceJsonKey::IsEnableSound                 => $this->is_enable_sound,
            ToyDeviceJsonKey::IsUseSystemRecommendedTime    => $this->is_use_system_recommended_time,
            ToyDeviceJsonKey::SystemRecommendedTime         => $this->system_recommended_time,
            ToyDeviceJsonKey::UserScheduledTime 	        => $this->user_scheduled_time,
            ToyDeviceJsonKey::Location                      => $this->location,
            ToyDeviceJsonKey::CreatedAt 			        => $this->created_at,
            ToyDeviceJsonKey::UpdatedAt 			        => $this->updated_at
        );
    }
 
    public function exchangeArray(array $array)
    {
    	$this->id = $array[ToyDeviceJsonKey::Id];
        $this->is_enable_sound = ($array[ToyDeviceJsonKey::IsEnableSound] == intval(1)) ? true : false;
        $this->is_use_system_recommended_time = ($array[ToyDeviceJsonKey::IsUseSystemRecommendedTime] == intval(1)) ? true : false;
    	$this->system_recommended_time = $array[ToyDeviceJsonKey::SystemRecommendedTime];
    	$this->user_scheduled_time = $array[ToyDeviceJsonKey::UserScheduledTime];
        $this->location = array(
            ToyDeviceJsonKey::Latitude => ($array[ToyDeviceJsonKey::Latitude] == null) ? null : floatval($array[ToyDeviceJsonKey::Latitude]),
            ToyDeviceJsonKey::Longitude => ($array[ToyDeviceJsonKey::Longitude] == null) ? null : floatval($array[ToyDeviceJsonKey::Longitude]),
            );
    	$this->created_at = $array[ToyDeviceJsonKey::CreatedAt];
    	$this->updated_at = $array[ToyDeviceJsonKey::UpdatedAt];
    }
}
