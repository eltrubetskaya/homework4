<?php
/**
 * Created by PhpStorm.
 * User: elena
 * Date: 07.11.16
 * Time: 16:20
 */

namespace Controllers;

use Repositories\UniversityRepository;
use Repositories\DepartmentRepository;
use Repositories\StudentsRepository;
use Repositories\DisciplinesRepository;
use Repositories\TeacherRepository;
use Repositories\HomeworkRepository;

class DisciplinesController
{
    private $resultsDisciplines;

    private $resultsUniversity;

    private $resultsStudents;

    private $resultsDepartment;

    private $resultsTeacher;

    private $resultsHomework;

    private $loader;

    private $twig;

    /**
     * DisciplinesController constructor.
     * @param $connector
     */
    public function __construct($connector)
    {
        $this->resultsDepartment = new DepartmentRepository($connector);
        $this->resultsUniversity = new UniversityRepository($connector);
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
    public function indexAction()
    {
        $resultsDataUniversity = $this->resultsUniversity->findAll(1000, 0);
        $resultsDataDepartment = $this->resultsDepartment->findAll(1000, 0);
        $resultsDataStudents = $this->resultsStudents->findAll(1000, 0);
        $resultsDataDisciplines = $this->resultsDisciplines->findAll(1000, 0);
        $resultsDataTeacher = $this->resultsTeacher->findAll(1000, 0);
        $resultsDataHomework = $this->resultsHomework->findAll(1000, 0);
        $get_table = $_GET['controller'];
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
        if (isset($_POST['disc_name'])) {
            $this->resultsDisciplines->insert(
                [
                    'disc_name' => $_POST['disc_name'],
                    'department_id'  => $_POST['department_id'],
                ]
            );
            return $this->indexAction();
        }
        $resultsDataDepartment = $this->resultsDepartment->findAll(1000, 0);
        return $this->twig->render('disciplines_form.html.twig',
            [
                'disc_name' => '',
                'resultsDataDepartment' => $resultsDataDepartment,
                'action' => 'create'
            ]
        );
    }

    /**
     * @return string
     */
    public function editAction()
    {
        if (isset($_POST['disc_name'])) {
            $this->resultsDisciplines->update(
                [
                    'disc_name' => $_POST['disc_name'],
                    'department_id'  => $_POST['department_id'],
                    'id'    => (int) $_POST['disc_id'],
                ]
            );
            return $this->indexAction();
        }

        $resultsData = $this->resultsDisciplines->find((int) $_GET['id']);

        $resultsDataDepartment = $this->resultsDepartment->findAll(1000, 0);
        return $this->twig->render('disciplines_form.html.twig',
            [
                'disc_name' => $resultsData['disc_name'],
                'department_id' => $resultsData['department_id'],
                'disc_id' => $resultsData['id'],
                'resultsDataDepartment' => $resultsDataDepartment,
                'action' => 'edit'
            ]
        );
    }

    /**
     * @return string
     */
    public function deleteAction()
    {
        if (isset($_POST['disc_name'])) {
            $id = (int) $_POST['disc_id'];
            $this->resultsDisciplines->remove(['id' => $id]);
            return $this->indexAction();
        }

        $resultsData = $this->resultsDisciplines->find((int) $_GET['id']);
        $resultsDataDepartment = $this->resultsDepartment->findAll(1000, 0);
        return $this->twig->render('disciplines_form.html.twig',
            [
                'disc_name' => $resultsData['disc_name'],
                'department_id' => $resultsData['department_id'],
                'disc_id' => $resultsData['id'],
                'resultsDataDepartment' => $resultsDataDepartment,
                'action' => 'delete'
            ]
        );
    }
}
