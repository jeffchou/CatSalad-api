<?php
namespace catsalad\V1\Rest\Social_provider;

class Social_providerEntity
{
	public $social_provider_name;
	public $social_user_id;

	public function getArrayCopy()
    {
        return array(
            SocialProviderJsonKey::Id 		 			=> $this->id,
            SocialProviderJsonKey::SocialProviderName 	=> $this->social_provider_name,
            SocialProviderJsonKey::UserId 				=> $this->social_user_id,
        );
    }
 
    public function exchangeArray(array $array)
    {
    	$this->id = $array[SocialProviderJsonKey::Id];
    	$this->social_provider_name = $array[SocialProviderJsonKey::SocialProviderName];
    	$this->social_user_id = $array[SocialProviderJsonKey::UserId];
    }
}
