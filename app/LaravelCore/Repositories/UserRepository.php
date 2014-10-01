<?php namespace LaravelCore\Repositories;

use LaravelCore\Repositories\BaseRepository;
use LaravelCore\Models\User;
use Datatables, Sentry, Validator;

/**
 * Class UserRepository
 *
 * @package LaravelCore
 */
class UserRepository extends BaseRepository
{
    /**
     * User Model
     *
     * @var PPVMaster\Models\User
     */
    protected $user;

    /**
     * Class constructor
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user     = $user;
    }

    /**
     * Get datatable view
     *
     * @return Datatable
     */
    public function getDatatable()
    {
        $columns = ['users.id', 'users.first_name', 'users.last_name', 'users.email', 'groups.name', 'users.created_at', 'users.activated'];
        $users = $this->user->leftJoin('users_groups', 'users.id', '=', 'users_groups.user_id')->leftJoin('groups', 'users_groups.group_id', '=', 'groups.id')->groupBy('users.id')->select($columns);

        return Datatables::of($users)
                    ->edit_column('id','{{ Form::checkbox("checked", 1, "", ["class" => "icheck"]); }}')
                    ->edit_column('first_name', '{{ $first_name." ".$last_name}}')
                    ->edit_column('email', '{{ $email}}' )
                    ->edit_column('created_at', '{{ $created_at }}')
                    ->edit_column('activated', '@if($activated) <span type="button" class="btn btn-success btn-circle" data-toggle="tooltip" title="Active"><i class="fa fa-check"></i></span> @else <span type="button" class="btn btn-danger btn-circle" data-toggle="tooltip" title="Inactive"><i class="fa fa-times"></i></span> @endif')
                    ->add_column('action', '<a href="{{ URL::to(\'admin/user/edit/\'.$id) }}" class="btn btn-primary btn-xs edit-user" data-rel="{{ $id }}" data-toggle="tooltip" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;<a href="#" class="btn btn-danger btn-xs delete-user" data-rel="{{ $id }}" data-toggle="tooltip" title="Remove"><i class="glyphicon glyphicon-remove"></i></a>')
                    ->remove_column('last_name')
                    ->make();
    }

    /**
     * Get datatable view
     *
     * @return Datatable
     */
    public function getUserDatatable()
    {
        $columns = ['users.id', 'users.first_name', 'users.last_name', 'users.email', 'groups.name'];
        $users = $this->user->leftJoin('users_groups', 'users.id', '=', 'users_groups.user_id')->leftJoin('groups', 'users_groups.group_id', '=', 'groups.id')->groupBy('users.id')->select($columns);

        return Datatables::of($users)
                    ->edit_column('first_name', '{{ $first_name." ".$last_name}}')
                    ->edit_column('email', '{{ $email}}' )
                    ->add_column('action', '{{ Form::open(["class" => "form-horizontal", "url" => URL::to("user/admin-user")])}} {{ Form::hidden("user_id", $id) }}  <button type="submit" class="btn btn-success btn-ls">Login</button> {{ Form::close() }}')
                    ->remove_column('last_name')
                    ->remove_column('id')
                    ->make();
    }

    /**
     * Save or update user
     *
     * @param array $input
     * @return array
     */
    public function saveUser($input)
    {
        $message = '';
        if(empty($input['id'])) {
            $rules = [
                'first_name'    => 'required|min:2',
                'last_name'     => 'required|min:2',
                'email'         => 'required|email|unique:users',
                'password'      => 'required|min:3|confirmed'
            ];

            $validator = Validator::make($input, $rules);

            if ($validator->fails()) {
                $this->setMessageType('validation');
                $this->setErrors($validator->messages());

                return false;
            }

            try {
                // Create the user
                $user = Sentry::createUser(array(
                    'first_name'    => $input['first_name'],
                    'last_name'     => $input['last_name'],
                    'email'         => $input['email'],
                    'password'      => $input['password'],
                    'activated'     => true
                ));

                // Find the group using the group id
                $userGroup = Sentry::findGroupById($input['user_group']);

                // Assign the group to the user
                $user->addGroup($userGroup);
                $this->setWholeMessage('success', 'You have created user successfully!');

                return true;

            } catch (Cartalyst\Sentry\Users\LoginRequiredException $e) {
                $message = 'Login field is required.';
            } catch (Cartalyst\Sentry\Users\PasswordRequiredException $e) {
                $message = 'Password field is required.';
            } catch (Cartalyst\Sentry\Users\UserExistsException $e) {
                $message = 'User with this login already exists.';
            } catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e) {
                $message = 'Group was not found.';
            }

            $this->setWholeMessage('error', $message);

            return false;
        }
        else {
            $rules = [
                'first_name'    => 'required|min:2',
                'last_name'     => 'required|min:2',
                'email'         => 'required|email|unique:users,email,'.$input['id']
            ];

            $validator = Validator::make($input, $rules);

            if ($validator->fails()) {
                $this->setErrors($validator->messages());

                return false;
            }

            try {
                // Find the user using the user id
                $user = Sentry::findUserById($input['id']);

                // Update the user details
                $user->email        = $input['email'];
                $user->first_name   = $input['first_name'];
                $user->last_name    = $input['last_name'];

                // Update the user
                if ($user->save()) {
                    $oldGroupId = $user->groups()->first()->id;
                    if ($oldGroupId != $input['user_group']) {

                        $removeGroup = Sentry::findGroupById($oldGroupId);
                        $user->removeGroup($removeGroup);

                        // Find the group using the group id
                        $userGroup = Sentry::findGroupById($input['user_group']);

                        // Assign the group to the user
                        $user->addGroup($userGroup);
                    }

                    $this->setWholeMessage('success', 'Changes has been saved successfully!');
                    return true;
                }
                else {
                    $message = 'Please Try again.';
                }
            } catch (Cartalyst\Sentry\Users\UserExistsException $e) {
                $message = 'User with this login already exists.';
            } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
                $message = 'User was not found.';
            }

            $this->setWholeMessage('error', $message);
            return false;
        }
    }

    /**
     * Get's user by it's id
     *
     * @param int $id
     * @return Sentry
     */
    public function getUserById($id)
    {
        return Sentry::findUserById($id);
    }


    /**
     * Delete user by it's id
     *
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        $user = $this->user->find($id);
        $user->userGroups()->detach();

        return $user->delete();
    }

    /**
     * Update users settings
     *
     * @param array $input
     * @return array
     */
    public function settingSave($input)
    {
        $rules = [
                'password'      => 'required|min:3|confirmed'
        ];

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {

            return ['success' => false, 'validator' => $validator];
        }

        try {
            $user = Sentry::getUser();

            // Update the user details
            $user->password = $input['password'];

            // Update the user
            if ($user->save()) {

                return ['success' => true, 'message' => 'Password Changed successfully!'];
            }
            else {
                $message = 'Please Try again.';
            }
        } catch (Cartalyst\Sentry\Users\UserExistsException $e) {
            $message = 'User with this login already exists.';
        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            $message = 'User was not found.';
        }

        return ['success' => false, 'type' => 'sentry', 'message' => $message];
    }
}