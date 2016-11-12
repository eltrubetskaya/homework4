<?php
/**
 * Created by PhpStorm.
 * User: elena
 * Date: 07.11.16
 * Time: 0:16
 */

namespace Repositories;

/**
 * This is class for table "university".
 *
 * @property integer $id
 * @property string $univer_name
 * @property string $city
 * @property string $site
 */

class UniversityRepository extends AbstractRepository implements RepositoryInterface
{
    public $id;
    public $univer_name;
    public $city;
    public $site;

    /**
     * Insert new entity data to the DB
     * @param array $entityData
     * @return mixed
     */
    public function insert(array $entityData)
    {
        $statement = $this->getConnector()->getPdo()->prepare('INSERT INTO university (univer_name, city, site) VALUES(:univer_name, :city, :site)');
        $statement->execute(array(
            "univer_name" => $entityData['univer_name'],
            "city" => $entityData['city'],
            "site" => $entityData['site'],
        ));

        $statement = $this->getConnector()->getPdo()->prepare('SELECT * FROM university');
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_CLASS, UniversityRepository::class);
    }

    /**
     * Update exist entity data in the DB
     * @param array $entityData
     * @return mixed
     */
    public function update(array $entityData)
    {
        $statement = $this->getConnector()->getPdo()->prepare("UPDATE university SET univer_name = :univer_name, city = :city, site = :site WHERE id = :id");

        $statement->bindValue(':univer_name', $entityData['univer_name'], \PDO::PARAM_STR);
        $statement->bindValue(':city', $entityData['city'], \PDO::PARAM_STR);
        $statement->bindValue(':site', $entityData['site'], \PDO::PARAM_STR);
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
        $statement = $this->getConnector()->getPdo()->prepare("DELETE FROM university WHERE id = :id");

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
        $statement = $this->getConnector()->getPdo()->prepare('SELECT * FROM university WHERE id = :id LIMIT 1');
        $statement->bindValue(':id', (int) $id, \PDO::PARAM_INT);
        $statement->execute();
        $resultsData = $this->fetchResultsData($statement);
        return $resultsData[0];
    }

    /**
     * Search all entity data in the DB
     * @param int|string $limit
     * @param int|string $offset
     * @return array
     */
    public function findAll($limit = 1000, $offset = 0)
    {
        $statement = $this->getConnector()->getPdo()->prepare('SELECT * FROM  university LIMIT :limit OFFSET :offset');
        $statement->bindValue(':limit', (int) $limit, \PDO::PARAM_INT);
        $statement->bindValue(':offset', (int) $offset, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_CLASS, UniversityRepository::class);
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
