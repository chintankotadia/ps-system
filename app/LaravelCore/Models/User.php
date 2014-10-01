<?php namespace LaravelCore\Models;

use Magniloquent\Magniloquent\Magniloquent;

/**
 * Class User
 *
 * @package LaravelCore
 */
class User extends Magniloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The unique database key
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * User full name
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function userGroups()
    {
        return $this->belongsToMany('LaravelCore\Models\Group', 'users_groups');
    }
}