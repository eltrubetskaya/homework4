<?php
/**
 * Created by PhpStorm.
 * User: elena
 * Date: 07.11.16
 * Time: 16:20
 */

namespace Controllers;

use Repositories\DepartmentRepository;
use Repositories\DisciplinesRepository;

class DisciplinesController
{
    private $resultsDisciplines;

    private $resultsDepartment;

    private $resultsData;

    private $loader;

    private $twig;

    /**
     * DisciplinesController constructor.
     * @param $connector
     */
    public function __construct($connector)
    {
        $this->resultsDepartment = new DepartmentRepository($connector);
        $this->resultsData = new DataController($connector);
        $this->resultsDisciplines = new DisciplinesRepository($connector);
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
        if (isset($_POST['disc_name'])) {
            $this->resultsDisciplines->insert(
                [
                    'disc_name' => $_POST['disc_name'],
                    'department_id'  => $_POST['department_id'],
                ]
            );
            return $this->resultsData->indexAction('disciplines');
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
    public function editAction($id)
    {
        if (isset($_POST['disc_name'])) {
            $this->resultsDisciplines->update(
                [
                    'disc_name' => $_POST['disc_name'],
                    'department_id'  => $_POST['department_id'],
                    'id'    => (int) $_POST['disc_id'],
                ]
            );
            return $this->resultsData->indexAction('disciplines');
        }

        $resultsData = $this->resultsDisciplines->find($id);

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
    public function deleteAction($id)
    {
        if (isset($_POST['disc_name'])) {
            $id = (int) $_POST['disc_id'];
            $this->resultsDisciplines->remove(['id' => $id]);
            return $this->resultsData->indexAction('disciplines');
        }

        $resultsData = $this->resultsDisciplines->find($id);
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
