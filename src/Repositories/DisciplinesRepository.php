<?php
/**
 * Created by PhpStorm.
 * User: elena
 * Date: 07.11.16
 * Time: 16:00
 */

namespace Repositories;

class DisciplinesRepository extends AbstractRepository implements RepositoryInterface
{
    /**
     * Insert new entity data to the DB
     * @param array $entityData
     * @return mixed
     */
    public function insert(array $entityData)
    {
        $statement = $this->getConnector()->getPdo()->prepare('INSERT INTO disciplines (disc_name, department_id) VALUES(:disc_name, :department_id)');
        $statement->execute(array(
            "disc_name" => $entityData['disc_name'],
            "department_id" => $entityData['department_id'],
        ));

        $statement = $this->getConnector()->getPdo()->prepare('SELECT * FROM disciplines');
        $statement->execute();

        return $this->fetchResultsData($statement);
    }

    /**
     * Update exist entity data in the DB
     * @param array $entityData
     * @return mixed
     */
    public function update(array $entityData)
    {
        $statement = $this->getConnector()->getPdo()->prepare("UPDATE disciplines SET disc_name = :disc_name, department_id = :department_id WHERE id = :id");

        $statement->bindValue(':disc_name', $entityData['disc_name'], \PDO::PARAM_STR);
        $statement->bindValue(':department_id', $entityData['department_id'], \PDO::PARAM_INT);
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
        $statement = $this->getConnector()->getPdo()->prepare("DELETE FROM disciplines WHERE id = :id");

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
        $statement = $this->getConnector()->getPdo()->prepare('SELECT * FROM disciplines WHERE id = :id LIMIT 1');
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
        $statement = $this->getConnector()->getPdo()->prepare('SELECT * FROM  disciplines LIMIT :limit OFFSET :offset');
        $statement->bindValue(':limit', (int) $limit, \PDO::PARAM_INT);
        $statement->bindValue(':offset', (int) $offset, \PDO::PARAM_INT);
        $statement->execute();
        return $this->fetchResultsData($statement);
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
