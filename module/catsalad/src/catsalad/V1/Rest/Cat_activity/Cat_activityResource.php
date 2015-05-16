<?php
namespace catsalad\V1\Rest\Cat_activity;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

use catsalad\V1\Rest\Cat_activity\CatActivityMapper;
use catsalad\V1\Rest\Cat_activity\CatActivityJsonKey;

class Cat_activityResource extends AbstractResourceListener
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
        $routeParams = $this->getEvent()->getRouteMatch()->getParams();
        $catId = $routeParams[CatActivityJsonKey::CatId];

        $data = get_object_vars($data);
        $data[CatActivityJsonKey::CatId] = $catId;

        $connection = null;
        try {
            $dbAdapter = $this->mapper->getAdapter();
            $connection = $dbAdapter->getDriver()->getConnection();
            $connection->beginTransaction();
            
            $resultData = $this->mapper->insert($data);

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
        return new ApiProblem(405, 'The DELETE method has not been defined for individual resources');
    }

    /**
     * Delete a collection, or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function deleteList($data)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for collections');
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
            $catId = $routeParams[CatActivityJsonKey::CatId];

            $filterType = null;
            if (!empty($params[CatActivityJsonKey::Filter])) {
                $params = $params[CatActivityJsonKey::Filter];
                $strings = explode(',', $params);
                if (count($strings) < 2) {
                    return new ApiProblem(400, 'Unsatisfied request content');
                }

                $filterType = $strings[0];
                $param = $strings[1];
                $result = $this->mapper->fetchByCatIdWithParams($catId, $filterType, $param);
            }
            else {
                $result = $this->mapper->fetchByCatId($catId);
            }
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
        return new ApiProblem(405, 'The PUT method has not been defined for individual resources');
    }
}
