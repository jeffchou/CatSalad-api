<?php
namespace catsalad\V1\Rest\Toydevice_user;

class Toydevice_userEntity
{
	public $id;
	public $name;
    public $cat_id;
	public $created_at;
	public $updated_at;

	public function getArrayCopy()
    {
        $result = array(
            ToydeviceUserJsonKey::Id 				=> $this->id,
            ToydeviceUserJsonKey::Name 				=> $this->name,
            ToydeviceUserJsonKey::CatId             => $this->cat_id,
            ToydeviceUserJsonKey::CreatedAt 		=> $this->created_at,
            ToydeviceUserJsonKey::UpdatedAt 		=> $this->updated_at
        );
        if (empty($this->cat_id)) {
            unset($result[ToydeviceUserJsonKey::CatId]);
        }
        return $result;
    }
 
    public function exchangeArray(array $array)
    {
    	$this->id = $array[ToydeviceUserJsonKey::Id];
    	$this->name = $array[ToydeviceUserJsonKey::Name];
        if (!empty($array[ToydeviceUserJsonKey::CatId])) {
            $this->cat_id = $array[ToydeviceUserJsonKey::CatId];
        }
    	$this->created_at = $array[ToydeviceUserJsonKey::CreatedAt];
    	$this->updated_at = $array[ToydeviceUserJsonKey::UpdatedAt];
    }
}
