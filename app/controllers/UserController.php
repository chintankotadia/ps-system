<?php
use LaravelCore\Repositories\UserRepository;

/**
 * User Controller
 *
 * @package Laravel Core
 */
class UserController extends BaseController
{
    /**
     * User Repository
     *
     * @var LaravelCore\Repositoris\UserRepository
     */
    protected $user;

    /**
     * Init class construct
     *
     * @param UserRepository $user
     */
    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function getIndex()
    {
        return View::make('users/index');
    }

    public function getAdd()
    {
        return View::make('users/add_edit');
    }

    public function postSave()
    {
        $input = Input::all();
        if(!$this->user->saveUser($input)) {
            if($this->user->getMessageType() == 'validation') {
                return Redirect::back()->withErrors($this->user->getErrors())->withInput();
            } else {
                return Redirect::to('admin/user')->with('message', $this->user->getMessage());
            }
        } else {

            return Redirect::to('admin/user')->with('message', $this->user->getMessage());
        }
    }

    public function getEdit($id)
    {
        $user = $this->user->getUserById($id);
        $group = $user->groups()->first();
        return View::make('users/add_edit')->withUser($user)->withGroup($group);
    }

    public function getAjaxDatatable()
    {
        return $this->user->getDatatable();
    }

    public function getDeleteUser($id)
    {
        if($this->user->delete($id)) {
            return Response::json(['success' => true,  'message' => 'User successfully deleted.']);
        } else {
            return Response::json(['success' => false, 'message' => 'Please try again']);
        }
    }
}
