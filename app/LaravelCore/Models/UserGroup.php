<?php namespace LaravelCore\Models;

use Magniloquent\Magniloquent\Magniloquent;

/**
 * Class User
 *
 * @package LaravelCore
 */
class UserGroup extends Magniloquent
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users_groups';

    /**
     * The unique database key
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     */
    protected static $relationships = array(
        'group' => array('belongsTo', 'PPVMaster\Models\Group', 'group_id')
    );
}