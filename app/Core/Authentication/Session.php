<?php

/**
 * Class Session
 *
 * This class handles user authentication and session management.
 *
 * @author Eric Marty
 * @since 10/15/2023 6:47 PM
 */

namespace App\Core\Authentication;

use App\Core\Database\Database;
use App\Core\Http\Request;
use App\Model\User;
use App\Model;

class Session
{
    private const COOKIE_KEY = "Session-Id";
    private Model\Session $session;
    private Model\User $user;
    private string $cookie;

    public function __construct()
    {
        $this->session = new Model\Session();
        $this->user = new Model\User();
    }
    /**
     * Authenticate the login for a user.
     *
     * @param object $user The user object to authenticate.
     * @return bool Returns true if the login is authenticated successfully, false otherwise.
     * @throws Exception if the COOKIE_KEY environment variable is not found.
     */
    public function authenticateLogin($user): bool
    {
        $token = bin2hex(random_bytes(128));
        $cookie = $user->email.":".$token;
        $cookieKey = getenv('COOKIE_KEY', true);
        if (!$cookieKey) {
            throw new Exception('No Cookie Key found in the environment!');
        }

        $mac = hash_hmac("sha256", $cookie, $cookieKey);
        $cookie .= ":".$mac;

        $this->session = new Model\Session([
            'user_id' => $user->id,
            'token' => $token
        ]);
        $this->session->save();

        // Now you could use the generated cookie securely with flags set properly
        setcookie(self::COOKIE_KEY, bin2hex($cookie), [
            "expires" => time() + 60 * 60 * 24 * 30,    // one hour * 24 hours * 30 days
            "path" => "/",
            "secure" => getenv("DEV_MODE") !== "1",     // cookie will only be sent over secure HTTPS connections
            "httponly" => true,     // cookie will only be accessible through the HTTP protocol (no JavaScript)
            "samesite" => "None",   // cookie will not be sent along with requests initiated by third party websites
        ]);
        $this->cookie = $cookie;
        $this->user = $user;

        return true;
    }

    public function authenticate($args)
    {
        $auth = $this->authenticateUserFromCookie();
        if ($auth === true)
        {
            return true;
        }

        if ($args['token'] ?? false)
        {
            $auth = $this->authenticateUserFromPost($args['token']);
            if ($auth === true)
            {
                return true;
            }
        }

        return false;
    }

    public function authenticateUserFromCookie(): bool
    {
        foreach (Request::cookie() as $key => $value) {
            if (strcmp($key, self::COOKIE_KEY) !== 0)
                continue;

            $parts = explode(":", hex2bin($value));
            // [0] = email
            // [1] = token
            // [2] = hash of "email:token"
            if (count($parts) !== 3)
            {
                return false;
            }

            $user = new User(["email" => $parts[0]]);
            if (!$user->loadFromDatabase())
            {
                return false;
            }

            $this->session = new Model\Session([
                'user_id' => $user->id,
                'token' => $parts[1]
            ]);
            if (!$this->session->loadFromDatabase())
            {
                $this->setExpiredCookie();
                return false;
            }

            // The final cookie value will be in the form of "email:token:mac".
            // Where the email and token combine with a key from the .env to
            // create the mac.
            $cookie = $user->email.":".$this->session->fields['token'];
            $mac = hash_hmac("sha256", $cookie, $_ENV["COOKIE_KEY"]);
            $cookie .= ":".$mac;

            if (hash_equals($mac, $parts[2]))
            {
                $this->cookie = $cookie;
                $this->user = $user;
                return true;
            }
            else
            {
                $this->invalidateCookie($cookie);
            }
        }

        return false;
    }

    public function authenticateUserFromPost($value): bool
    {
        if (trim($value) === "")
        {
            return false;
        }

        $this->session = new Model\Session([
            'token' => $value
        ]);
        if (!$this->session->loadFromDatabase())
        {
            return false;
        }

        $user = new User(["id" => $this->session->fields['user_id']]);
        if (!$user->loadFromDatabase())
        {
            return false;
        }

        $this->user = $user;
        return true;
    }

    /**
     * Invalidate the session for a user.
     *
     * This method will delete the session cookie and remove the session data from the database.
     *
     * @return void
     */
    public function invalidateSession(): void
    {
        $this->invalidateCookie($this->cookie);
        $this->session->delete();
    }

    private function invalidateCookie($cookie): void
    {
        setcookie(self::COOKIE_KEY, $cookie, strtotime("-30 days"), "/");
    }

    public function getAuthenticatedUser(): User
    {
        return $this->user;
    }

    public function isAuthenticated(): bool
    {
        return $this->user->id !== null && is_numeric($this->user->id);
    }

    public function getToken(): string
    {
        return $this->session->fields['token'] ?? false;
    }
}