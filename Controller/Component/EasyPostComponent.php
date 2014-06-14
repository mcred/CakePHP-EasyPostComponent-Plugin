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

		//Check if EasyPost class is loaded
		if (!class_exists('\EasyPost\EasyPost')) {
			throw new CakeException('EasyPost Libray is missing or could not be loaded.');
		}

		// if mode is set in bootstrap.php, use it. otherwise, Test.
		$mode = Configure::read('EasyPost.Mode');
		if ($mode) {
			$this->mode = $mode;
		}

		// set the EasyPost API key
		$this->key = Configure::read('EasyPost.' . $this->mode . '.ApiKey');
		if (!$this->key) {
			throw new CakeException('EasyPost API key is not set.');
		}

		\EasyPost\EasyPost::setApiKey($this->key);
	}

/**
 * The AddressCreate method creates a new address object.
 * 
 *
 * @param array $params collected address information.
 * @param string $type desired response format.
 * @return object/array $address if success, boolean false if failure or not found.
 */
	public function AddressCreate($params, $type = 'json') {
		if($type == 'json'){
			return json_decode(\EasyPost\Address::create($params), true);
		} else {
			return \EasyPost\Address::create($params);
		}
	}

/**
 * The AddressCreateAndVerify method creates and verifies if an address is valid.
 * USA addresses only.
 *
 * @param object $params an address object.
 * @param string $type desired response format.
 * @return object/array $address if success, boolean false if failure or not found.
 */
	public function AddressCreateAndVerify($params, $type = 'json') {
		if($type == 'json'){
			return json_decode(\EasyPost\Address::create_and_verify($params), true);
		} else {
			return \EasyPost\Address::create_and_verify($params);
		}
	}

/**
 * The AddressVerify method verifies if an address is valid.
 * USA addresses only.
 *
 * @param object $params an address object.
 * @param string $type desired response format.
 * @return object/array $address if success, boolean false if failure or not found.
 */
	public function AddressVerify($params, $type = 'json') {
		if($type == 'json'){
			return json_decode($params->verify(), true);
		} else {
			return $params->verify();
		}
	}

/**
 * The AddressRetrieve method retrieves an address object.
 * 
 *
 * @param string $params an address object id.
 * @param string $type desired response format.
 * @return object/array $address if success, boolean false if failure or not found.
 */
	public function AddressRetrieve($params, $type = 'json') {
		if($type == 'json'){
			return json_decode(\EasyPost\Address::retrieve($params), true);
		} else {
			return \EasyPost\Address::retrieve($params);
		}
	}

/**
 * The AddressAll method retrieves all address objects.
 * 
 *
 * @param string $type desired response format.
 * @return object/array $addresses if success, boolean false if failure or not found.
 */
	public function AddressAll($type = 'json'){
		if($type == 'json'){
			$return = array();
			foreach (\EasyPost\Address::all() as $address) {
				array_push($return, json_decode($address, true));	
			}
			return $return;
		} else {
			return \EasyPost\Address::all();
		}
	}








	public function BatchRetreive($params, $type = 'json'){
		if($type == 'json'){
			return json_decode(\EasyPost\Batch::retrieve($params), true);
		} else {
			return \EasyPost\Batch::retrieve($params);
		}

	}

	public function BatchAll($type = 'json'){
		if($type == 'json'){
			$return = array();
			foreach (\EasyPost\Batch::all() as $batch) {
				array_push($return, json_decode($batch, true));	
			}
			return $return;
		} else {
			return \EasyPost\Batch::all();
		}

	}

	public function BatchCreate($params, $type = 'json') {
		if($type == 'json'){
			return json_decode(\EasyPost\Batch::create($params), true);
		} else {
			return \EasyPost\Batch::create($params);
		}
	}

	public function BatchCreateAndBuy($params, $type = 'json') {
		if($type == 'json'){
			return json_decode(\EasyPost\Batch::create_and_buy($params), true);
		} else {
			return \EasyPost\Batch::create_and_buy($params);
		}
	}

	public function BatchBuy($params, $type = 'json') {
		if($type == 'json'){
			return json_decode(\EasyPost\Batch::buy($params), true);
		} else {
			return \EasyPost\Batch::buy($params);
		}
	}

	public function BatchLabel($params, $type = 'json') {
		if($type == 'json'){
			return json_decode(\EasyPost\Batch::label($params), true);
		} else {
			return \EasyPost\Batch::label($params);
		}
	}

	public function BatchRemoveShipments($params, $type = 'json') {
		if($type == 'json'){
			return json_decode(\EasyPost\Batch::remove_shipments($params), true);
		} else {
			return \EasyPost\Batch::remove_shipments($params);
		}
	}

	public function BatchAddShipments($params, $type = 'json') {
		if($type == 'json'){
			return json_decode(\EasyPost\Batch::add_shipments($params), true);
		} else {
			return \EasyPost\Batch::add_shipments($params);
		}
	}

	public function BatchCreateScanForm($params, $type = 'json') {
		if($type == 'json'){
			return json_decode(\EasyPost\Batch::create_scan_form($params), true);
		} else {
			return \EasyPost\Batch::create_scan_form($params);
		}
	}




/**
 * The ParcelCreate method creates a new parcel object.
 * 
 *
 * @param array $params collected parcel information.
 * @param string $type desired response format.
 * @return object/array $parcel if success, boolean false if failure or not found.
 */
	public function ParcelCreate($params, $type = 'json'){
		if($type == 'json'){
			return json_decode(\EasyPost\Parcel::create($params), true);
		} else {
			return \EasyPost\Parcel::create($params);
		}
	}

/**
 * The ParcelRetrieve method retrieves a parcel object.
 * 
 *
 * @param string $params an address object id.
 * @param string $type desired response format.
 * @return object/array $parcel if success, boolean false if failure or not found.
 */
	public function ParcelRetrieve($params, $type = 'json'){
		if($type == 'json'){
			return json_decode(\EasyPost\Parcel::retrieve($params), true);
		} else {
			return \EasyPost\Parcel::retrieve($params);
		}
	}

/**
 * The ParcelAll method retrieves all parcel objects.
 * 
 *
 * @param string $type desired response format.
 * @return object/array $parcels if success, boolean false if failure or not found.
 */
	public function ParcelAll($type = 'json'){
		if($type == 'json'){
			$return = array();
			foreach (\EasyPost\Parcel::all() as $parcel) {
				array_push($return, json_decode($parcel, true));	
			}
			return $return;
		} else {
			return \EasyPost\Parcel::all();
		}
	}

/**
 * The ShipmentCreate creates a shipment object.
 * 
 *
 * @param array $params collected parcel information.
 * @param string $type desired response format.
 * @return object/array $parcel if success, boolean false if failure or not found.
 */
	public function ShipmentCreate($params, $type = 'obj'){
		if($type == 'json'){
			return json_decode(\EasyPost\Shipment::create($params), true);
		} else {
			return \EasyPost\Shipment::create($params);
		}
	}

/**
 * The ShipmentBuy method buys postage for a shipment object.
 * 
 *
 * @param object $params collected parcel information.
 * @param string $rate desired shipping rate.
 * @return object/array $parcel if success, boolean false if failure or not found.
 */
	public function ShipmentBuy($params, $rate = 'lowest'){
		if($rate == 'lowest'){
			return $params->buy($params->lowest_rate());
		}
	}

/**
 * The PostageLabelURL method returns a URL for postage label.
 * 
 *
 * @param object $params collected shipment information.
 * @return string $url if success, boolean false if failure or not found.
 */
	public function PostageLabelURL($params){
		return $params->postage_label->label_url;
	}
}