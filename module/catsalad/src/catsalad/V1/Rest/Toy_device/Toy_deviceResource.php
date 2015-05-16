<?php
namespace catsalad\V1\Rest\Toy_device;

use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;
use ZF\Rest\AbstractResourceListener;

use catsalad\V1\Exception\ResourceNotFoundException;
use catsalad\V1\Exception\AccessTokenExpiredException;

use catsalad\V1\Rest\Toy_device\ToyDeviceJsonKey;

use catsalad\V1\Validator\FloatValue;

class Toy_deviceResource extends AbstractResourceListener
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
        unset($data[ToyDeviceJsonKey::Id]);
        unset($data[ToyDeviceJsonKey::DeviceId]);
        unset($data[ToyDeviceJsonKey::UserId]);
        unset($data[ToyDeviceJsonKey::SystemRecommendedTime]);
        unset($data[ToyDeviceJsonKey::CreatedAt]);
        unset($data[ToyDeviceJsonKey::UpdatedAt]);

        $location = $data[ToyDeviceJsonKey::Location];
        $data[ToyDeviceJsonKey::Latitude] = $location[ToyDeviceJsonKey::Latitude];
        $data[ToyDeviceJsonKey::Longitude] = $location[ToyDeviceJsonKey::Longitude];
        unset($data[ToyDeviceJsonKey::Location]);
        
        $floatValidator = new FloatValue();
        if (!$floatValidator->isValid($data[ToyDeviceJsonKey::Latitude])) {
            return new ApiProblemResponse(
                new ApiProblem(422, 'Failed Validation', null, null, array(
                    'validation_messages' => $floatValidator->getMessages(),
                ))
            );
        }
        if (!$floatValidator->isValid($data[ToyDeviceJsonKey::Longitude])) {
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
