<?php
/**
 * Created by PhpStorm.
 * User: elena
 * Date: 07.11.16
 * Time: 18:17
 */

namespace Controllers;

use Repositories\UniversityRepository;
use Repositories\DepartmentRepository;
use Repositories\StudentsRepository;
use Repositories\DisciplinesRepository;
use Repositories\TeacherRepository;
use Repositories\HomeworkRepository;

class HomeworkController
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
     * HomeworkController constructor.
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
        if (isset($_POST['hw_name'])) {
            $this->resultsHomework->insert(
                [
                    'hw_name' => $_POST['hw_name'],
                    'status' => $_POST['status'],
                    'disciplines_id' => $_POST['disciplines_id'],
                    'teacher_id' => $_POST['teacher_id'],
                    'student_id' => $_POST['student_id'],
                ]
            );
            return $this->indexAction();
        }
        $resultsDataDisciplines = $this->resultsDisciplines->findAll(1000, 0);
        $resultsDataTeacher = $this->resultsTeacher->findAll(1000, 0);
        $resultsDataStudents = $this->resultsStudents->findAll(1000, 0);
        return $this->twig->render('homework_form.html.twig',
            [
                'hw_name' => '',
                'status' => '',
                'resultsDataDisciplines' => $resultsDataDisciplines,
                'resultsDataTeacher' => $resultsDataTeacher,
                'resultsDataStudents' => $resultsDataStudents,
                'action' => 'create'
            ]
        );
    }

    /**
     * @return string
     */
    public function editAction()
    {
        if (isset($_POST['hw_name'])) {
            $this->resultsHomework->update(
                [
                    'hw_name' => $_POST['hw_name'],
                    'status' => $_POST['status'],
                    'disciplines_id' => $_POST['disciplines_id'],
                    'teacher_id' => $_POST['teacher_id'],
                    'student_id' => $_POST['student_id'],
                    'id'    => (int) $_POST['hw_id'],
                ]
            );
            return $this->indexAction();
        }

        $resultsData = $this->resultsHomework->find((int) $_GET['id']);

        $resultsDataDisciplines = $this->resultsDisciplines->findAll(1000, 0);
        $resultsDataTeacher = $this->resultsTeacher->findAll(1000, 0);
        $resultsDataStudents = $this->resultsStudents->findAll(1000, 0);
        return $this->twig->render('homework_form.html.twig',
            [
                'hw_name' => $resultsData['hw_name'],
                'status' => $resultsData['status'],
                'disciplines_id' => $resultsData['disciplines_id'],
                'teacher_id' => $resultsData['teacher_id'],
                'student_id' => $resultsData['student_id'],
                'hw_id' => $resultsData['id'],
                'resultsDataDisciplines' => $resultsDataDisciplines,
                'resultsDataTeacher' => $resultsDataTeacher,
                'resultsDataStudents' => $resultsDataStudents,
                'action' => 'edit'
            ]
        );
    }

    /**
     * @return string
     */
    public function deleteAction()
    {
        if (isset($_POST['hw_id'])) {
            $id = (int) $_POST['hw_id'];
            $this->resultsHomework->remove(['id' => $id]);
            return $this->indexAction();
        }

        $resultsData = $this->resultsHomework->find((int) $_GET['id']);

        $resultsDataDisciplines = $this->resultsDisciplines->findAll(1000, 0);
        $resultsDataTeacher = $this->resultsTeacher->findAll(1000, 0);
        $resultsDataStudents = $this->resultsStudents->findAll(1000, 0);
        return $this->twig->render('homework_form.html.twig',
            [
                'hw_name' => $resultsData['hw_name'],
                'status' => $resultsData['status'],
                'disciplines_id' => $resultsData['disciplines_id'],
                'teacher_id' => $resultsData['teacher_id'],
                'student_id' => $resultsData['student_id'],
                'hw_id' => $resultsData['id'],
                'resultsDataDisciplines' => $resultsDataDisciplines,
                'resultsDataTeacher' => $resultsDataTeacher,
                'resultsDataStudents' => $resultsDataStudents,
                'action' => 'delete'
            ]
        );
    }
}
