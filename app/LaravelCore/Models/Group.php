<?php namespace LaravelCore\Models;

use Magniloquent\Magniloquent\Magniloquent;

/**
 * Class User
 *
 * @package LaravelCore
 */
class Group extends Magniloquent
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'groups';

    /**
     * The unique database key
     *
     * @var string
     */
    protected $primaryKey = 'id';
}