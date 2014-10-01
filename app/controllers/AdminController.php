<?php
use LaravelCore\Repositories\UserRepository;

/**
 * Admin Controller
 *
 * @package Laravel Core
 */
class AdminController extends BaseController
{
    /**
     * User Repository
     *
     * @var LaravelCore\Repositoris\UserRepository
     */
    protected $user;


    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function getIndex()
    {
        return View::make('admins/index');
    }
}
