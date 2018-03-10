<?php

namespace App\Http\Controllers\Auth;

use App\Utils\ApiValidator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Cache\RateLimiter;

use Exception;
use App\Utils\ExceptionLogger;

use AuthManager;
use Lang;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     */
    public function __construct()
    {
        $this->middleware('jwt.auth', ['only' => 'logout, whoAmI']);
    }

    /**
     * @param string $email required
     * @param string $password required
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        ApiValidator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (ApiValidator::fails()) {
            return ApiValidator::response();
        }

        try {
            if ($lockedOut = $this->hasTooManyLoginAttempts($request)) {
                $this->fireLockoutEvent($request);

                $seconds = app(RateLimiter::class)->availableIn(
                    $this->throttleKey($request)
                );

                return response()->json($this->getLockoutErrorMessage($seconds), 429);
            }

            $data = AuthManager::authenticate($request->only('email', 'password'));

            // Explicitly null means the credentials were wrong
            if ($data === null) {
                // The login credentials were definitely wrong
                $this->incrementLoginAttempts($request);

                return response()->json($this->getFailedLoginMessage(), 400);
            }

            // Explicitly false means the account is not
            // authorized to log in by the application e.g. Suspended
            if ($data === false) {
                return response()->json($this->getUnauthorizedLoginMessage(), 400);
            }

            // At this point, valid data
            $this->clearLoginAttempts($request);

            return response()->json($data, 200);
        } catch (Exception $e) {
            ExceptionLogger::log($e);
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function whoAmI() {
        try {
            return response()->json(AuthManager::whoAmI(), 200);
        } catch (Exception $e) {
            ExceptionLogger::log($e);
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        try {
            $data = AuthManager::invalidate();

            return response()->json($data, 200);
        } catch (Exception $e) {
            ExceptionLogger::log($e);
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * @param string $email required
     * @param string $first_name optional
     * @param string $last_name optional
     * @param string $password required
     * @param string $password_confirmation required
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        ApiValidator::make($request->all(), [
            'email' => 'required|email|max:255|unique:users',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'password' => 'required|confirmed',
        ]);

        if (ApiValidator::fails()) {
            return ApiValidator::response();
        }

        try {
            $data = AuthManager::registerUser($request->all());

            if (!$data) {
                return response()->json($this->getInvalidStatusMessage(), 400);
            }

            return response()->json($data, 201);
        } catch (Exception $e) {
            ExceptionLogger::log($e);
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Get the login lockout error message.
     *
     * @param  int  $seconds
     * @return string
     */
    protected function getLockoutErrorMessage($seconds)
    {
        return [
            'errors' => [ 'login' => [[ 'code' => 'authThrottle', 'seconds' => $seconds ]] ]
        ];
    }

    /**
     * Get the failed login message.
     *
     * @return string
     */
    protected function getFailedLoginMessage()
    {
        return [
            'errors' => [ 'login' => [[ 'code' => 'invalid_credentials' ]] ]
        ];
    }

    /**
     * Get the unauthorized login message.
     *
     * @return string
     */
    protected function getUnauthorizedLoginMessage()
    {
        return [
            'errors' => [ 'login' => [[ 'code' => 'auth_unauthorized' ]] ]
        ];
    }

    /**
     * Get the failed login message.
     *
     * @return string
     */
    protected function getInvalidStatusMessage()
    {
        return [
            'errors' => [ 'login' => [[ 'code' => 'invalid_auth_status' ]] ]
        ];
    }

    /**
     * Get the login username to be used by the controller.
     * Used by the ThrottlesLogins trait
     *
     * @return string
     */
    public function loginUsername()
    {
        return 'email';
    }
}
