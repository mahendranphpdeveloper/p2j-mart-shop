<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Bibliophile extends Authenticatable
{
    protected $guard = 'Bibliophile';  // Explicitly set the guard

    /**
     * Get the name of the "auth" identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'id'; // Default primary key column name
    }

    /**
     * Get the primary key for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->getKey(); // Returns the model's primary key value
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password; // Column where the password is stored
    }
}
