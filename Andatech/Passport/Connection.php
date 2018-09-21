<?php

namespace App\Andatech\Passport;

/**
 * Class Connection
 * Put down your dynamic logic below and it will work accordingly.
 *
 * @package App\Andatech\Passport
 */
class Connection
{
    /**
     * Returns database connection name to be used by Laravel Passport.
     *
     * @return string
     */
    public static function setDBConnection(): string
    {
        return env('DB_CONNECTION');
    }

    /**
     * Returns database name to be used by Laravel Passport.
     *
     * @return string
     */
    public static function setDatabase(): string
    {
        return env('DB_DATABASE');
    }
}
