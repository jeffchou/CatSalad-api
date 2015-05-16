<?php
namespace catsalad\V1\Rest\Toy_control;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

class Toy_controlResource extends AbstractResourceListener
{
    protected $mapper;
 
    public function __construct($mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        $connection = null;
        try {
            $routeParams = $this->getEvent()->getRouteMatch()->getParams();
            $battleId = $routeParams[ToyControlJsonKey::BattleId];
            $toyDeviceId = $routeParams[ToyControlJsonKey::ToyDeviceId];

            $dbAdapter = $this->mapper->getAdapter();
            $connection = $dbAdapter->getDriver()->getConnection();
            $connection->beginTransaction();
            
            $data = get_object_vars($data);
            $resultData = $this->mapper->insert($battleId, $toyDeviceId, $data);

            $connection->commit();
        }
        catch (\Exception $e) {
            if ($connection instanceof \Zend\Db\Adapter\Driver\ConnectionInterface) {
                $connection->rollback();
            }

            $errorMsg = sprintf("Service cannot accomplish this request with exception message (%s)", $e->getMessage());
            return new ApiProblem(500, $errorMsg);
        }
        return $resultData;
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        return $this->mapper->delete($id);
    }

    /**
     * Delete a collection, or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function deleteList($data)
    {
        $routeParams = $this->getEvent()->getRouteMatch()->getParams();
        $toyDeviceId = $routeParams[ToyControlJsonKey::ToyDeviceId];

        return $this->mapper->deleteAllByDeviceId($toyDeviceId);
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        try {
            $result = $this->mapper->fetch($id);
        }
        catch (ResourceNotFoundException $e) {
            return new ApiProblem(404, $e->getMessage());
        }
        catch (\Exception $e) {
            return new ApiProblem(500, $e->getMessage());
        }
        return $result;
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = array())
    {
        try {
            $routeParams = $this->getEvent()->getRouteMatch()->getParams();
            $battleId = $routeParams[ToyControlJsonKey::BattleId];
            $toyDeviceId = $routeParams[ToyControlJsonKey::ToyDeviceId];

            $result = $this->mapper->findByBattleId_ToyDeviceId($battleId, $toyDeviceId, $params);
        }
        catch (\Exception $e) {
            return new ApiProblem(500, $e->getMessage());
        }
        return $result;
    }

    /**
     * Patch (partial in-place update) a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patch($id, $data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for individual resources');
    }

    /**
     * Replace a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function replaceList($data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for collections');
    }

    /**
     * Update a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function update($id, $data)
    {
        $connection = null;
        try {
            $dbAdapter = $this->mapper->getAdapter();
            $connection = $dbAdapter->getDriver()->getConnection();
            $connection->beginTransaction();
            
            $data = get_object_vars($data);
            $resultData = $this->mapper->update($id, $data);

            $connection->commit();
        }
        catch (\Exception $e) {
            if ($connection instanceof \Zend\Db\Adapter\Driver\ConnectionInterface) {
                $connection->rollback();
            }

            $errorMsg = sprintf("Service cannot accomplish this request with exception message (%s)", $e->getMessage());
            return new ApiProblem(500, $errorMsg);
        }
        return $resultData;
    }
}
