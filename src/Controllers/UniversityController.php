<?php
/**
 * Created by PhpStorm.
 * User: elena
 * Date: 06.11.16
 * Time: 0:49
 */

namespace Controllers;

use Repositories\UniversityRepository;

class UniversityController
{
    private $resultsData;

    private $resultsUniversity;

    private $loader;

    private $twig;

    /**
     * UniversityController constructor.
     * @param $connector
     */
    public function __construct($connector)
    {
        $this->resultsData = new DataController($connector);
        $this->resultsUniversity = new UniversityRepository($connector);
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
        if (isset($_POST['univer_name'])) {
            $this->resultsUniversity->insert(
                [
                    'univer_name' => $_POST['univer_name'],
                    'city'  => $_POST['city'],
                    'site'      => $_POST['site'],
                ]
            );

            return $this->resultsData->indexAction('university');
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
    public function editAction($id)
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
            return $this->resultsData->indexAction('university');
        }

        $resultsData = $this->resultsUniversity->find($id);

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
    public function deleteAction($id)
    {
        if (isset($_POST['univer_id'])) {
            $id = (int) $_POST['univer_id'];
            $this->resultsUniversity->remove(['id' => $id]);
            return $this->resultsData->indexAction('university');
        }

        $resultsData = $this->resultsUniversity->find($id);

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
