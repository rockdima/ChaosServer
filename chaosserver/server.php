<?php

/**
* Server
*/

class Server {

	private $_config; //server configuration
	protected $_mode; //current server mode
	private $_requests_qty = 100; //now many requests to check

	function __construct() {
		$this->_getConfig();
		$this->_getMode();
	}

	/**
	*
	* Loads a configuraion file
	*/
	private function _getConfig() {
		$this->_config = json_decode(file_get_contents('config.json'), true);
	}

	/**
	*
	* Loads current mode file
	*/
	private function _getMode() {
		$this->_mode = json_decode(file_get_contents('current_mode.json'), true);
	}

	/**
	*
	* Sets a new mode
	*
	* @param string $mode new mode
	*/
	protected function setMode(string $mode) {
		$this->_mode['current'] = $mode;
		file_put_contents('current_mode.json', json_encode($this->_mode));
		$this->_getMode();
	}

	/**
	*
	* Loads requests file
	*/
	private function getRequests() {
		return json_decode(file_get_contents('requests.json'), true);
	}

	/**
	*
	* Sets new request to prode
	* @param array $request current requests status
	*/
	private function setProbed(array $request) {
		//increase to next request
		$request['probed']++;
		//if last request set it to 0
		if($request['requests_to_probe'] == $request['probed'])
			$request['probed'] = 0;

		//update data
		file_put_contents('requests.json', json_encode($request));

	}

	/**
	*
	* Rensponse a status code
	*/
	public function response() {
		//get requests data
		$request = $this->getRequests();

		//loop current mode
		foreach($this->_config['modes'][$this->_mode['current']] as $code=>$range) {

			//get the percengate of requests
			$p = ($request['probed']/$request['requests_to_probe'])*100;

			//if percentage belongs to this range
			if($p<$range) {
				//increase to next request
				$this->setProbed($request);
				//return a code
				return http_response_code($code);
			}
		}
	}

}
