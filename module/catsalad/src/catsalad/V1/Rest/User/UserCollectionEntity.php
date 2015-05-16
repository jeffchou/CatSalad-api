<?php
namespace catsalad\V1\Rest\User;

use catsalad\V1\Rest\Cat\CatEntity;

use catsalad\V1\Rest\Toy_device\ToyDeviceJsonKey;
use catsalad\V1\Rest\Cat\CatJsonKey;

class UserCollectionEntity
{
	public $id;
	public $name;
	public $created_at;
	public $updated_at;

	public function getArrayCopy()
    {
        return array(
            UserJsonKey::Id 				=> $this->id,
            UserJsonKey::Name 				=> $this->name,
            UserJsonKey::Cat                => $this->cat,
            UserJsonKey::CreatedAt 			=> $this->created_at,
            UserJsonKey::UpdatedAt 			=> $this->updated_at
        );
    }
 
    public function exchangeArray(array $array)
    {
    	$this->id = $array[UserJsonKey::Id];
    	$this->name = $array[UserJsonKey::Name];
        
        // if (!empty($array[UserJsonKey::ToyId])) {
        //     $this->toy_device = array(
        //         ToyDeviceJsonKey::Id => $array[UserJsonKey::ToyId],
        //         ToyDeviceJsonKey::SystemRecommendedTime => $array[ToyDeviceJsonKey::SystemRecommendedTime],
        //         ToyDeviceJsonKey::UserScheduledTime => $array[ToyDeviceJsonKey::UserScheduledTime],
        //         ToyDeviceJsonKey::Location => array(
        //             ToyDeviceJsonKey::Latitude => ($array[ToyDeviceJsonKey::Latitude] == null) ? null : floatval($array[ToyDeviceJsonKey::Latitude]),
        //             ToyDeviceJsonKey::Longitude => ($array[ToyDeviceJsonKey::Longitude] == null) ? null : floatval($array[ToyDeviceJsonKey::Longitude]),
        //             ),
        //         ToyDeviceJsonKey::CreatedAt => $array[UserJsonKey::ToyCreatedAt],
        //         ToyDeviceJsonKey::UpdatedAt => $array[UserJsonKey::ToyUpdatedAt],
        //     );
        // }
        if (!empty($array[UserJsonKey::CatId])) {
            $catResult = array(
                CatJsonKey::Id => $array[UserJsonKey::CatId],
                CatJsonKey::Name => $array[UserJsonKey::CatName],
                CatJsonKey::Gender => $array[CatJsonKey::Gender],
                CatJsonKey::Birthday => $array[CatJsonKey::Birthday],
                CatJsonKey::EquippedWeaponId => $array[CatJsonKey::EquippedWeaponId],
                CatJsonKey::Latitude => ($array[ToyDeviceJsonKey::CatLatitude] == null) ? null : floatval($array[ToyDeviceJsonKey::CatLatitude]),
                CatJsonKey::Longitude => ($array[ToyDeviceJsonKey::CatLongitude] == null) ? null : floatval($array[ToyDeviceJsonKey::CatLongitude]),
                CatJsonKey::LVL => $array[CatJsonKey::LVL],
                CatJsonKey::Exp => $array[CatJsonKey::Exp],
                CatJsonKey::ImageUrl => $array[CatJsonKey::ImageUrl],
                CatJsonKey::CreatedAt => $array[UserJsonKey::CatCreatedAt],
                CatJsonKey::UpdatedAt => $array[UserJsonKey::CatUpdatedAt],
            );
            $this->cat = new CatEntity();
            $this->cat->exchangeArray($catResult);
        }
    	$this->created_at = $array[UserJsonKey::CreatedAt];
    	$this->updated_at = $array[UserJsonKey::UpdatedAt];
    }
}