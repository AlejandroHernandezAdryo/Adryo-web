<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 */

App::uses('Controller', 'Controller');
App::uses('CakeEmail', 'Network/Email');


/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

	var $estados_republica = array(
		"Aguascalientes" => "Aguascalientes", "Baja California" => "Baja California", "Baja California Sur" => "Baja California Sur", "Campeche" => "Campeche", "Chiapas" => "Chiapas", "Chihuahua" => "Chihuahua", "Ciudad de México" => "Ciudad de México", "Coahuila " => "Coahuila ", "Colima" => "Colima", "Durango" => "Durango", "Estado de México" => "Estado de México", "Guanajuato" => "Guanajuato", "Guerrero" => "Guerrero", "Hidalgo" => "Hidalgo", "Jalisco" => "Jalisco", "Michoacán" => "Michoacán", "Morelos" => "Morelos", "Nayarit" => "Nayarit", "Nuevo León" => "Nuevo León", "Oaxaca" => "Oaxaca", "Puebla" => "Puebla", "Querétaro" => "Querétaro", "Quintana Roo" => "Quintana Roo", "San Luis Potosí" => "San Luis Potosí", "Sinaloa" => "Sinaloa", "Sonora" => "Sonora", "Tabasco" => "Tabasco", "Tamaulipas" => "Tamaulipas", "Tlaxcala" => "Tlaxcala", "Veracruz" => "Veracruz", "Yucatán" => "Yucatán", "Zacatecas" => "Zacatecas"
	);
	
	function beforeFilter(){
		
		// loginAction defines the action which should be used to login. By default users/login
		$this->Auth->loginAction = array('controller' => 'users', 'action' => 'login');

		// loginRedirect defines the action called after user is logged in first time.
		$this->Auth->loginRedirect = array('controller' => 'users', 'action' => 'dashboard');

		// Allows the display action to be accessed without user login.
		$this->Auth->allow('display');
		
		$this->loadModel('Factura');
		$this->Session->write(
			'facturas_por_autorizar',
			$this->Factura->find(
				'count',
				array(
					'conditions'=>array(
						'Factura.aut_pendiente'=> $this->Session->read('Auth.User.id'),
						'Factura.estado IN (0,1,4)'
					)
				)
			)
		);
		setlocale(LC_TIME, "es_MX.UTF-8");

	}

	/* -------------------------------------------------------------------------- */
	/*                                 Components                                 */
	/* -------------------------------------------------------------------------- */
	public $components = array(
		'Session',
		'RequestHandler',
		'Auth' => array(
			'authenticate'=> array(
				'Form'=>array(
					'fields'=>array('username'=>'correo_electronico')
				)
			)
		),
		'DebugKit.Toolbar'
	);
}
