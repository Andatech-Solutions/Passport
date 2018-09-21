<?php

namespace Andatech\Passport;

use App\Andatech\Passport\Connection;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    /**
     * Model constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $connection = Connection::setDBConnection();
        $this->setConnection($connection);

        if (!config("database.connections.{$connection}.database")) {
            config()->set("database.connections.{$connection}.database", Connection::setDatabase());
        }
    }

    /**
     * Update database connection of the model on run-time
     *
     * @param string $connection
     */
    public function updateConnection(string $connection)
    {
        $this->setConnection($connection);
    }
}
