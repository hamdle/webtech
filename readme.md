# webtech

A PHP framework and API for custom-built projects by EJM Tech.

## App Structure

### app

The `app` folder contains the PHP application code that can return HTML and JSON responses using the core API. Entry point into the API is located at `Core\Router\handle()`. The `Core\Router` class also contains `$publicEndpoints` which are allowed to bypass authentication. Requests resolve to controllers housed in the `Controller` folder. Html is rendered using `Core\Renderer.php`.

### db

The `db` folder holds database files used to install new versions of the application. Sample data and migration scripts are also located here. Database files are divided by application version, see git tags for version markers.

### public_html

`public_html` is the web root of the application. To create a new page, create a new `index.php` file in this directory. To render an HTML page send a request to a controller available in `app` to the API.

### tools

The `tools` folder keeps custom and shared tools that are helpful to the application framework. See `tools/readme.md` for more.
