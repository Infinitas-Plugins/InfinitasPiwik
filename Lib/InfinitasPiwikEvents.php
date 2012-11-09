<?php
class InfinitasPiwikEvents extends AppEvents {
/**
 * @brief plugin details
 *
 * @return array
 */
	public function onPluginRollCall() {
		return array(
			'name' => 'Piwik',
			'description' => 'Piwik visitor tracker',
			'icon' => '/infinitas_piwik/img/icon.png',
			'author' => 'Infinitas',
			'dashboard' => array(
				'plugin' => 'infinitas_piwik',
				'controller' => 'infinitas_piwik',
				'action' => 'dashboard'
			)
		);
	}

/**
 * @brief admin menu bar links
 *
 * @param type $event
 *
 * @return array
 */
	public function onAdminMenu(Event $Event) {
		$menu['main'] = array(
			'Dashboard' => array('plugin' => 'infinitas_piwik', 'controller' => 'infinitas_piwik', 'action' => 'dashboard')
		);

		return $menu;
	}

/**
 * @brief load the components
 *
 * @param Event $Event the event being loaded
 *
 * @return array
 */
	public function onRequireComponentsToLoad(Event $Event = null) {
		return array(
			'InfinitasPiwik.Piwik'
		);
	}

/**
 * @brief load the Piwik helper
 *
 * @param Event $Event the event being loaded
 *
 * @return array
 */
	public function onRequireHelpersToLoad(Event $Event = null) {
		$return = array(
			'InfinitasPiwik.Piwik'
		);
		if($Event->Handler->request->params['admin']) {
			$return[] = 'InfinitasPiwik.PiwikImage';
		}

		return $return;
	}

/**
 * @brief parse js extensions for the tracking script
 *
 * @param Event $Event the event being loaded
 *
 * @return array
 */
	public function onSetupExtensions(Event $Event) {
		return array(
			'js'
		);
	}

/**
 * @brief load up the tracking scripts
 *
 * Tracking scripts are only loaded for admin when the `track_admin` config has
 * been set to true.
 *
 * @param Event $Event the event being loaded
 *
 * @return array
 */
	public function onRequireJavascriptToLoad(Event $Event) {
		if($Event->Handler->request->params['admin'] && !Configure::read('InfinitasPiwik.track_admin')) {
			return array();
		}

		return array(
			'/infinitas_piwik/infinitas_piwik/tracker.js',
			'InfinitasPiwik.piwik'
		);
	}

}