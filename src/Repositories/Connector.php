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
        try {
            $this->pdo = new \PDO('mysql:host=localhost;dbname=' . $databasename . ';charset=UTF8', $user, $pass);
            $this->dump ='mysql -u'.$user.' -p'.$pass.' < /var/www/html/homework_4/data.sql';
        } catch (PDOException $e) {
            echo 'Подключение не удалось: ' . $e->getMessage();
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
