<?php
/**
 * Created by PhpStorm.
 * User: elena
 * Date: 10.11.16
 * Time: 22:55
 */

use Symfony\Component\Routing;

$routes = new Routing\RouteCollection();

$routes->add('data_index', new Routing\Route('/data', array('controller' => 'DataController', 'action' => 'indexAction')));
$routes->add('data_create', new Routing\Route('/', array('controller' => 'DataController', 'action' => 'createAction')));
$routes->add('data_insert', new Routing\Route('/data/insert', array('controller' => 'DataController', 'action' => 'insertAction')));

$routes->add('university_create', new Routing\Route('/university/create', array('controller' => 'UniversityController', 'action' => 'createAction')));
$routes->add('university_edit', new Routing\Route('/university/edit/{id}', array('controller' => 'UniversityController', 'id' => '{id}', 'action' => 'editAction')));
$routes->add('university_delete', new Routing\Route('/university/delete/{id}', array('controller' => 'UniversityController', 'id' => '{id}', 'action' => 'deleteAction')));

$routes->add('departmen_create', new Routing\Route('/departmen/create', array('controller' => 'DepartmenController', 'action' => 'createAction')));
$routes->add('departmen_edit', new Routing\Route('/departmen/edit/{id}', array('controller' => 'DepartmenController', 'id' => '{id}', 'action' => 'editAction')));
$routes->add('departmen_delete', new Routing\Route('/departmen/delete/{id}', array('controller' => 'DepartmenController', 'id' => '{id}', 'action' => 'deleteAction')));

$routes->add('disciplines_create', new Routing\Route('/disciplines/create', array('controller' => 'DisciplinesController', 'action' => 'createAction')));
$routes->add('disciplines_edit', new Routing\Route('/disciplines/edit/{id}', array('controller' => 'DisciplinesController', 'id' => '{id}', 'action' => 'editAction')));
$routes->add('disciplines_delete', new Routing\Route('/disciplines/delete/{id}', array('controller' => 'DisciplinesController', 'id' => '{id}', 'action' => 'deleteAction')));

$routes->add('students_create', new Routing\Route('/students/create', array('controller' => 'StudentsController', 'action' => 'createAction')));
$routes->add('students_edit', new Routing\Route('/students/edit/{id}', array('controller' => 'StudentsController', 'id' => '{id}', 'action' => 'editAction')));
$routes->add('students_delete', new Routing\Route('/students/delete/{id}', array('controller' => 'StudentsController', 'id' => '{id}', 'action' => 'deleteAction')));

$routes->add('teacher_create', new Routing\Route('/teacher/create', array('controller' => 'TeacherController', 'action' => 'createAction')));
$routes->add('teacher_edit', new Routing\Route('/teacher/edit/{id}', array('controller' => 'TeacherController', 'id' => '{id}', 'action' => 'editAction')));
$routes->add('teacher_delete', new Routing\Route('/teacher/delete/{id}', array('controller' => 'TeacherController', 'id' => '{id}', 'action' => 'deleteAction')));

$routes->add('homework_create', new Routing\Route('/homework/create', array('controller' => 'HomeworkController', 'action' => 'createAction')));
$routes->add('homework_edit', new Routing\Route('/homework/edit/{id}', array('controller' => 'HomeworkController', 'id' => '{id}', 'action' => 'editAction')));
$routes->add('homework_delete', new Routing\Route('/homework/delete/{id}', array('controller' => 'HomeworkController', 'id' => '{id}', 'action' => 'deleteAction')));

return $routes;
