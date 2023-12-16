<?php

/**
 * Class Session
 *
 * This class handles user authentication and session management.
 *
 * @author Eric Marty
 * @since 10/15/2023 6:47 PM
 */

namespace api\Core\Authentication;

use api\Core\Http\Request;
use api\Model\User;
use api\Model;

class Session
{
    private const COOKIE_KEY = "Session-Id";
    private Model\Session $session;
    private Model\User $user;
    private string $cookie;

    /**
     * Authenticate the login for a user.
     *
     * @param object $user The user object to authenticate.
     * @return bool Returns true if the login is authenticated successfully, false otherwise.
     * @throws Exception if the COOKIE_KEY environment variable is not found.
     */
    public function authenticateLogin($user): bool
    {
        if ($user->verifyFields() && $user->loadFromDatabase())
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
            setcookie(self::COOKIE_KEY, $cookie, [
                "expires" => time() + 60 * 60 * 24 * 30,    // one hour * 24 hours * 30 days
                "path" => "/",
                //"secure" => true,     // cookie will only be sent over secure HTTPS connections
                "httponly" => true,     // cookie will only be accessible through the HTTP protocol (no JavaScript)
                "samesite" => "None",   // cookie will not be sent along with requests initiated by third party websites
            ]);
            $this->cookie = $cookie;
            $this->user = $user;

            return true;
        }

        return false;
    }

    /**
     * Authenticate the user from the cookie.
     *
     * @return bool Returns true if the user is authenticated successfully from the cookie, false otherwise.
     */
    public function authenticateUserFromCookie()
    {
        foreach (Request::cookie() as $key => $value) {
            if (strcmp($key, self::COOKIE_KEY) !== 0)
                continue;

            $parts = explode(":", $value);
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
                'user_id' => $user->id
            ]);
            if (!$this->session->load())
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
        }

        return false;
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
        setcookie(self::COOKIE_KEY, $this->cookie, strtotime("-30 days"), "/");
        $this->session->delete();
    }

    public function getAuthenticatedUser(): User|null
    {
        return $this->user ?? null;
    }

    public function isAuthenticated(): bool
    {
        return isset($this->user);
    }
}