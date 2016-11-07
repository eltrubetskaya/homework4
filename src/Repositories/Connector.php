<?php
/**
 * Created by PhpStorm.
 * User: elena
 * Date: 04.11.16
 * Time: 23:52
 */

namespace Repositories;

class Connector
{
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var string
     */
    private $dump;

    /**
     * Initialize the database connection
     * @param $databasename
     * @param $user
     * @param $pass
     */
    public function __construct($databasename, $user, $pass)
    {
        $this->pdo = new \PDO('mysql:host=localhost;dbname=' . $databasename . ';charset=UTF8', $user, $pass);
        $this->dump ='mysql -u'.$user.' -p'.$pass.' < /var/www/html/homework_4/data.sql';
        if (!$this->pdo) {
            return false;
            //throw new Exception('Error connecting to the database');
        }
    }

    /**
     * @return \PDO
     */
    public function getPdo()
    {
        return $this->pdo;
    }

    /**
     * @return string
     */
    public function getDump()
    {
        return $this->dump;
    }
}
