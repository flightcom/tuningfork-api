<?php

namespace App\Http\Controllers\Auth;

use App\Utils\ApiValidator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use PasswordManager;

use Exception;
use App\Utils\ExceptionLogger;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior.
    |
    | These functions are already defined in Laravel, however we have
    | redefined them to ensure they return json.
    |
    */

    /**
     * Create a new password controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Send a reset link to the given user.
     *
     * @param string $email required
     * @return \Illuminate\Http\Response
     */
    public function sendResetLinkEmail(Request $request)
    {
        ApiValidator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if (ApiValidator::fails()) {
            return ApiValidator::response();
        }

        try {
            // We will send the password reset link to this user. Once we have attempted
            // to send the link, we will examine the response then see the message we
            // need to show to the user. Finally, we'll send out a proper response.
            $response = PasswordManager::sendResetLink(
                $request->only('email')
            );

            switch ($response) {
                case PasswordManager::RESET_LINK_SENT:
                    return response()->json($response, 200);
                case PasswordManager::INVALID_USER:
                default:
                    return response()->json($this->getErrorResponse($response), 404);
            }
        } catch (Exception $e) {
            ExceptionLogger::log($e);
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Reset the given user's password.
     *
     * @param string $email required
     * @param string $token required
     * @param string $password required
     * @param string $password_confirmation required
     * @return \Illuminate\Http\Response
     */
    public function reset(Request $request)
    {
        ApiValidator::make($request->all(), [
            'email' => 'required|email|max:255|exists:users',
            'token' => 'required|max:255',
            'password' => 'required|confirmed',
        ]);

        if (ApiValidator::fails()) {
            return ApiValidator::response();
        }

        try {
            $response = PasswordManager::resetPassword($request->all());

            switch ($response) {
                case PasswordManager::PASSWORD_RESET:
                    return response()->json($response, 200);
                default:
                    return response()->json($this->getErrorResponse($response), 404);
            }
        } catch (Exception $e) {
            ExceptionLogger::log($e);
            return response()->json($e->getMessage(), 500);
        }
    }

    protected function getErrorResponse($response)
    {
        return [
            'errors' => [ 'reset' => [[ 'code' => $response ]] ]
        ];
    }

}
