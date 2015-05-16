<?php
namespace catsalad;

use ZF\Apigility\Provider\ApigilityProviderInterface;

use Zend\Mvc\MvcEvent;
use Zend\Mvc\ModuleRouteListener;

use catsalad\V1\Model\Context;
use catsalad\V1\Model\UserManager;
use catsalad\V1\Model\SocialProviderManager;
use catsalad\V1\Model\ToyDeviceManager;
use catsalad\V1\Model\CatManager;
use catsalad\V1\Model\WeaponManager;
use catsalad\V1\Model\BossManager;
use catsalad\V1\Model\AttackPatternManager;
use catsalad\V1\Model\BattleManager;
use catsalad\V1\Model\ToyControlManager;

class Module implements ApigilityProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'ZF\Apigility\Autoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__,
                ),
            ),
        );
    }

    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $e->getApplication()->getEventManager()->attach(
            MvcEvent::EVENT_ROUTE, function(MvcEvent $e) {
                $routeName = $e->getRouteMatch()->getParam('controller');

                if ($e->getRequest()->isGet()) {
                    $query = $e->getRequest()->getQuery();
                    if (!empty($query['content_type'])) {
                        $e->setParam('ZFContentNegotiation', 'Json');
                    }
                }
            }
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'catsalad\V1\Rest\User\UserMapper' => function ($sm) {
                    $adapter = $sm->get('Zend\Db\Adapter\Adapter');
                    return new \catsalad\V1\Rest\User\UserMapper($adapter);
                },
                'catsalad\V1\Model\UserManager' => function ($sm) {
                    $adapter = $sm->get('Zend\Db\Adapter\Adapter');
                    return new \catsalad\V1\Model\UserManager($adapter);
                },
                'catsalad\V1\Rest\Cat\CatMapper' => function ($sm) {
                    $adapter = $sm->get('Zend\Db\Adapter\Adapter');
                    return new \catsalad\V1\Rest\Cat\CatMapper($adapter);
                },
                'catsalad\V1\Model\CatManager' => function ($sm) {
                    $adapter = $sm->get('Zend\Db\Adapter\Adapter');
                    return new \catsalad\V1\Model\CatManager($adapter);
                },
                'catsalad\V1\Model\SocialProviderManager' => function ($sm) {
                    $adapter = $sm->get('Zend\Db\Adapter\Adapter');
                    return new \catsalad\V1\Model\SocialProviderManager($adapter);
                },
                'catsalad\V1\Rest\Toy_device\ToyDeviceMapper' => function ($sm) {
                    $adapter = $sm->get('Zend\Db\Adapter\Adapter');
                    return new \catsalad\V1\Rest\Toy_device\ToyDeviceMapper($adapter);
                },
                'catsalad\V1\Model\ToyDeviceManager' => function ($sm) {
                    $adapter = $sm->get('Zend\Db\Adapter\Adapter');
                    return new \catsalad\V1\Model\ToyDeviceManager($adapter);
                },
                'catsalad\V1\Rest\Cat\CatMapper' => function ($sm) {
                    $adapter = $sm->get('Zend\Db\Adapter\Adapter');
                    return new \catsalad\V1\Rest\Cat\CatMapper($adapter);
                },
                'catsalad\V1\Model\CatManager' => function ($sm) {
                    $adapter = $sm->get('Zend\Db\Adapter\Adapter');
                    return new \catsalad\V1\Model\CatManager($adapter);
                },
                'catsalad\V1\Rest\Cat_activity\CatActivityMapper' => function ($sm) {
                    $adapter = $sm->get('Zend\Db\Adapter\Adapter');
                    return new \catsalad\V1\Rest\Cat_activity\CatActivityMapper($adapter);
                },
                'catsalad\V1\Model\CatActivityManager' => function ($sm) {
                    $adapter = $sm->get('Zend\Db\Adapter\Adapter');
                    return new \catsalad\V1\Model\CatActivityManager($adapter);
                },
                'catsalad\V1\Rest\Weapon\WeaponMapper' => function ($sm) {
                    $adapter = $sm->get('Zend\Db\Adapter\Adapter');
                    return new \catsalad\V1\Rest\Weapon\WeaponMapper($adapter);
                },
                'catsalad\V1\Model\WeaponManager' => function ($sm) {
                    $adapter = $sm->get('Zend\Db\Adapter\Adapter');
                    return new \catsalad\V1\Model\WeaponManager($adapter);
                },
                'catsalad\V1\Rest\Boss\BossMapper' => function ($sm) {
                    $adapter = $sm->get('Zend\Db\Adapter\Adapter');
                    return new \catsalad\V1\Rest\Boss\BossMapper($adapter);
                },
                'catsalad\V1\Model\BossManager' => function ($sm) {
                    $adapter = $sm->get('Zend\Db\Adapter\Adapter');
                    return new \catsalad\V1\Model\BossManager($adapter);
                },
                'catsalad\V1\Rest\Attack_pattern\AttackPatternMapper' => function ($sm) {
                    $adapter = $sm->get('Zend\Db\Adapter\Adapter');
                    return new \catsalad\V1\Rest\Attack_pattern\AttackPatternMapper($adapter);
                },
                'catsalad\V1\Model\AttackPatternManager' => function ($sm) {
                    $adapter = $sm->get('Zend\Db\Adapter\Adapter');
                    return new \catsalad\V1\Model\AttackPatternManager($adapter);
                },
                'catsalad\V1\Rest\Attack_type\AttackTypeMapper' => function ($sm) {
                    $adapter = $sm->get('Zend\Db\Adapter\Adapter');
                    return new \catsalad\V1\Rest\Attack_type\AttackTypeMapper($adapter);
                },
                'catsalad\V1\Model\AttackTypeManager' => function ($sm) {
                    $adapter = $sm->get('Zend\Db\Adapter\Adapter');
                    return new \catsalad\V1\Model\AttackTypeManager($adapter);
                },
                'catsalad\V1\Rest\Battle\BattleMapper' => function ($sm) {
                    $adapter = $sm->get('Zend\Db\Adapter\Adapter');
                    return new \catsalad\V1\Rest\Battle\BattleMapper($adapter);
                },
                'catsalad\V1\Model\BattleManager' => function ($sm) {
                    $adapter = $sm->get('Zend\Db\Adapter\Adapter');
                    return new \catsalad\V1\Model\BattleManager($adapter);
                },
                'catsalad\V1\Rest\Battle_participant\BattleParticipantMapper' => function ($sm) {
                    $adapter = $sm->get('Zend\Db\Adapter\Adapter');
                    return new \catsalad\V1\Rest\Battle_participant\BattleParticipantMapper($adapter);
                },
                'catsalad\V1\Rest\Battle_activity\BattleActivityMapper' => function ($sm) {
                    $adapter = $sm->get('Zend\Db\Adapter\Adapter');
                    return new \catsalad\V1\Rest\Battle_activity\BattleActivityMapper($adapter);
                },
                'catsalad\V1\Rest\Toy_control\ToyControlMapper' => function ($sm) {
                    $adapter = $sm->get('Zend\Db\Adapter\Adapter');
                    return new \catsalad\V1\Rest\Toy_control\ToyControlMapper($adapter);
                },
                'catsalad\V1\Model\ToyControlManager' => function ($sm) {
                    $adapter = $sm->get('Zend\Db\Adapter\Adapter');
                    return new \catsalad\V1\Model\ToyControlManager($adapter);
                },
                'catsalad\V1\Rest\Cat_weapon\CatWeaponMapper' => function ($sm) {
                    $adapter = $sm->get('Zend\Db\Adapter\Adapter');
                    return new \catsalad\V1\Rest\Cat_weapon\CatWeaponMapper($adapter);
                },
                'catsalad\V1\Rest\Toydevice_user\ToydeviceUserMapper' => function ($sm) {
                    $adapter = $sm->get('Zend\Db\Adapter\Adapter');
                    return new \catsalad\V1\Rest\Toydevice_user\ToydeviceUserMapper($adapter);
                },
                'catsalad\V1\Model\Context' => function ($sm) {
                    return new \catsalad\V1\Model\Context($sm);
                },
            ),
        );
    }
}
