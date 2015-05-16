<?php
namespace catsalad\V1\Rest\User;

use Zend\Paginator\Adapter\DbSelect;

class UserCollectionDbSelect extends DbSelect
{
	protected $context;
 
    public function setContext($context)
    {
        $this->context = $context;
    }

	public function getItems($offset, $itemCountPerPage)
	{
		$mainSelect = clone $this->select;
        $mainSelect->offset($offset);
        $mainSelect->limit($itemCountPerPage);

        $statement = $this->sql->prepareStatementForSqlObject($mainSelect);
        $result    = $statement->execute();

        $resultSet = clone $this->resultSetPrototype;
        $resultSet->initialize($result);

        $socialProviderManager = $this->context->getSocialProviderManager();
        $toyDeviceMapper = $this->context->getToyDeviceMapper();
        $catMapper = $this->context->getCatMapper();

		$mainResultArray = $resultSet->toArray();
		foreach ($mainResultArray as $key => $user) {
			$userId = $user[UserJsonKey::Id];
	    	
	    	// find social provider
			$socialProviderManager = $this->context->getSocialProviderManager();
			$socialResultSet = $socialProviderManager->findByUserId($userId);
			if ($socialResultSet != null) {
				$mainResultArray[$key][UserJsonKey::SocialProvider] = $socialResultSet[0];
			}

	        // find toy devices
	        $mainResultArray[$key][UserJsonKey::ToyDevice] = $toyDeviceMapper->fetchByUserId($userId);

	        // find cats
	        $mainResultArray[$key][UserJsonKey::Cat] = $catMapper->fetchByUserId($userId);
		}

        return $mainResultArray;
	}
}