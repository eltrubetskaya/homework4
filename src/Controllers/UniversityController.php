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

class UniversityController
{
    private $repository;

    private $resultsData;

    private $resultsDepartment;

    private $loader;

    private $twig;

    /**
     * UniversityController constructor.
     * @param $connector
     */
    public function __construct($connector)
    {
        $this->repository = new UniversityRepository($connector);
        $this->resultsData = new DataRepository($connector);
        $this->resultsDepartment = new DepartmentRepository($connector);
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
        $resultsDataUniversity = $this->repository->findAll(1000, 0);
        $resultsDataDepartment = $this->resultsDepartment->findAll(1000, 0);
        return $this->twig->render('tables.html.twig', ['resultsDataUniversity' => $resultsDataUniversity, 'resultsDataDepartment' => $resultsDataDepartment ]);
    }

    /**
     * @return string
     */
    public function createAction()
    {
        if (isset($_POST['univer_name'])) {
            $this->repository->insert(
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
            $this->repository->update(
                [
                    'univer_name' => $_POST['univer_name'],
                    'city'  => $_POST['city'],
                    'site'  => $_POST['site'],
                    'id'    => (int) $_POST['univer_id'],
                ]
            );
            return $this->indexAction();
        }

        $resultsData = $this->repository->find((int) $_GET['id']);

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
            $this->repository->remove(['id' => $id]);
            return $this->indexAction();
        }

        $resultsData = $this->repository->find((int) $_GET['id']);

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
