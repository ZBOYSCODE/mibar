<?php
	/*
	 * Define custom routes. File gets included in the router service definition.
	 */
	$router = new Phalcon\Mvc\Router();

	$router->add('/', array(
	    'controller'    =>  'welcome',
	    'action'        =>  'index'
	));

	$router->add('menu', array(
	    'controller'    =>  'menu',
	    'action'        =>  'index'
	));

	$router->add('/login', array(
	    'controller'    =>  'acceso',
	    'action'        =>  'login'
	));

	$router->add('/logout', array(
        'controller'    =>  'acceso',
        'action'        =>  'logout'
    ));

    $router->add('/cashbox/table/:params', array(
        'controller'    => 'cashbox',
        'action'        => 'table',
        'params'        => 1
    ));
	return $router;