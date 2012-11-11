<?php
class PiwikComponent extends InfinitasComponent {
/**
 * @brief setup the headers so the js is read correctly
 */
	public function trackerHeaders() {
		$this->Controller->response->type('js');
		//$this->Controller->response->cache('-1 minute', Configure::read('InfinitasPiwik.tracker_cache'));
	}

}