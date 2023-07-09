<?php

namespace Source\Models;

use Source\Core\Model;

/**
 * @package Source\Models
 */
class Request extends Model
{
    /**
     * Request constructor.
     */
    public function __construct()
    {
        parent::__construct("requests", ["id"], ["document", "benefit_number", "client_id"]);
    }

    /**
     * @return User
     */
    public function client(): User
    {
        return (new User())->findById($this->client_id);
    }
}
