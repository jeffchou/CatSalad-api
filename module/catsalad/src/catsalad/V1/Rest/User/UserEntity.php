<?php
namespace catsalad\V1\Rest\User;

use catsalad\V1\Rest\Toy_device\Toy_deviceEntity;

use catsalad\V1\Rest\Cat\CatJsonKey;

class UserEntity
{
	public $id;
	public $name;
	public $device_token;
	public $access_token;
	public $social_provider;
    public $toy_device;
    public $cat;
	public $created_at;
	public $updated_at;

	public function getArrayCopy()
    {
        $result = array(
            UserJsonKey::Id 				=> $this->id,
            UserJsonKey::Name 				=> $this->name,
            UserJsonKey::DeviceToken 		=> $this->device_token,
            UserJsonKey::AccessToken 		=> $this->access_token,
            UserJsonKey::SocialProvider 	=> $this->social_provider,
            UserJsonKey::ToyDevice          => $this->toy_device,
            UserJsonKey::Cat                => $this->cat,
            UserJsonKey::CreatedAt 			=> $this->created_at,
            UserJsonKey::UpdatedAt 			=> $this->updated_at
        );
        if (empty($this->toy_device)) {
            unset($result[UserJsonKey::ToyDevice]);
        }
        if (empty($this->cat)) {
            unset($result[UserJsonKey::Cat]);
        }
        return $result;
    }
 
    public function exchangeArray(array $array)
    {
    	$this->id = $array[UserJsonKey::Id];
    	$this->name = $array[UserJsonKey::Name];
    	$this->device_token = $array[UserJsonKey::DeviceToken];
    	$this->access_token = $array[UserJsonKey::AccessToken];
    	$this->social_provider = $array[UserJsonKey::SocialProvider];
        if (!empty($array[UserJsonKey::ToyDevice])) {
            $this->toy_device = $array[UserJsonKey::ToyDevice];
        }
        if (!empty($array[CatJsonKey::Cat])) {
            $this->cat = $array[UserJsonKey::Cat];
        }
    	$this->created_at = $array[UserJsonKey::CreatedAt];
    	$this->updated_at = $array[UserJsonKey::UpdatedAt];
    }
}
