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

class UniversityController
{
    private $resultsUniversity;

    private $resultsDepartment;

    private $resultsStudents;

    private $resultsDisciplines;

    private $loader;

    private $twig;

    /**
     * UniversityController constructor.
     * @param $connector
     */
    public function __construct($connector)
    {
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
        if (isset($_POST['univer_name'])) {
            $this->resultsUniversity->insert(
                [
                    'univer_name' => $_POST['univer_name'],
                    'city'  => $_POST['city'],
                    'site'      => $_POST['site'],
                ]
            );

            return $this->indexAction();
        }
        return $this->twig->render('university_form.html.twig',
            [
                'univer_name' => '',
                'city' => '',
                'site' => '',
                'action' => 'create'
            ]
        );
    }

    /**
     * @return string
     */
    public function editAction()
    {
        if (isset($_POST['univer_name'])) {
            $this->resultsUniversity->update(
                [
                    'univer_name' => $_POST['univer_name'],
                    'city'  => $_POST['city'],
                    'site'  => $_POST['site'],
                    'id'    => (int) $_POST['univer_id'],
                ]
            );
            return $this->indexAction();
        }

        $resultsData = $this->resultsUniversity->find((int) $_GET['id']);

        return $this->twig->render('university_form.html.twig',
            [
                'univer_name' => $resultsData['univer_name'],
                'city' => $resultsData['city'],
                'site' => $resultsData['site'],
                'univer_id' => $resultsData['id'],
                'action' => 'edit'
            ]
        );
    }

    /**
     * @return string
     */
    public function deleteAction()
    {
        if (isset($_POST['univer_id'])) {
            $id = (int) $_POST['univer_id'];
            $this->resultsUniversity->remove(['id' => $id]);
            return $this->indexAction();
        }

        $resultsData = $this->resultsUniversity->find((int) $_GET['id']);

        return $this->twig->render('university_form.html.twig',
            [
                'univer_name' => $resultsData['univer_name'],
                'city' => $resultsData['city'],
                'site' => $resultsData['site'],
                'univer_id' => $resultsData['id'],
                'action' => 'delete'
            ]
        );
    }
}
