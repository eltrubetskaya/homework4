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

class DepartmentController
{
    private $resultsDepartment;

    private $resultsUniversity;

    private $resultsData;

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
        $this->resultsData = new DataController($connector);
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
        if (isset($_POST['d_name'])) {
            $this->resultsDepartment->insert(
                [
                    'd_name' => $_POST['d_name'],
                    'univer_id'  => $_POST['univer_id'],
                ]
            );
            return $this->resultsData->indexAction('department');
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
    public function editAction($id)
    {
        if (isset($_POST['d_name'])) {
            $this->resultsDepartment->update(
                [
                    'd_name' => $_POST['d_name'],
                    'univer_id'  => $_POST['univer_id'],
                    'id'    => (int) $_POST['depart_id'],
                ]
            );
            return $this->resultsData->indexAction('department');
        }

        $resultsData = $this->resultsDepartment->find($id);

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
    public function deleteAction($id)
    {
        if (isset($_POST['d_name'])) {
            $id = (int) $_POST['depart_id'];
            $this->resultsDepartment->remove(['id' => $id]);
            return $this->resultsData->indexAction('department');
        }

        $resultsData = $this->resultsDepartment->find($id);

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
