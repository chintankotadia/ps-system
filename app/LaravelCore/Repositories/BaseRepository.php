<?php namespace LaravelCore\Repositories;

use Cache, Sentry;

/**
 * Class BaseRepository
 *
 * @package PPVMaster
 */
class BaseRepository
{

    /**
     * Set base model
     *
     * @var mixed
     */
    protected $model;

    /**
     * Common Errors
     *
     * @var mixed
     */
    protected $errors;

    /**
     * Common Message
     *
     * @var mixed
     */
    protected $message;

    /**
     * Message Type
     *
     * @var mixed
     */
    protected $messageType;

    /**
     * Cache key for cache setting
     *
     * @var mixed
     */
    protected $cacheKey;

    /**
     * Get common errors
     *
     * @return mixed
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Get common message
     *
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Get common message type
     *
     * @return mixed
     */
    public function getMessageType()
    {
        return $this->messageType;
    }

    /**
     * Set common errors
     *
     * @param mixed $errors
     */
    public function setErrors($errors = '', $cacheFlush = false)
    {
        $this->errors = $errors;
        if($cacheFlush) {
            Cache::flush();
        }
    }

    /**
     * Set common message
     *
     * @param mixed $message
     */
    public function setMessage($message = '')
    {
        $this->message = $message;
    }

    /**
     * Set common message
     *
     * @param mixed $messageType
     */
    public function setMessageType($messageType = 'error')
    {
        $this->messageType = $messageType;
    }

    public function saveStatus($obj)
    {
        if($obj->isSaved()) {
            return true;
        } else {
            $this->setErrors($obj->errors());
            return false;
        }
    }

    /**
     * Set message with its type
     *
     * @param mixed $messageType
     * @param mixed $message
     */
    public function setWholeMessage($messageType, $message)
    {
        $this->setMessageType($messageType);
        $this->setMessage($message);
    }

    /**
     * Set current model
     *
     * @param mixed $model
     */
    public function setModel($model)
    {
        $this->model = $model;
    }

    /**
     * Create new row
     *
     * @param array $input
     * @return mixed
     */
    public function insert($input)
    {
        return $this->model->create($input);
    }

    /**
     * Updata rows
     *
     * @param int   $id
     * @param array $input
     * @return mixed
     */
    public function update($id, $input)
    {
        $item = $this->getById($id);
        $item->update($input);

        return $item;
    }

    /**
     * Updata rows with cache result
     *
     * @param int   $id
     * @param array $input
     * @return mixed
     */
    public function updateWithCache($id, $input)
    {
        $item = $this->model->remember(2)->findOrFail($id);
        $item->update($input);

        return $item;
    }

    /**
     * Remove element by it's id
     *
     * @param int $id
     * @return mixed
     */
    public function remove($id)
    {
        $item = $this->model->findOrFail($id);
        $item->delete();

        return $item;
    }

    /**
     * Remove element by it's slug
     *
     * @param string $slug
     * @return mixed
     */
    public function removeBySLug($slug)
    {
        $item = $this->getBySlug($slug);
        $item->delete();

        return $item;
    }

    /**
     * Get data by it's id
     *
     * @param int $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Get data by it's slug
     *
     * @param string $slug
     * @return mixed
     */
    public function getBySlug($slug)
    {
        return $this->model->where('slug', $slug)->first();
    }

    /**
     * Delete multipal row
     *
     * @param array $ids
     * @return mixed
     */
    public function removeMultipal($ids)
    {
        return $this->model->destroy($ids);
    }

    /**
     * Set cache key
     *
     * @param string $key
     */
    public function setCacheKey($key)
    {
        $this->cacheKey = $key;
    }

    /**
     * Get cache result
     *
     * @return boolean | mixed
     */
    public function getCacheResult()
    {
        if (Cache::has($this->cacheKey)) {
            return Cache::get($this->cacheKey);
        } else {
            return false;
        }
    }

    /**
     * Set Cache Key
     *
     * @param mixed $result
     * @param int $time
     */
    public function setCacheResult($result, $time = 1)
    {
        Cache::put($this->cacheKey, $result, $time);
    }

    /**
     * Clear cache result
     *
     * @param type $key
     */
    public function removeCacheResult($key = '')
    {
        if(!$key) {
            $key = $this->cacheKey;
        }
        Cache::forget($key);
    }

    /**
     * Check user have parmission
     *
     * @param int $id
     * @return boolean
     */
    public function hasAccess($id)
    {
        $user   = Sentry::getUser();
        $item   = $this->getById($id);

        if($user->id == $item->user_id) {

            return true;
        } else {

            return false;
        }
    }

    /**
     * Check user have parmission by slug
     *
     * @param string $slug
     * @return boolean
     */
    public function hasAccessBySlug($slug)
    {
        $user   = Sentry::getUser();
        $item   = $this->getBySlug($slug);

        if($item && $user->id == $item->user_id) {

            return true;
        } else {

            return false;
        }
    }

    /**
     * Insert multiple record
     *
     * @param array $input
     * @return type
     */
    public function insertMultipal($input)
    {
        return $this->model->insert($input);
    }

    /**
     * Count rows
     *
     * @param mixed $field
     * @param mixed $value
     */
    public function count($field, $value)
    {
        return $this->model->where($field, $value)->count();
    }
}