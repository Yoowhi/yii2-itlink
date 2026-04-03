<?php

namespace app\common;

class StatusCode {
    const CONTINUE = 100;
    const SWITCHING_PROTOCOLS = 101;
    const PROCESSING = 102;

    const OK = 200;
    const CREATED = 201;
    const ACCEPTED = 202;
    const NO_CONTENT = 204;

    const MOVED_PERMANENTLY = 301;
    const FOUND = 302;
    const NOT_MODIFIED = 304;
    const TEMPORARY_REDIRECT = 307;

    const BAD_REQUEST = 400;
    const UNAUTHORIZED = 401;
    const FORBIDDEN = 403;
    const NOT_FOUND = 404;
    const METHOD_NOT_ALLOWED = 405;
    const UNPROCESSABLE_ENTITY = 422;
    const TOO_MANY_REQUESTS = 429;

    const INTERNAL_SERVER_ERROR = 500;
    const NOT_IMPLEMENTED = 501;
    const BAD_GATEWAY = 502;
    const SERVICE_UNAVAILABLE = 503;
}