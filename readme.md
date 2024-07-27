# webtech

A PHP framework and API for custom-built projects by EJM Tech.

## App Structure

### app

The `app` folder contains the PHP application code that can HTML and JSON responses using the core API. Entry point into API is `Core\Router\handle()`. The `Core\Router` class also contains `$publicEndpoints` which are allowed to bypass authentication. Requests resolve to controllers located in root of `app` folder. Html is rendered using `Core\Renderer.php`.

### db

The `db` folder holds database files used to install a new version of the application. Scripts with sample data as well as migration scripts are also located here. Database files are divided by application version, see git tags for version locations.

### public_html

`public_html` is the web root of the application. To create a new page, create a new `index.php` file. To build a page send a request to a controller available to the API.

### tools

The `tools` folder is for custom and shared tools helpful to the application framework. See `tools/readme.md` for more.
