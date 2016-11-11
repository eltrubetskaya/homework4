<?php
/**
 * Created by PhpStorm.
 * User: elena
 * Date: 05.11.16
 * Time: 19:09
 */

namespace Controllers;

use Repositories\DataRepository;
use Repositories\HomeworkRepository;
use Repositories\UniversityRepository;
use Repositories\DepartmentRepository;
use Repositories\StudentsRepository;
use Repositories\DisciplinesRepository;
use Repositories\TeacherRepository;

class DataController
{
    private $repository;

    private $resultsUniversity;

    private $resultsDepartment;

    private $resultsStudents;

    private $resultsDisciplines;

    private $resultsTeacher;

    private $resultsHomework;

    private $loader;

    private $twig;

    public function __construct($connector)
    {
        $this->repository = new DataRepository($connector);
        $this->resultsUniversity = new UniversityRepository($connector);
        $this->resultsDepartment = new DepartmentRepository($connector);
        $this->resultsStudents = new StudentsRepository($connector);
        $this->resultsDisciplines = new DisciplinesRepository($connector);
        $this->resultsTeacher = new TeacherRepository($connector);
        $this->resultsHomework = new HomeworkRepository($connector);
        $this->loader = new \Twig_Loader_Filesystem('src/Views/templates/');
        $this->twig = new \Twig_Environment($this->loader, array(
            'cache' => false,
        ));
    }

    /**
     * @return string
     */
    public function indexAction($get_table = null)
    {
        if (isset($_POST['create_db'])) {
            echo exec($this->repository->getDumpConnector());
        }
        $resultsDataUniversity = $this->resultsUniversity->findAll(1000, 0);
        $resultsDataDepartment = $this->resultsDepartment->findAll(1000, 0);
        $resultsDataStudents = $this->resultsStudents->findAll(1000, 0);
        $resultsDataDisciplines = $this->resultsDisciplines->findAll(1000, 0);
        $resultsDataTeacher = $this->resultsTeacher->findAll(1000, 0);
        $resultsDataHomework = $this->resultsHomework->findAll(1000, 0);
        return $this->twig->render('tables.html.twig', [
            'resultsDataUniversity' => $resultsDataUniversity,
            'resultsDataDepartment' => $resultsDataDepartment,
            'resultsDataStudents' => $resultsDataStudents,
            'resultsDataDisciplines' => $resultsDataDisciplines,
            'resultsDataTeacher' => $resultsDataTeacher,
            'resultsDataHomework' => $resultsDataHomework,
            'get_table' => $get_table
        ]);
    }

     /**
     * @return string
     */
    public function createAction()
    {
        return $this->twig->render('data.html.twig');
    }

    /**
     * @return string
     */
    public function insertAction()
    {
        $resultsDataUniversity = $this->repository->insertDataUniver();
        $resultsDataDepartment = $this->repository->insertDataDepart();
        $resultsDataStudents = $this->repository->insertDataStudents();
        $resultsDataDisciplines = $this->repository->insertDataDisciplines();
        $resultsDataTeacher = $this->repository->insertDataTeacher();
        $resultsDataHomework = $this->repository->insertDataHomework();
        return $this->twig->render('tables.html.twig', [
            'resultsDataUniversity' => $resultsDataUniversity,
            'resultsDataDepartment' => $resultsDataDepartment,
            'resultsDataStudents' => $resultsDataStudents,
            'resultsDataDisciplines' => $resultsDataDisciplines,
            'resultsDataTeacher' => $resultsDataTeacher,
            'resultsDataHomework' => $resultsDataHomework
        ]);
    }
}
