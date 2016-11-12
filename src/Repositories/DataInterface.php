<?php
/**
 * Created by PhpStorm.
 * User: elena
 * Date: 05.11.16
 * Time: 0:37
 */

namespace Repositories;

interface DataInterface
{
    /**
     * @return mixed
     */
    public function insertDataUniver();

    /**
     * @return mixed
     */
    public function insertDataDepart();

    /**
     * @return mixed
     */
    public function insertDataStudents();

    /**
     * @return mixed
     */
    public function insertDataDisciplines();

    /**
     * @return mixed
     */
    public function insertDataTeacher();

    /**
     * @return mixed
     */
    public function insertDataHomework();
}
