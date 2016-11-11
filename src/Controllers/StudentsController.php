<?php
/**
 * Created by PhpStorm.
 * User: elena
 * Date: 07.11.16
 * Time: 15:33
 */

namespace Controllers;

use Repositories\StudentsRepository;

class StudentsController
{
    private $resultsStudents;

    private $resultsData;

    private $loader;

    private $twig;

    /**
     * StudentsController constructor.
     * @param $connector
     */
    public function __construct($connector)
    {
        $this->resultsData = new DataController($connector);
        $this->resultsStudents = new StudentsRepository($connector);
        $this->loader = new \Twig_Loader_Filesystem('src/Views/templates/');
        $this->twig = new \Twig_Environment($this->loader, array(
            'cache' => false,
        ));
    }

    /**
     * @return string
     */
    public function createAction()
    {
        if (isset($_POST['first_name'])) {
            $this->resultsStudents->insert(
                [
                    'first_name' => $_POST['first_name'],
                    'last_name'  => $_POST['last_name'],
                    'email'      => $_POST['email'],
                    'tel'        => $_POST['tel'],
                ]
            );

            return $this->resultsData->indexAction('students');
        }
        return $this->twig->render('students_form.html.twig',
            [
                'first_name' => '',
                'last_name' => '',
                'email' => '',
                'tel' => '',
                'action' => 'create'
            ]
        );
    }

    /**
     * @return string
     */
    public function editAction($id)
    {
        if (isset($_POST['first_name'])) {
            $this->resultsStudents->update(
                [
                    'first_name' => $_POST['first_name'],
                    'last_name'  => $_POST['last_name'],
                    'email'      => $_POST['email'],
                    'tel'        => $_POST['tel'],
                    'id'    => (int) $_POST['student_id'],
                ]
            );
            return $this->resultsData->indexAction('students');
        }

        $resultsData = $this->resultsStudents->find($id);

        return $this->twig->render('students_form.html.twig',
            [
                'first_name' => $resultsData['first_name'],
                'last_name' => $resultsData['last_name'],
                'email' => $resultsData['email'],
                'tel' => $resultsData['tel'],
                'student_id' => $resultsData['id'],
                'action' => 'edit'
            ]
        );
    }

    /**
     * @return string
     */
    public function deleteAction($id)
    {
        if (isset($_POST['student_id'])) {
            $id = (int) $_POST['student_id'];
            $this->resultsStudents->remove(['id' => $id]);
            return $this->resultsData->indexAction('students');
        }

        $resultsData = $this->resultsStudents->find($id);

        return $this->twig->render('students_form.html.twig',
            [
                'first_name' => $resultsData['first_name'],
                'last_name' => $resultsData['last_name'],
                'email' => $resultsData['email'],
                'tel' => $resultsData['tel'],
                'student_id' => $resultsData['id'],
                'action' => 'delete'
            ]
        );
    }
}
