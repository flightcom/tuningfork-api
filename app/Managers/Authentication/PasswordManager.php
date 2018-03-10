<?php

namespace Managers\Authentication;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Utils\Token;

use Models\User;
use DB;
use App\Notifications\ResetPasswordNotification;

class PasswordManager
{
    /**
     * Constant representing a successfully sent reminder.
     *
     * @var string
     */
    const RESET_LINK_SENT = 'password_reset_email_sent';

    /**
     * Constant representing a successfully reset password.
     *
     * @var string
     */
    const PASSWORD_RESET = 'password_reset_passwords_reset';

    /**
     * Constant representing the user not found response.
     *
     * @var string
     */
    const INVALID_USER = 'password_reset_invalid_user';

    /**
     * Constant representing an invalid password.
     *
     * @var string
     */
    const INVALID_PASSWORD = 'password_reset_invalid_password';

    /**
     * Constant representing an invalid token.
     *
     * @var string
     */
    const INVALID_TOKEN = 'password_reset_invalid_token';

    /**
     * The token database table.
     *
     * @var string
     */
    protected $table;

    /**
     * The number of seconds a token should last.
     *
     * @var int
     */
    protected $expire;

    /*
    |--------------------------------------------------------------------------
    | PasswordManager
    |--------------------------------------------------------------------------
    |
    | The PasswordManager takes care of the password reset process
    |
    */

    /**
     * Create a new manager instance
     */
    public function __construct()
    {
        $this->table = config('auth.passwords.users.table');
        $this->expire = config('auth.passwords.users.expire');
    }

    /**
     * Send a password reset link to a user.
     *
     * @param  array  $credentials
     * @return string
     */
    public function sendResetLink(array $credentials) {
        // First we will check to see if we found a user at the given credentials and
        // if we did not we will redirect back to this current URI with a piece of
        // "flash" data in the session to indicate to the developers the errors.
        $user = $this->getUser($credentials);

        if (is_null($user)) {
            return self::INVALID_USER;
        }

        // Once we have the reset token, we are ready to send the message out to this
        // user with a link to reset their password. We will then redirect back to
        // the current URI having nothing set in the session to indicate errors.
        $this->sendPasswordResetNotification($user);

        return self::RESET_LINK_SENT;
    }

    /**
     * Resets the user password as long as the token matches
     *
     * @param array $credentials
     * @return string
     */
    public function resetPassword(array $credentials) {
        $token = DB::table($this->table)->where([
            'email' => $credentials['email'],
            'token' => $credentials['token']
        ])->first();

        if (is_null($token) || $this->tokenExpired($token)) {
            return self::INVALID_TOKEN;
        }

        $user = User::where('email', $token->email)->first();

        if (is_null($user)) {
            return self::INVALID_USER;
        }

        $user->forceFill([
            'password' => $credentials['password'],
            'remember_token' => Str::random(60),
        ])->save();

        $this->deleteExisting($user);

        return self::PASSWORD_RESET;
    }

    /**
     * Delete expired tokens.
     *
     * @return void
     */
    public function deleteExpired()
    {
        $expiredAt = Carbon::now()->subMinutes($this->expire);

        DB::table($this->table)->where('created_at', '<', $expiredAt)->delete();
    }

    /**
     * Get the user for the given email.
     *
     * @param $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    protected function getUser(array $credentials) {
        $credentials = Arr::except($credentials, ['token']);

        return $this->retrieveByCredentials($credentials);
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array  $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    protected function retrieveByCredentials(array $credentials)
    {
        if (empty($credentials)) {
            return;
        }

        return User::where($credentials)->first();
    }

    /**
     * Send the password reset notification.
     *
     * @param User $user
     */
    protected function sendPasswordResetNotification(User $user)
    {
        $user->notify(new ResetPasswordNotification($this->createToken($user)));
    }

    /**
     * Create a token repository instance based on the given configuration.
     *
     * @param User $user
     * @return \Illuminate\Auth\Passwords\TokenRepositoryInterface
     */
    protected function createToken(User $user)
    {
        $this->deleteExisting($user);

        $token = Token::getToken(65);

        DB::table($this->table)->insert([
            'email' => $user->email,
            'token' => $token,
            'created_at' => DB::raw('NOW()')
        ]);

        return $token;
    }

    /**
     * Delete all existing reset tokens from the database.
     *
     * @param User $user
     * @return int
     */
    protected function deleteExisting(User $user)
    {
        return DB::table($this->table)->where([
            'email' => $user->email
        ])->delete();
    }

    /**
     * Determine if the token has expired.
     *
     * @param  array  $token
     * @return bool
     */
    protected function tokenExpired($token)
    {
        $expiresAt = Carbon::parse($token->created_at)->addMinutes($this->expire);

        return $expiresAt->isPast();
    }
}
