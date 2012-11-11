<?php
class InfinitasPiwikController extends InfinitasPiwikAppController {
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
		$piwikOverview = $this->{$this->modelClass}->overview();
		$piwikVersion = $this->{$this->modelClass}->version();

		$this->set(compact('piwikOverview', 'piwikVersion'));
	}

/**
 * @brief setup piwik
 */
	public function admin_setup() {
	}

/**
 * @brief display a list of goals
 */
	public function admin_goals() {
		$this->set('piwikGoals', $this->{$this->modelClass}->goalAll());
	}

/**
 * @brief add / edit goals
 *
 * @param integer $id the goal id to edit
 */
	public function admin_goal_form($id = null) {
		if($this->request->data) {
			$this->{$this->modelClass}->goalAdd($this->request->data);
		}

		if(!$this->request->data) {
			$this->request->data = $this->{$this->modelClass}->goal($id);
		}
	}

/**
 * @brief delete a goal
 *
 * @param integer $id the id of the goal to delete
 */
	public function admin_goal_delete($id = null) {
		if(!$id) {
			$this->notice('invalid');
		}
		if($this->{$this->modelClass}->goalDelete($id)) {
			$this->notice('deleted');
		}
		$this->notice('not_deleted');
	}

}
