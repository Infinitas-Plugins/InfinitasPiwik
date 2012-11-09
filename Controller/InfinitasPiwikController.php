<?php
class InfinitasPiwikController extends InfinitasPiwikAppController {
/**
 * @brief disable model loading
 *
 * @var boolean
 */
	public $uses = false;

/**
 * @brief generate the tracking code for piwik
 *
 * @throws CakeException
 */
	public function tracker() {
		if($this->request->params['admin'] && !Configure::read('InfinitasPiwik.track_admin')) {
			throw new CakeException('Admin tracking disabled');
		}
		
		$this->Piwik->trackerHeaders();
		$siteId = Configure::read('InfinitasPiwik.site_id');
		$site = Configure::read('InfinitasPiwik.piwik');
		if(!$siteId || !$site) {
			throw new CakeException('Piwik not configured');
		}

		$this->set('infinitasPiwik', array(
			'site_id' => $siteId,
			'site' => $site
		));
	}

/**
 * @brief piwik dashboard
 */
	public function admin_dashboard() {

	}

}
