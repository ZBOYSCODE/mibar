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

    
	return $router;