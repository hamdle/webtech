<?php

/*
 * Core/Http/Code.php: http response codes
 *
 * Copyright (C) 2021 Eric Marty
 */

namespace Api\Core\Http;

class Code
{
    const OK_200 = 200;
    const CREATED_201 = 201;
    const DELETED_204 = 204;
    const BAD_REQUEST_400 = 400;
    const UNAUTHORIZED_401 = 401;
    const FORBIDDEN_403 = 403;
    const NOT_FOUND_404 = 404;
    const IM_A_TEAPOT_418 = 418;
    const UNPROCESSABLE_ENTITY_422 = 422;
    const INTERNAL_SERVER_ERROR_500 = 500;
}
