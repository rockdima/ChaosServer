<?php

class Server {

	private $_config;
	protected $_mode;
	private $_requests_qty = 100;

	function __construct() {
		$this->_getConfig();
		$this->_getMode();
	}

	private function _getConfig() {
		$this->_config = json_decode(file_get_contents('config.json'), true);
	}

	private function _getMode() {
		$this->_mode = json_decode(file_get_contents('current_mode.json'), true);
	}

	protected function setMode(string $mode) {
		$this->_mode['current'] = $mode;
		file_put_contents('current_mode.json', json_encode($this->_mode));
		$this->_getMode();
	}

	private function getRequests() {
		return json_decode(file_get_contents('requests.json'), true);
	}

	private function setProbed(array $request) {
		$request['probed']++;
		if($request['requests_to_probe'] == $request['probed'])
			$request['probed'] = 0;

		file_put_contents('requests.json', json_encode($request));

	}



	public function response() {
		$request = $this->getRequests();

		foreach($this->_config['modes'][$this->_mode['current']] as $code=>$mode) {

			$p = ($request['probed']/$request['requests_to_probe'])*100;

			if($p<$mode) {
				$this->setProbed($request);
				return http_response_code($code);
			}
		}
	}

}