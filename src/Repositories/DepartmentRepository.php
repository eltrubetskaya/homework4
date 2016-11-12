<?php
/**
 * Created by PhpStorm.
 * User: elena
 * Date: 07.11.16
 * Time: 0:44
 */

namespace Repositories;

/**
 * This is class for table "department".
 *
 * @property integer $id
 * @property string $d_name
 * @property integer $univer_id
 */

class DepartmentRepository extends AbstractRepository implements RepositoryInterface
{
    public $id;
    public $d_name;
    public $univer_id;

    /**
     * Insert new entity data to the DB
     * @param array $entityData
     * @return mixed
     */
    public function insert(array $entityData)
    {
        $statement = $this->getConnector()->getPdo()->prepare('INSERT INTO department (d_name, univer_id) VALUES(:d_name, :univer_id)');
        $statement->execute(array(
            "d_name" => $entityData['d_name'],
            "univer_id" => $entityData['univer_id'],
        ));

        $statement = $this->getConnector()->getPdo()->prepare('SELECT * FROM department');
        $statement->execute();

        return  $statement->fetchAll(\PDO::FETCH_CLASS, DepartmentRepository::class);
    }

    /**
     * Update exist entity data in the DB
     * @param array $entityData
     * @return mixed
     */
    public function update(array $entityData)
    {
        $statement = $this->getConnector()->getPdo()->prepare("UPDATE department SET d_name = :d_name, univer_id = :univer_id WHERE id = :id");
        $statement->bindValue(':d_name', $entityData['d_name'], \PDO::PARAM_STR);
        $statement->bindValue(':univer_id', $entityData['univer_id'], \PDO::PARAM_INT);
        $statement->bindValue(':id', $entityData['id'], \PDO::PARAM_INT);

        return $statement->execute();
    }

    /**
     * Delete entity data from the DB
     * @param array $entityData
     * @return mixed
     */
    public function remove(array $entityData)
    {
        $statement = $this->getConnector()->getPdo()->prepare("DELETE FROM department WHERE id = :id");
        $statement->bindValue(':id', $entityData['id'], \PDO::PARAM_INT);

        return $statement->execute();
    }

    /**
     * Search entity data in the DB by Id
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        $statement = $this->getConnector()->getPdo()->prepare('SELECT * FROM department WHERE id = :id LIMIT 1');
        $statement->bindValue(':id', (int) $id, \PDO::PARAM_INT);
        $statement->execute();
        $resultsData = $this->fetchResultsData($statement);

        return $resultsData[0];
    }

    /**
     * Search all entity data in the DB
     * @param string $limit
     * @param string $offset
     * @return array
     */
    public function findAll($limit, $offset)
    {
        $statement = $this->getConnector()->getPdo()->prepare('SELECT * FROM  department LIMIT :limit OFFSET :offset');
        $statement->bindValue(':limit', (int) $limit, \PDO::PARAM_INT);
        $statement->bindValue(':offset', (int) $offset, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_CLASS, DepartmentRepository::class);
    }

    /**
     * Search all entity data in the DB like $criteria rules
     * @param array $criteria
     * @return mixed
     */
    public function findBy($criteria = [])
    {
        // TODO: Implement findBy() method.
    }
}
