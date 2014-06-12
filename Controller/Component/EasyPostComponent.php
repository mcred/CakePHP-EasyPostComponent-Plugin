<?php
/**
 * EasyPostComponent
 *
 * A component that handles postage calculation and purchase with https://www.easypost.com/
 *
 * PHP version 5
 *
 * @package		EasyPostComponent
 * @author		Derek Smart <dereksmart@earthlink.net>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link		https://github.com/mcred/CakePHP-EasyPostComponent-Plugin
 */

App::uses('Component', 'Controller');

/**
 * EasyPostComponent
 *
 * @package		EasyPostComponent
 */
class EasyPostComponent extends Component {

/**
 * Default EasyPost mode to use: Test or Live
 *
 * @var string
 * @access public
 */
	public $mode = 'Test';

/**
 * Controller startup. Loads the EasyPost API library and sets options from
 * APP/Config/bootstrap.php.
 *
 * @param Controller $controller Instantiating controller
 * @return void
 * @throws CakeException
 * @throws CakeException
 */
	public function startup(Controller $controller) {
		$this->Controller = $controller;

		// load the EasyPost vendor class
		App::import(
			'Vendor', 
			'EasyPost.easypost', 
			array('file' => 'easypost-php' . DS . 'lib' . DS . 'easypost.php')
		);

		/*
		if (!class_exists('EasyPost')) {
			throw new CakeException('EasyPost Libray is missing or could not be loaded.');
		}
		*/

		// set the EasyPost API key
		$this->key = Configure::read('EasyPost.' . $this->mode . '.ApiKey');
		if (!$this->key) {
			throw new CakeException('EasyPost API key is not set.');
		}

		\EasyPost\EasyPost::setApiKey($this->key);

	}

	public function AddressCreate($address_params) {
		return json_decode(\EasyPost\Address::create($address_params), true);
	}

	public function AddressRetrieve($id) {
		return json_decode(\EasyPost\Address::retrieve($id), true);
	}

	public function AddressVerify($address_params) {
		return json_decode(\EasyPost\Address::verify($address_params), true);
	}

	public function AddressCreateAndVerify($address_params) {
		return json_decode(\EasyPost\Address::create_and_verify($address_params), true);
	}

	public function AddressAll(){
		$return = array();
		foreach (\EasyPost\Address::all() as $address) {
			array_push($return, json_decode($address, true));	
		}
		return $return;
	}

	public function ParcelCreate($parcel){
		return json_decode(\EasyPost\Parcel::create($parcel), true);
	}

	public function ParcelRetrieve($id){
		return json_decode(\EasyPost\Parcel::retrieve($id), true);
	}

	public function ParcelAll(){
		$return = array();
		foreach (\EasyPost\Parcel::all() as $parcel) {
			array_push($return, json_decode($parcel, true));	
		}
		return $return;
	}













}