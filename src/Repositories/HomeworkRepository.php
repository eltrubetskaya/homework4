<?php
/**
 * Created by PhpStorm.
 * User: elena
 * Date: 07.11.16
 * Time: 16:46
 */

namespace Repositories;

/**
 * This is class for table "homework".
 *
 * @property integer $id
 * @property string $hw_name
 * @property boolean $status
 * @property integer $disciplines_id
 * @property integer $teacher_id
 * @property integer $student_id
 */

class HomeworkRepository extends AbstractRepository implements RepositoryInterface
{
    public $id;
    public $hw_name;
    public $status;
    public $disciplines_id;
    public $teacher_id;
    public $student_id;

    /**
     * Insert new entity data to the DB
     * @param array $entityData
     * @return mixed
     */
    public function insert(array $entityData)
    {
        $statement = $this->getConnector()->getPdo()->prepare('INSERT INTO homework (hw_name, status, disciplines_id, teacher_id, student_id) VALUES(:hw_name, :status, :disciplines_id, :teacher_id, :student_id)');
        $statement->execute(array(
            "hw_name" => $entityData['hw_name'],
            "status" => $entityData['status'],
            "disciplines_id" => $entityData['disciplines_id'],
            "teacher_id" => $entityData['teacher_id'],
            "student_id" => $entityData['student_id'],
        ));

        $statement = $this->getConnector()->getPdo()->prepare('SELECT * FROM homework');
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_CLASS, HomeworkRepository::class);
    }

    /**
     * Update exist entity data in the DB
     * @param array $entityData
     * @return mixed
     */
    public function update(array $entityData)
    {
        $statement = $this->getConnector()->getPdo()->prepare("UPDATE homework SET hw_name = :hw_name, status = :status, disciplines_id = :disciplines_id, teacher_id = :teacher_id, student_id = :student_id WHERE id = :id");

        $statement->bindValue(':hw_name', $entityData['hw_name'], \PDO::PARAM_STR);
        $statement->bindValue(':status', $entityData['status'], \PDO::PARAM_BOOL);
        $statement->bindValue(':disciplines_id', $entityData['disciplines_id'], \PDO::PARAM_INT);
        $statement->bindValue(':teacher_id', $entityData['teacher_id'], \PDO::PARAM_INT);
        $statement->bindValue(':student_id', $entityData['student_id'], \PDO::PARAM_INT);
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
        $statement = $this->getConnector()->getPdo()->prepare("DELETE FROM homework WHERE id = :id");

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
        $statement = $this->getConnector()->getPdo()->prepare('SELECT * FROM homework WHERE id = :id LIMIT 1');
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
        $statement = $this->getConnector()->getPdo()->prepare('SELECT * FROM  homework LIMIT :limit OFFSET :offset');
        $statement->bindValue(':limit', (int) $limit, \PDO::PARAM_INT);
        $statement->bindValue(':offset', (int) $offset, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_CLASS, HomeworkRepository::class);
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
