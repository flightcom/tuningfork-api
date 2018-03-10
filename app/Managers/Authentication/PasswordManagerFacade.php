<?php

namespace Managers\Authentication;

use Illuminate\Support\Facades\Facade;

class PasswordManagerFacade extends Facade
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
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return PasswordManager::class;
    }
}
