<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
	Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home','_ssl'=>true));
        //Router::connect('/', array('controller' => 'pages', 'action' => 'home','_ssl'=>true));
        Router::connect('/login',array('controller' => 'users', 'action'=>'login'));
        Router::connect('/modulos/cartera-clientes',array('controller' => 'pages', 'action'=>'display','cartera-clientes'));
        Router::connect('/modulos/corretaje',array('controller' => 'pages', 'action'=>'display','corretaje'));
        Router::connect('/modulos/desarrollos',array('controller' => 'pages', 'action'=>'display','desarrollos'));
        Router::connect('/modulos/desarrolladores',array('controller' => 'pages', 'action'=>'display','desarrolladores'));
        Router::connect('/nosotros',array('controller' => 'pages', 'action'=>'display','inmosystem'));
        Router::connect('/solicita-prueba',array('controller' => 'pages', 'action'=>'display','solicita_prueba'));
        Router::connect('/planes',array('controller' => 'pages', 'action'=>'display','planes'));
        Router::connect('/contacto',array('controller' => 'pages', 'action'=>'display','contacto'));
        Router::connect('/privacidad',array('controller' => 'pages', 'action'=>'display','privacidad'));
        Router::connect('/terminos-condiciones',array('controller' => 'pages', 'action'=>'display','tyc'));
/**
 * ...and connect the rest of 'Pages' controller's URLs.
 */
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display','_ssl'=>true));

/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();
        Router::parseExtensions('pdf');

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
        
        
       
