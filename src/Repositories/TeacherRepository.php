<?php
/**
 * Created by PhpStorm.
 * User: elena
 * Date: 07.11.16
 * Time: 16:42
 */

namespace Repositories;

/**
 * This is class for table "teacher".
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property integer $department_id
 */

class TeacherRepository extends AbstractRepository implements RepositoryInterface
{
    public $id;
    public $first_name;
    public $last_name;
    public $department_id;
    /**
     * Insert new entity data to the DB
     * @param array $entityData
     * @return mixed
     */
    public function insert(array $entityData)
    {
        $statement = $this->getConnector()->getPdo()->prepare('INSERT INTO teacher (first_name, last_name, department_id) VALUES(:first_name, :last_name, :department_id)');
        $statement->execute(array(
            "first_name" => $entityData['first_name'],
            "last_name" => $entityData['last_name'],
            "department_id" => $entityData['department_id'],
        ));

        $statement = $this->getConnector()->getPdo()->prepare('SELECT * FROM teacher');
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_CLASS, TeacherRepository::class);
    }

    /**
     * Update exist entity data in the DB
     * @param array $entityData
     * @return mixed
     */
    public function update(array $entityData)
    {
        $statement = $this->getConnector()->getPdo()->prepare("UPDATE teacher SET first_name = :first_name, last_name = :last_name, department_id = :department_id WHERE id = :id");

        $statement->bindValue(':first_name', $entityData['first_name'], \PDO::PARAM_STR);
        $statement->bindValue(':last_name', $entityData['last_name'], \PDO::PARAM_STR);
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
        $statement = $this->getConnector()->getPdo()->prepare("DELETE FROM teacher WHERE id = :id");

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
        $statement = $this->getConnector()->getPdo()->prepare('SELECT * FROM teacher WHERE id = :id LIMIT 1');
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
        $statement = $this->getConnector()->getPdo()->prepare('SELECT * FROM  teacher LIMIT :limit OFFSET :offset');
        $statement->bindValue(':limit', (int) $limit, \PDO::PARAM_INT);
        $statement->bindValue(':offset', (int) $offset, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_CLASS, TeacherRepository::class);
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
