<?php
namespace catsalad\V1\Rest\Cat;

use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;
use ZF\Rest\AbstractResourceListener;

use catsalad\V1\Rest\Cat\CatJsonKey;
use catsalad\V1\Validator\FloatValue;

class CatResource extends AbstractResourceListener
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
        // $data = get_object_vars($data);
        // if (empty($data[CatJsonKey::Name])) {
        //     return new ApiProblem(400, 'Unsatisfied request content');
        // }

        // $connection = null;
        // try {
        //     $dbAdapter = $this->mapper->getAdapter();
        //     $connection = $dbAdapter->getDriver()->getConnection();
        //     $connection->beginTransaction();
            
        //     $resultData = $this->mapper->insert($data);

        //     $connection->commit();
        // }
        // catch (\Exception $e) {
        //     if ($connection instanceof \Zend\Db\Adapter\Driver\ConnectionInterface) {
        //         $connection->rollback();
        //     }

        //     $errorMsg = sprintf("Service cannot accomplish this request with exception message (%s)", $e->getMessage());
        //     return new ApiProblem(500, $errorMsg);
        // }
        // return $resultData;
        return new ApiProblem(405, 'The POST method has not been defined');
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        try {
            $this->mapper->delete($id);
        }
        catch (ResourceNotFoundException $e) {
            return new ApiProblem(404, $e->getMessage());
        }
        catch (\Exception $e) {
            return new ApiProblem(500, $e->getMessage());
        }
        return true;
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
            $type = null;
            $params = $this->getEvent()->getQueryParams()->toArray();
            if (!empty($params[CatJsonKey::Type])) {
                $type = $params[CatJsonKey::Type];
            }
            
            $result = $this->mapper->fetchByType($id, $type);
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
            $result = $this->mapper->fetchAll();
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
        $data = get_object_vars($data);

        // Not modify the id
        unset($data[CatJsonKey::Id]);
        unset($data[CatJsonKey::LVL]);
        unset($data[CatJsonKey::Exp]);
        unset($data[CatJsonKey::Score]);
        unset($data[CatJsonKey::CreatedAt]);
        unset($data[CatJsonKey::UpdatedAt]);

        $location = $data[CatJsonKey::Location];
        $data[CatJsonKey::Latitude] = $location[CatJsonKey::Latitude];
        $data[CatJsonKey::Longitude] = $location[CatJsonKey::Longitude];
        unset($data[CatJsonKey::Location]);

        $floatValidator = new FloatValue();
        if (!$floatValidator->isValid($data[CatJsonKey::Latitude])) {
            return new ApiProblemResponse(
                new ApiProblem(422, 'Failed Validation', null, null, array(
                    'validation_messages' => $floatValidator->getMessages(),
                ))
            );
        }
        if (!$floatValidator->isValid($data[CatJsonKey::Longitude])) {
            return new ApiProblemResponse(
                new ApiProblem(422, 'Failed Validation', null, null, array(
                    'validation_messages' => $floatValidator->getMessages(),
                ))
            );
        }

        try {
            $result = $this->mapper->update($id, $data);
        }
        catch (ResourceNotFoundException $e) {
            return new ApiProblem(404, $e->getMessage());
        }
        catch (\Exception $e) {
            return new ApiProblem(500, $e->getMessage());
        }
        return $result;
    }
}
