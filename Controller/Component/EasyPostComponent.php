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
	public function AddressCreate($params, $type = 'array') {
		if($type == 'array'){
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
	public function AddressCreateAndVerify($params, $type = 'array') {
		if($type == 'array'){
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
	public function AddressVerify($params, $type = 'array') {
		if($type == 'array'){
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
	public function AddressRetrieve($params, $type = 'array') {
		if($type == 'array'){
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
	public function AddressAll($type = 'array'){
		if($type == 'array'){
			$return = array();
			foreach (\EasyPost\Address::all() as $address) {
				array_push($return, json_decode($address, true));	
			}
			return $return;
		} else {
			return \EasyPost\Address::all();
		}
	}

	public function AddressSave($params, $type = 'array') {
		if($type == 'array'){
			return json_decode(\EasyPost\Address::save($params), true);
		} else {
			return \EasyPost\Address::save($params);
		}
	}

	public function BatchRetrieve($params, $type = 'array'){
		if($type == 'array'){
			return json_decode(\EasyPost\Batch::retrieve($params), true);
		} else {
			return \EasyPost\Batch::retrieve($params);
		}

	}

	public function BatchAll($type = 'array'){
		if($type == 'array'){
			$return = array();
			foreach (\EasyPost\Batch::all() as $batch) {
				array_push($return, json_decode($batch, true));	
			}
			return $return;
		} else {
			return \EasyPost\Batch::all();
		}
	}

	public function BatchCreate($params, $type = 'array') {
		if($type == 'array'){
			return json_decode(\EasyPost\Batch::create($params), true);
		} else {
			return \EasyPost\Batch::create($params);
		}
	}

	public function BatchCreateAndBuy($params, $type = 'array') {
		if($type == 'array'){
			return json_decode(\EasyPost\Batch::create_and_buy($params), true);
		} else {
			return \EasyPost\Batch::create_and_buy($params);
		}
	}

	public function BatchBuy($params, $type = 'array') {
		if($type == 'array'){
			return json_decode(\EasyPost\Batch::buy($params), true);
		} else {
			return \EasyPost\Batch::buy($params);
		}
	}

	public function BatchLabel($params, $type = 'array') {
		if($type == 'array'){
			return json_decode(\EasyPost\Batch::label($params), true);
		} else {
			return \EasyPost\Batch::label($params);
		}
	}

	public function BatchRemoveShipments($params, $type = 'array') {
		if($type == 'array'){
			return json_decode(\EasyPost\Batch::remove_shipments($params), true);
		} else {
			return \EasyPost\Batch::remove_shipments($params);
		}
	}

	public function BatchAddShipments($params, $type = 'array') {
		if($type == 'array'){
			return json_decode(\EasyPost\Batch::add_shipments($params), true);
		} else {
			return \EasyPost\Batch::add_shipments($params);
		}
	}

	public function BatchCreateScanForm($params, $type = 'array') {
		if($type == 'array'){
			return json_decode(\EasyPost\Batch::create_scan_form($params), true);
		} else {
			return \EasyPost\Batch::create_scan_form($params);
		}
	}

	public function CustomsInfoRetrieve($params, $type = 'array') {
		if($type == 'array'){
			return json_decode(\EasyPost\CustomsInfo::retrieve($params), true);
		} else {
			return \EasyPost\CustomsInfo::retrieve($params);
		}
	}

	public function CustomeInfoAll($params, $type = 'array') {
		if($type == 'array'){
			$return = array();
			foreach (\EasyPost\CustomsInfo::all() as $customsinfo) {
				array_push($return, json_decode($customsinfo, true));	
			}
			return $return;
		} else {
			return \EasyPost\CustomsInfo::all();
		}
	}

	public function CustomsInfoCreate($params, $type = 'array') {
		if($type == 'array'){
			return json_decode(\EasyPost\CustomsInfo::create($params), true);
		} else {
			return \EasyPost\CustomsInfo::create($params);
		}
	}

	public function CustomsInfoSave($params, $type = 'array') {
		if($type == 'array'){
			return json_decode(\EasyPost\CustomsInfo::save($params), true);
		} else {
			return \EasyPost\CustomsInfo::save($params);
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
	public function ParcelCreate($params, $type = 'array'){
		if($type == 'array'){
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
	public function ParcelRetrieve($params, $type = 'array'){
		if($type == 'array'){
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
	public function ParcelAll($type = 'array'){
		if($type == 'array'){
			$return = array();
			foreach (\EasyPost\Parcel::all() as $parcel) {
				array_push($return, json_decode($parcel, true));	
			}
			return $return;
		} else {
			return \EasyPost\Parcel::all();
		}
	}

	public function ParcelSave($params, $type = 'array'){
		if($type == 'array'){
			return json_decode(\EasyPost\Parcel::save($params), true);
		} else {
			return \EasyPost\Parcel::save($params);
		}
	}

	public function PostageLabelRetrieve($params, $type = 'array'){
		if($type == 'array'){
			return json_decode(\EasyPost\PostageLabel::retrieve($params), true);
		} else {
			return \EasyPost\PostageLabel::retrieve($params);
		}
	}

	public function PostageLabelAll($type = 'array'){
		if($type == 'array'){
			$return = array();
			foreach (\EasyPost\PostageLabel::all() as $postagelabel) {
				array_push($return, json_decode($postagelabel, true));	
			}
			return $return;
		} else {
			return \EasyPost\PostageLabel::all();
		}
	}

	public function PostageLabelCreate($params, $type = 'array'){
		if($type == 'array'){
			return json_decode(\EasyPost\PostageLabel::create($params), true);
		} else {
			return \EasyPost\PostageLabel::create($params);
		}
	}

	public function PostageLabelSave($params, $type = 'array'){
		if($type == 'array'){
			return json_decode(\EasyPost\PostageLabel::save($params), true);
		} else {
			return \EasyPost\PostageLabel::save($params);
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

	public function RateRetrieve($params, $type = 'array'){
		if($type == 'array'){
			return json_decode(\EasyPost\Rate::retrieve($params), true);
		} else {
			return \EasyPost\Rate::retrieve($params);
		}
	}

	public function RateAll($type = 'array'){
		if($type == 'array'){
			$return = array();
			foreach (\EasyPost\Rate::all() as $rate) {
				array_push($return, json_decode($rate, true));	
			}
			return $return;
		} else {
			return \EasyPost\Rate::all();
		}
	}

	public function RateCreate($params, $type = 'array'){
		if($type == 'array'){
			return json_decode(\EasyPost\Rate::create($params), true);
		} else {
			return \EasyPost\Rate::create($params);
		}
	}

	public function RateSave($params, $type = 'array'){
		if($type == 'array'){
			return json_decode(\EasyPost\Rate::save($params), true);
		} else {
			return \EasyPost\Rate::save($params);
		}
	}

	public function RefundRetrieve($params, $type = 'array'){
		if($type == 'array'){
			return json_decode(\EasyPost\Refund::retrieve($params), true);
		} else {
			return \EasyPost\Refund::retrieve($params);
		}
	}

	public function RefundAll($type = 'array'){
		if($type == 'array'){
			$return = array();
			foreach (\EasyPost\Refund::all() as $refund) {
				array_push($return, json_decode($refund, true));	
			}
			return $return;
		} else {
			return \EasyPost\Refund::all();
		}
	}

	public function RefundCreate($params, $type = 'array'){
		if($type == 'array'){
			return json_decode(\EasyPost\Refund::create($params), true);
		} else {
			return \EasyPost\Refund::create($params);
		}
	}

	public function ScanFormRetrieve($params, $type = 'array'){
		if($type == 'array'){
			return json_decode(\EasyPost\ScanForm::retrieve($params), true);
		} else {
			return \EasyPost\ScanForm::retrieve($params);
		}
	}

	public function ScanFormAll($type = 'array'){
		if($type == 'array'){
			$return = array();
			foreach (\EasyPost\ScanForm::all() as $scanform) {
				array_push($return, json_decode($scanform, true));	
			}
			return $return;
		} else {
			return \EasyPost\ScanForm::all();
		}
	}

	public function ScanFormCreate($params, $type = 'array'){
		if($type == 'array'){
			return json_decode(\EasyPost\ScanForm::create($params), true);
		} else {
			return \EasyPost\ScanForm::create($params);
		}
	}

	public function ScanFormSave($params, $type = 'array'){
		if($type == 'array'){
			return json_decode(\EasyPost\ScanForm::save($params), true);
		} else {
			return \EasyPost\ScanForm::save($params);
		}
	}

	public function ShipmentRetrieve($params, $type = 'array'){
		if($type == 'array'){
			return json_decode(\EasyPost\Shipment::retrieve($params), true);
		} else {
			return \EasyPost\Shipment::retrieve($params);
		}
	}

	public function ShipmentAll($type = 'array'){
		if($type == 'array'){
			$return = array();
			foreach (\EasyPost\Shipment::all() as $shipment) {
				array_push($return, json_decode($shipment, true));	
			}
			return $return;
		} else {
			return \EasyPost\Shipment::all();
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
		if($type == 'array'){
			return json_decode(\EasyPost\Shipment::create($params), true);
		} else {
			return \EasyPost\Shipment::create($params);
		}
	}

	public function ShipmentCreateFromTrackingCode($params, $type = 'array'){
		if($type == 'array'){
			return json_decode(\EasyPost\Shipment::create_from_tracking_code($params), true);
		} else {
			return \EasyPost\Shipment::create_from_tracking_code($params);
		}
	}

	public function ShipmentSave($params, $type = 'array'){
		if($type == 'array'){
			return json_decode(\EasyPost\Shipment::save($params), true);
		} else {
			return \EasyPost\Shipment::save($params);
		}
	}

	public function ShipmentGetRates($params, $type = 'array'){
		if($type == 'array'){
			return json_decode(\EasyPost\Shipment::get_rates($params), true);
		} else {
			return \EasyPost\Shipment::get_rates($params);
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

	public function ShipmentRefund($params, $type = 'array'){
		if($type == 'array'){
			return json_decode(\EasyPost\Shipment::refund($params), true);
		} else {
			return \EasyPost\Shipment::refund($params);
		}
	}

	public function ShipmentBarcode($params, $type = 'array'){
		if($type == 'array'){
			return json_decode(\EasyPost\Shipment::barcode($params), true);
		} else {
			return \EasyPost\Shipment::barcode($params);
		}
	}

	public function ShipmentStamp($params, $type = 'array'){
		if($type == 'array'){
			return json_decode(\EasyPost\Shipment::stamp($params), true);
		} else {
			return \EasyPost\Shipment::stamp($params);
		}
	}

	public function ShipmentLabel($params, $type = 'array'){
		if($type == 'array'){
			return json_decode(\EasyPost\Shipment::label($params), true);
		} else {
			return \EasyPost\Shipment::label($params);
		}
	}

	public function ShipmentInsure($params, $type = 'array'){
		if($type == 'array'){
			return json_decode(\EasyPost\Shipment::insure($params), true);
		} else {
			return \EasyPost\Shipment::insure($params);
		}
	}

	public function ShipmentLowestRate($params, $type = 'array'){
		if($type == 'array'){
			return json_decode(\EasyPost\Shipment::lowest_rate($params), true);
		} else {
			return \EasyPost\Shipment::lowest_rate($params);
		}
	}

	public function TrackerRetrieve($params, $type = 'array'){
		if($type == 'array'){
			return json_decode(\EasyPost\Tracker::retrieve($params), true);
		} else {
			return \EasyPost\Tracker::retrieve($params);
		}
	}

	public function TrackerAll($type = 'array'){
		if($type == 'array'){
			$return = array();
			foreach (\EasyPost\Tracker::all() as $tracker) {
				array_push($return, json_decode($tracker, true));	
			}
			return $return;
		} else {
			return \EasyPost\Tracker::all();
		}
	}

	public function TrackerCreate($params, $type = 'array'){
		if($type == 'array'){
			return json_decode(\EasyPost\Tracker::create($params), true);
		} else {
			return \EasyPost\Tracker::create($params);
		}
	}

	public function TrackerSave($params, $type = 'array'){
		if($type == 'array'){
			return json_decode(\EasyPost\Tracker::save($params), true);
		} else {
			return \EasyPost\Tracker::save($params);
		}
	}
}	