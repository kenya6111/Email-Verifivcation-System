<?php

namespace Database\DataAccess;

use Database\DataAccess\Implementations\ComputerPartDAOImpl;
use Database\DataAccess\Implementations\ComputerPartDAOMemcachedImpl;
use Database\DataAccess\Interfaces\ComputerPartDAO;

use Database\DataAccess\Implementations\UserDAOImpl;
use Database\DataAccess\Interfaces\UserDAO;
use Helpers\Settings;

use Database\DataAccess\Implementations\PostDAOImpl;
use Database\DataAccess\Interfaces\PostDAO;


class DAOFactory
{
    public static function getComputerPartDAO(): ComputerPartDAO{
        $driver = Settings::env('DATABASE_DRIVER');

        return match ($driver) {
            'memcached' => new ComputerPartDAOMemcachedImpl(),
            default => new ComputerPartDAOImpl(),
        };
    }

    public static function getUserDAO(): UserDAO{
        $driver = Settings::env('DATABASE_DRIVER');

        return match ($driver) {
            //'memcached' => new ComputerPartDAOMemcachedImpl(),
            default => new UserDAOImpl(),
        };
    }

    public static function getPostDAO(): PostDAO{
        $driver = Settings::env('DATABASE_DRIVER');

        return match ($driver) {
            //'memcached' => new ComputerPartDAOMemcachedImpl(),
            default => new PostDAOImpl(),
        };
    }
}