<?php
/**
 * Created by PhpStorm.
 * User: elena
 * Date: 05.11.16
 * Time: 0:13
 */

namespace Repositories;

class DataRepository extends AbstractRepository implements DataInterface
{
    /**
     * @return mixed
     */
    public function insertDataUniver()
    {
        $statement = $this->getConnector()->getPdo()->prepare('INSERT INTO university (univer_name, city, site) VALUES(:univer_name, :city, :site)');
        for ($i=0; $i<5; $i++) {
            $statement->execute(array(
                    "univer_name" => $this->fake_data->company,
                    "city" => $this->fake_data->city,
                    "site" => $this->fake_data->freeEmailDomain,
                ));
        }
        $statement = $this->getConnector()->getPdo()->prepare('SELECT * FROM university');
        $statement->execute();
        return $this->fetchResultsData($statement);
    }

     /**
     * @return mixed
     */
    public function insertDataDepart()
    {
        $statement = $this->getConnector()->getPdo()->prepare('INSERT INTO department (d_name, univer_id) VALUES(:d_name, :univer_id)');
        for ($i=0; $i<5; $i++) {
            $rand_id = $this->getConnector()->getPdo()->prepare('SELECT id FROM university ORDER BY RAND() LIMIT 1;');
            $rand_id->execute();
            $resultsData = $this->fetchResultsData($rand_id);
            $statement->execute(array(
                "d_name" => $this->fake_data->company,
                "univer_id" => $resultsData[0]['id']
            ));
        }
        $statement = $this->getConnector()->getPdo()->prepare('SELECT * FROM department');
        $statement->execute();
        return $this->fetchResultsData($statement);
    }
}
