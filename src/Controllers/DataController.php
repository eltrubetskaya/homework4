<?php
/**
 * Created by PhpStorm.
 * User: elena
 * Date: 05.11.16
 * Time: 19:09
 */

namespace Controllers;

use Repositories\DataRepository;
use Repositories\UniversityRepository;
use Repositories\DepartmentRepository;

class DataController
{
    private $repository;

    private $resultsUniversity;

    private $resultsDepartment;

    private $loader;

    private $twig;

    public function __construct($connector)
    {
        $this->repository = new DataRepository($connector);
        $this->resultsUniversity = new UniversityRepository($connector);
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
        if (isset($_POST['create_db'])) {
            echo exec($this->repository->getDumpConnector());
        }
        $resultsDataUniversity = $this->resultsUniversity->findAll(1000, 0);
        $resultsDataDepartment = $this->resultsDepartment->findAll(1000, 0);
        return $this->twig->render('tables.html.twig', ['resultsDataUniversity' => $resultsDataUniversity, 'resultsDataDepartment' => $resultsDataDepartment ]);
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
        return $this->twig->render('tables.html.twig', ['resultsDataUniversity' => $resultsDataUniversity, 'resultsDataDepartment' => $resultsDataDepartment]);
    }
}
