<?php
/**
 * Created by PhpStorm.
 * User: elena
 * Date: 06.11.16
 * Time: 0:49
 */

namespace Controllers;

use Repositories\DataRepository;
use Repositories\UniversityRepository;
use Repositories\DepartmentRepository;

class DepartmentController
{
    private $repository;

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
        $this->repository = new DepartmentRepository($connector);
        $this->resultsUniversity = new UniversityRepository($connector);
        $this->resultsData = new DataRepository($connector);
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
        $resultsDataDepartment = $this->repository->findAll(1000, 0);
        return $this->twig->render('tables.html.twig', ['resultsDataUniversity' => $resultsDataUniversity, 'resultsDataDepartment' => $resultsDataDepartment ]);
    }

    /**
     * @return string
     */
    public function createAction()
    {
        if (isset($_POST['d_name'])) {
            $this->repository->insert(
                [
                    'd_name' => $_POST['d_name'],
                    'univer_id'  => $_POST['univer_id'],
                ]
            );
            return $this->indexAction();
        }
        return $this->twig->render('department_form.html.twig',
            [
                'd_name' => '',
                'univer_id' => '',
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
            $this->repository->update(
                [
                    'd_name' => $_POST['d_name'],
                    'univer_id'  => $_POST['univer_id'],
                    'id'    => (int) $_POST['depart_id'],
                ]
            );
            return $this->indexAction();
        }

        $resultsData = $this->repository->find((int) $_GET['id']);

        return $this->twig->render('department_form.html.twig',
            [
                'd_name' => $resultsData['d_name'],
                'univer_id' => $resultsData['univer_id'],
                'depart_id' => $resultsData['id'],
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
            $this->repository->remove(['id' => $id]);
            return $this->indexAction();
        }

        $resultsData = $this->repository->find((int) $_GET['id']);

        return $this->twig->render('department_form.html.twig',
            [
                'd_name' => $resultsData['d_name'],
                'univer_id' => $resultsData['univer_id'],
                'depart_id' => $resultsData['id'],
                'action' => 'delete'
            ]
        );
    }
}
