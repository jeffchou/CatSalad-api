<?php
namespace catsalad\V1\Rest\User;

use ZF\ApiProblem\ApiProblem;

use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Paginator\Adapter\DbSelect;

use Facebook\FacebookSession;

use catsalad\V1\Exception\ResourceNotFoundException;
use catsalad\V1\Exception\AccessTokenExpiredException;

use catsalad\V1\Model\Context;

use catsalad\V1\Rest\User\UserCollectionEntity;
use catsalad\V1\Rest\Social_provider\SocialProviderJsonKey;
use catsalad\V1\Rest\Toy_device\Toy_deviceEntity;
use catsalad\V1\Rest\Toy_device\ToyDeviceJsonKey;
use catsalad\V1\Rest\Cat\CatEntity;

use catsalad\V1\Rest\Cat\CatJsonKey;

use catsalad\V1\Utility\DateTimeHelper;

class UserMapper
{
	protected $context;
	protected $adapter;

    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    public function setContext($context)
    {
    	$this->context = $context;
    }

    public function getContext()
    {
    	return $this->context;
    }

 	public function getAdapter()
 	{
 		return $this->adapter;
 	}

    public function fetchAll()
    {
    	$sql = new Sql($this->adapter);
    	$select = $sql->select();
    	$select->from('user');

        $resultSetPrototype = new ResultSet();

        $paginatorAdapter = new UserCollectionDbSelect($select, $this->adapter, $resultSetPrototype);
        $paginatorAdapter->setContext($this->context);
		$collection = new UserCollection($paginatorAdapter);
        return $collection;
    }

    public function fetch($id)
    {
    	$userManager = $this->context->getUserManager();
    	$result = $userManager->findById($id);
       	if ($result == null) {
       		throw new ResourceNotFoundException($id);
       		return null;
       	}

		// find social provider
		$socialProviderManager = $this->context->getSocialProviderManager();
		$socialResultSet = $socialProviderManager->findByUserId($id);
		if ($socialResultSet != null) {
			$result[UserJsonKey::SocialProvider] = $socialResultSet[0];
		}

        // find toy devices
        $toyDeviceMapper = $this->context->getToyDeviceMapper();
        $result[UserJsonKey::ToyDevice] = $toyDeviceMapper->fetchByUserId($id);

        // find cats
        $catMapper = $this->context->getCatMapper();
        $result[UserJsonKey::Cat] = $catMapper->fetchByUserId($id);

        $entity = new UserEntity();
        $entity->exchangeArray($result);

        return $entity;
    }

    public function insert($data)
    {
    	// Request Facebook Long-lived token
   		try {
   			FacebookSession::setDefaultApplication('549974551771483', 'ab25a022a887d979ff96379f3eb89cc8');
			$session = new FacebookSession($data[SocialProviderJsonKey::AccessToken]);
			$session = $session->getLongLivedSession('549974551771483', 'ab25a022a887d979ff96379f3eb89cc8');

		} catch (FacebookRequestException $ex) {
		  	throw $ex;
		  	return null;

		} catch (\Exception $ex) {
			throw new AccessTokenExpiredException();
			return null;
		}

		// Found out the user is registered
		$socialUserId = $data[SocialProviderJsonKey::SocialUserId];
    	$socialProviderManager = $this->context->getSocialProviderManager();
    	$foundSocialUser = $socialProviderManager->findBySocialUserId($socialUserId);
    	if ($foundSocialUser != null) {
    		return $this->fetch($foundSocialUser[SocialProviderJsonKey::UserId]);
    	}

		// Insert user
		$userManager = $this->context->getUserManager();
    	$user = $userManager->insert($data);
    	if ($user == null) {
    		throw new \Exception("Insert user resource failed.");
			return null;
    	}

		// Insert social provider
    	$socialProvider = $socialProviderManager->insertByUser($user, $data);
		if ($socialProvider == null) {
    		throw new \Exception("Insert social provider resource failed.");
			return null;
    	}

    	// Insert toy device
    	$toyDeviceManager = $this->context->getToyDeviceManager();
    	$toyDevice = $toyDeviceManager->insertByUser($user, $data);
    	if ($toyDevice == null) {
    		throw new \Exception("Insert toy device resource failed.");
			return null;
    	}

        // Insert cat
        $catManager = $this->context->getCatManager();
        $cat = $catManager->insertByUser($user, $data);
        if ($cat == null) {
            throw new \Exception("Insert cat resource failed.");
            return null;
        }

        return $this->fetch($user[UserJsonKey::Id]);
    }

    public function update($id, $data)
    {
    	$userManager = $this->context->getUserManager();
    	$user = $userManager->update($id, $data);
       	if ($user == null) {
       		throw new ResourceNotFoundException($id);
       		return null;
       	}
        return $this->fetch($id);
    }

    public function delete($id)
    {
    	$userManager = $this->context->getUserManager();
    	return $userManager->delete($id);
    }
}