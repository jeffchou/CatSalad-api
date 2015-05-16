<?php
namespace catsalad\V1\Rest\Boss;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

class BossResource extends AbstractResourceListener
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
        // TODO: Auth admin role

        $data = get_object_vars($data);

        if (empty($data[BossJsonKey::Name]) ||
            empty($data[BossJsonKey::Hp]) ||
            empty($data[BossJsonKey::Description]) ||
            empty($data[BossJsonKey::ImageUrl]) ||
            empty($data[BossJsonKey::SpawnTime]) ||
            empty($data[BossJsonKey::AttackPattern])) {

            return new ApiProblem(400, 'Unsatisfied request content');
        }

        $connection = null;
        try {
            $dbAdapter = $this->mapper->getAdapter();
            $connection = $dbAdapter->getDriver()->getConnection();
            $connection->beginTransaction();
            
            $resultData = $this->mapper->insert($data);

            $connection->commit();
        }
        catch (AccessTokenExpiredException $e) {
            if ($connection instanceof \Zend\Db\Adapter\Driver\ConnectionInterface) {
                $connection->rollback();
            }
            return new ApiProblem(403, $e->getMessage());
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
            if (!empty($params[BossJsonKey::Type])) {
                $type = $params[BossJsonKey::Type];
                if ($type == BossQueryType::Candidate) {
                    $result = $this->mapper->fetchBossCandidate();
                }
            }
            else {
                $result = $this->mapper->fetchAll();
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
        // TODO: Auth admin role

        $data = get_object_vars($data);

        // Not modify the id
        unset($data[BossJsonKey::Id]);
        unset($data[BossJsonKey::CreatedAt]);
        unset($data[BossJsonKey::UpdatedAt]);

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
