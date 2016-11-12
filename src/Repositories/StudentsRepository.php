<?php
/**
 * Created by PhpStorm.
 * User: elena
 * Date: 07.11.16
 * Time: 15:12
 */

namespace Repositories;

/**
 * This is class for table "students".
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $tel
 */

class StudentsRepository extends AbstractRepository implements RepositoryInterface
{
    public $id;
    public $first_name;
    public $last_name;
    public $email;
    public $tel;

    /**
     * Insert new entity data to the DB
     * @param array $entityData
     * @return mixed
     */
    public function insert(array $entityData)
    {
        $statement = $this->getConnector()->getPdo()->prepare('INSERT INTO students (first_name, last_name, email, tel) VALUES(:first_name, :last_name, :email, :tel)');
        $statement->execute(array(
            "first_name" => $entityData['first_name'],
            "last_name" => $entityData['last_name'],
            "email" => $entityData['email'],
            "tel" => $entityData['tel'],
        ));

        $statement = $this->getConnector()->getPdo()->prepare('SELECT * FROM students');
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_CLASS, StudentsRepository::class);
    }

    /**
     * Update exist entity data in the DB
     * @param array $entityData
     * @return mixed
     */
    public function update(array $entityData)
    {
        $statement = $this->getConnector()->getPdo()->prepare("UPDATE students SET first_name = :first_name, last_name = :last_name, email = :email, tel = :tel WHERE id = :id");

        $statement->bindValue(':first_name', $entityData['first_name'], \PDO::PARAM_STR);
        $statement->bindValue(':last_name', $entityData['last_name'], \PDO::PARAM_STR);
        $statement->bindValue(':email', $entityData['email'], \PDO::PARAM_STR);
        $statement->bindValue(':tel', $entityData['tel'], \PDO::PARAM_STR);
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
        $statement = $this->getConnector()->getPdo()->prepare("DELETE FROM students WHERE id = :id");

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
        $statement = $this->getConnector()->getPdo()->prepare('SELECT * FROM students WHERE id = :id LIMIT 1');
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
        $statement = $this->getConnector()->getPdo()->prepare('SELECT * FROM  students LIMIT :limit OFFSET :offset');
        $statement->bindValue(':limit', (int) $limit, \PDO::PARAM_INT);
        $statement->bindValue(':offset', (int) $offset, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_CLASS, StudentsRepository::class);
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
