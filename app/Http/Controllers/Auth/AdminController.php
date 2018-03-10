<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Cache\RateLimiter;

use AuthManager;
use Lang;
use Log;

class AdminController extends Controller
{

    use AuthenticatesUsers;

    /*
    |--------------------------------------------------------------------------
    | Admin - Login Controller
    |--------------------------------------------------------------------------
    |
    | Similar to the AuthController, however this relies on blade views to
    | interact with the user. There is also no user registration as admins
    | should be assigned and not created.
    |
    */

    /**
     * Where to redirect admins after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Where to redirect admins after logout.
     *
     * @var string
     */
    protected $redirectAfterLogout = 'admin/login';

    /**
     * Create a new authentication controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * Handle a login request to the backend application.
     *
     * Essentially we want to make sure the user has the proper
     * permissions before logging them in
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        $this->validateLogin($request);

        if (!AuthManager::hasBackendAccess($request['email'])) {
            Log::alert('Unauthorized email attempted login to backend: ' . $request['email']);

            return $this->sendUnauthorizedLoginResponse($request);
        }

        return $this->login($request);
    }

    /**
     * Handle a logout request from the backend application
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getLogout(Request $request)
    {
        // By default this sends to '/'
        $this->logout($request);

        return redirect($this->redirectTo);
    }

    /**
     * Get the failed login response instance.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendUnauthorizedLoginResponse(Request $request)
    {
        return redirect()->back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => $this->getUnauthorizedLoginMessage(),
            ]);
    }

    /**
     * Get the failed login message.
     *
     * @return string
     */
    protected function getUnauthorizedLoginMessage()
    {
        return Lang::has('auth.unauthorized')
            ? Lang::get('auth.unauthorized')
            : 'You are not authorized to login. Email reported.';
    }
}
