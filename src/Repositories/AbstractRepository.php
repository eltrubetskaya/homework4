<?php
/**
 * Created by PhpStorm.
 * User: elena
 * Date: 07.11.16
 * Time: 0:21
 */

namespace Repositories;

use Faker\Factory;

abstract class AbstractRepository
{
    private $connector;

    /**
     * DataRepository constructor.
     * Initialize the database connection with sql server via given credentials
     * @param $connector
     */
    public function __construct($connector)
    {
        $this->connector = $connector;
        $this->fake_data = Factory::create();
    }

    /**
     * @return mixed
     */
    public function getDumpConnector()
    {
        return $this->connector->getDump();
    }

    /**
     * @return mixed
     */
    public function getConnector()
    {
        return $this->connector;
    }

    /**
     * @param $statement
     * @return mixed
     */
    protected function fetchResultsData($statement)
    {
        $results = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $results;
    }
}
