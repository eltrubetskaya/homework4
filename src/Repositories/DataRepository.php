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

    /**
     * @return mixed
     */
    public function insertDataStudents()
    {
        $statement = $this->getConnector()->getPdo()->prepare('INSERT INTO  students (first_name, last_name, email, tel) VALUES(:first_name, :last_name, :email, :tel)');
        for ($i=0; $i<5; $i++) {
            $statement->execute(array(
                "first_name" => $this->fake_data->firstName,
                "last_name" => $this->fake_data->lastName,
                "email" => $this->fake_data->email,
                "tel" => $this->fake_data->phoneNumber,
            ));
        }
        $statement = $this->getConnector()->getPdo()->prepare('SELECT * FROM students');
        $statement->execute();
        return $this->fetchResultsData($statement);
    }

    /**
     * @return mixed
     */
    public function insertDataDisciplines()
    {
        $statement = $this->getConnector()->getPdo()->prepare('INSERT INTO disciplines (disc_name, department_id) VALUES(:disc_name, :department_id)');
        for ($i=0; $i<5; $i++) {
            $rand_id = $this->getConnector()->getPdo()->prepare('SELECT id FROM department ORDER BY RAND() LIMIT 1;');
            $rand_id->execute();
            $resultsData = $this->fetchResultsData($rand_id);
            $statement->execute(array(
                "disc_name" => $this->fake_data->company,
                "department_id" => $resultsData[0]['id']
            ));
        }
        $statement = $this->getConnector()->getPdo()->prepare('SELECT * FROM disciplines');
        $statement->execute();
        return $this->fetchResultsData($statement);
    }

    /**
     * @return mixed
     */
    public function insertDataTeacher()
    {
        $statement = $this->getConnector()->getPdo()->prepare('INSERT INTO  teacher (first_name, last_name, department_id) VALUES(:first_name, :last_name, :department_id)');
        for ($i=0; $i<5; $i++) {
            $rand_id = $this->getConnector()->getPdo()->prepare('SELECT id FROM department ORDER BY RAND() LIMIT 1;');
            $rand_id->execute();
            $resultsData = $this->fetchResultsData($rand_id);
            $statement->execute(array(
                "first_name" => $this->fake_data->firstName,
                "last_name" => $this->fake_data->lastName,
                "department_id" => $resultsData[0]['id'],
            ));
        }
        $statement = $this->getConnector()->getPdo()->prepare('SELECT * FROM teacher');
        $statement->execute();
        return $this->fetchResultsData($statement);
    }

    /**
     * @return mixed
     */
    public function insertDataHomework()
    {
        $statement = $this->getConnector()->getPdo()->prepare('INSERT INTO  homework (hw_name, status, disciplines_id, teacher_id, student_id) VALUES(:hw_name, :status, :disciplines_id, :teacher_id, :student_id)');
        for ($i=0; $i<5; $i++) {
            $rand_id = $this->getConnector()->getPdo()->prepare('SELECT id FROM disciplines ORDER BY RAND() LIMIT 1;');
            $rand_id->execute();
            $resultsDataDisciplines = $this->fetchResultsData($rand_id);
            unset($rand_id);
            $rand_id = $this->getConnector()->getPdo()->prepare('SELECT id FROM teacher ORDER BY RAND() LIMIT 1;');
            $rand_id->execute();
            $resultsDataTeacher = $this->fetchResultsData($rand_id);
            unset($rand_id);
            $rand_id = $this->getConnector()->getPdo()->prepare('SELECT id FROM students ORDER BY RAND() LIMIT 1;');
            $rand_id->execute();
            $resultsDataStudents = $this->fetchResultsData($rand_id);
            unset($rand_id);
            $statement->execute(array(
                "hw_name" => $this->fake_data->name,
                "status" => $this->fake_data->boolean,
                "disciplines_id" => $resultsDataDisciplines[0]['id'],
                "teacher_id" => $resultsDataTeacher[0]['id'],
                "student_id" => $resultsDataStudents[0]['id'],
            ));
        }
        $statement = $this->getConnector()->getPdo()->prepare('SELECT * FROM homework');
        $statement->execute();
        return $this->fetchResultsData($statement);
    }
}
