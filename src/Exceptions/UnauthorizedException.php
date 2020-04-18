<?php

namespace amir\laravelpermission\Exception;


use Symfony\Component\HttpKernel\Exception\HttpException;

class UnauthorizedException extends HttpException
{

    public static function noPermission()
    {
        return new static(403, 'User done\'t have permission', null, []);
    }

}
