<?php

/**
 * Class Core
 *
 * The Core class represents the core functionality of the application.
 *
 * @author Eric Marty
 * @since 10/15/2023 6:41 PM
 */

namespace App;

require_once dirname(__DIR__, 1) . "/autoload.php";

use Api\Core\Authentication;
use Api\Model\User;
use Api\Core\Utils\Log;

class Core
{
    public const HTML_CLOSE = "close";
    public const HTML_FOOTER = "footer";
    public const HTML_HEADER = "header";
    public const HTML_OPEN = "open";
    public const HTML_ERROR = "error";
    public ?User $user;
    private Authentication\Session $session;

    private const AUTHENTICATION_ERROR_MESSAGE = 'Authentication error';
    private $name;

    public function __construct($name = "Workout")
    {
        //session_start();
        //Log::info(session_id(), "session_id");
        $this->name = $name;
        try
        {
            $this->handleAuthentication();
        }
        catch (\Exception $e)
        {
            error_log($e->getMessage());
            $this->renderHtml([self::HTML_OPEN, self::HTML_ERROR, self::HTML_CLOSE]);
            die();
        }
    }

    /**
     * Handles the authentication process.
     *
     * This method creates a new session object and checks if the user is authenticated.
     *
     * @return void
     * @throws Exception If the user is not authenticated.
     */
    private function handleAuthentication(): void
    {
        $this->session = new Authentication\Session();
        if (!($_SERVER["REQUEST_URI"] === "/" || $this->session->authenticateUserFromCookie()))
        {
            throw new \Exception(self::AUTHENTICATION_ERROR_MESSAGE);
        }
        $this->user = $this->session->getAuthenticatedUser();
    }

    /**
     * Renders HTML by including PHP files.
     *
     * @param string|array $files The file or files to include.
     * @return void
     */
    public function renderHtml($files): void
    {
        if (!is_array($files))
        {
            $files = [$files];
        }

        foreach ($files as $file)
        {
            $filepath = dirname(__DIR__, 1) . $_ENV["HTML_DIR"] . $file . ".php";
            if (file_exists($filepath))
            {
                require $filepath;
            }
        }
    }

    /**
     * Checks if the current page matches a given URI.
     *
     * @param string $uri The URI to compare with the current page URL.
     * @return bool Returns true if the current page URL contains the given URI,
     * false if the current page URL is the root ("/") or does not contain the given URI.
     */
    public function onPage($uri): bool
    {
        return $_SERVER["REQUEST_URI"] === "/"
            ? false
            : str_contains($_SERVER["REQUEST_URI"], $uri);
    }

    /**
     * Checks if the user is authenticated.
     *
     * @return bool Returns true if the user is authenticated, false otherwise.
     */
    public function isAuthenticated()
    {
        return $this->session->isAuthenticated();
    }
}
