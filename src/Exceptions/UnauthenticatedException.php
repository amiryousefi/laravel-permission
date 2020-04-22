<?php

namespace Amir\Permission\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class UnauthenticatedException extends HttpException
{

    public static function notLoggedIn()
    {
        return new static(401, 'User is not logged in', null, []);
    }

}
