<?php
/**
 * Created by PhpStorm.
 * User: elena
 * Date: 06.11.16
 * Time: 0:49
 */

namespace Controllers;

use Repositories\UniversityRepository;
use Repositories\DepartmentRepository;
use Repositories\StudentsRepository;
use Repositories\DisciplinesRepository;
use Repositories\TeacherRepository;
use Repositories\HomeworkRepository;

class DepartmentController
{
    private $resultsDepartment;

    private $resultsUniversity;

    private $resultsStudents;

    private $resultsDisciplines;

    private $resultsTeacher;

    private $resultsHomework;

    private $loader;

    private $twig;

    /**
     * DepartmentController constructor.
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
        if (isset($_POST['d_name'])) {
            $this->resultsDepartment->insert(
                [
                    'd_name' => $_POST['d_name'],
                    'univer_id'  => $_POST['univer_id'],
                ]
            );
            return $this->indexAction();
        }
        $resultsDataUniversity = $this->resultsUniversity->findAll(1000, 0);
        return $this->twig->render('department_form.html.twig',
            [
                'd_name' => '',
                'resultsDataUniversity' => $resultsDataUniversity,
                'action' => 'create'
            ]
        );
    }

    /**
     * @return string
     */
    public function editAction()
    {
        if (isset($_POST['d_name'])) {
            $this->resultsDepartment->update(
                [
                    'd_name' => $_POST['d_name'],
                    'univer_id'  => $_POST['univer_id'],
                    'id'    => (int) $_POST['depart_id'],
                ]
            );
            return $this->indexAction();
        }

        $resultsData = $this->resultsDepartment->find((int) $_GET['id']);

        $resultsDataUniversity = $this->resultsUniversity->findAll(1000, 0);
        return $this->twig->render('department_form.html.twig',
            [
                'd_name' => $resultsData['d_name'],
                'univer_id' => $resultsData['univer_id'],
                'depart_id' => $resultsData['id'],
                'resultsDataUniversity' => $resultsDataUniversity,
                'action' => 'edit'
            ]
        );
    }

    /**
     * @return string
     */
    public function deleteAction()
    {
        if (isset($_POST['d_name'])) {
            $id = (int) $_POST['depart_id'];
            $this->resultsDepartment->remove(['id' => $id]);
            return $this->indexAction();
        }

        $resultsData = $this->resultsDepartment->find((int) $_GET['id']);
        $resultsDataUniversity = $this->resultsUniversity->findAll(1000, 0);
        return $this->twig->render('department_form.html.twig',
            [
                'd_name' => $resultsData['d_name'],
                'univer_id' => $resultsData['univer_id'],
                'depart_id' => $resultsData['id'],
                'resultsDataUniversity' => $resultsDataUniversity,
                'action' => 'delete'
            ]
        );
    }
}
