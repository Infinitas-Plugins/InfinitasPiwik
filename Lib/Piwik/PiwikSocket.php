<?php
App::uses('HttpSocket', 'Network/Http');
App::uses('PiwikApi', 'InfinitasPiwik.Lib/Piwik');

/**
 * @brief Piwik socket class
 *
 * @property PiwikApi $PiwikApi
 */
class PiwikSocket extends HttpSocket {
/**
 * @brief Constructor
 *
 * Load up the PiwikApi class
 *
 * @param array $config
 */
	public function __construct($config = array()) {
		$this->PiwikApi = new PiwikApi();

		parent::__construct();
	}

/**
 * @brief call the api
 *
 * @param string|array $url
 */
	public function api($url) {
		if(is_array($url)) {
			$url = $this->PiwikApi->url($url);
		}

		$this->_configUri($url);
		$data = json_decode($this->get($url)->body, true);

		if(!empty($data['result'])  && $data['result'] == 'error') {
			throw new CakeException($data['message']);
		}

		return $data;
	}

}