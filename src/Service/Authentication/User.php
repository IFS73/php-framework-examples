<?php

namespace Cda0521Framework\Service\Authentication;

use Cda0521Framework\Database\Sql\SqlDatabaseHandler;

class User
{
    /**
     * Database ID
     * @var int|null
     */
    protected int $id;
    /**
     * Email address
     * @var string
     */
    protected string $email;
    /**
     * Password
     * @var string
     */
    protected string $password;
    /**
     * Secret authentication key
     * @var string
     */
    protected string $secret;

    /**
     * Récupère un élément en base de données en fonction des on identifiant
     *
     * @return User[]
     */
    static public function findWhere(string $columnName, string $value): array
    {
        $data = SqlDatabaseHandler::fetchWhere('user', $columnName, $value);
        foreach ($data as $item) {
            $result []= new User(
                $item['id'],
                $item['email'],
                $item['password'],
                $item['secret']
            );
        }
        return $result;
    }

    /**
     * Create new user
     *
     * @param integer|null $id Database ID
     * @param string $email Email address
     * @param string $password Password
     */
    public function __construct(?int $id = null, string $email = '', string $password = '', string $secret='')
    {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->secret = $secret;
    }

    /**
     * Get email address
     *
     * @return  string
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set email address
     *
     * @param  string  $email  Email address
     *
     * @return  self
     */ 
    public function setEmail(string $email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get password
     *
     * @return  string
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set password
     *
     * @param  string  $password  Password
     *
     * @return  self
     */ 
    public function setPassword(string $password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get secret authentication key
     *
     * @return  string
     */ 
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * Set secret authentication key
     *
     * @param  string  $secret  Secret authentication key
     *
     * @return  self
     */ 
    public function setSecret(string $secret)
    {
        $this->secret = $secret;

        return $this;
    }
}
