<?php

/**
 * Auth Controller
 *
 * @package Laravel Core
 */
class AuthController extends BaseController
{
    public function __construct()
    {

    }

    public function getLogin()
    {
        return View::make('auths/login');
    }

    public function postLogin()
    {
        $credentials = array(
            'email'    => Input::get('username'),
            'password' => Input::get('password')
        );
        $message = '';
        try {
            // Try to authenticate the user
            $user = Sentry::authenticate($credentials, false);
            Sentry::login($user, false);

            Redirect::to('/');
        }
        catch (Cartalyst\Sentry\Users\LoginRequiredException $e) {
            $message = 'Please enter an email and password.';
        }
        catch (Cartalyst\Sentry\Users\PasswordRequiredException $e) {
            $message = 'Please enter an email and password.';
        }
        catch (Cartalyst\Sentry\Users\WrongPasswordException $e) {
            $message = 'Your password was incorrect, please try again.';
        }
        catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            $message = "Your email was incorrect or you don't have an account, please try again.";
        }
        catch (Cartalyst\Sentry\Users\UserNotActivatedException $e) {
            $message = 'Please activate your account.';
        }
        catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e) {

            $throttle = Sentry::findThrottlerByUserLogin($credentials['email']);

            $time = $throttle->getSuspensionTime();

            $message = "User is suspended for $time minutes.";
        }
        catch (Cartalyst\Sentry\Throttling\UserBannedException $e) {
            $message =  'User is banned.';
        }

        return Redirect::back()->with('message', $message);
    }

    public function getLogout()
    {
        Sentry::logout();
        return Redirect::guest('/login');
    }
}
