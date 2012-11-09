<?php
App::uses('PiwikApi', 'InfinitasPiwik.Lib/Piwik');
/**
 * @brief helper for general piwik related tasks
 *
 * @property PiwikApi $PiwikApi
 */

class PiwikHelper extends AppHelper {
	public function __construct(View $View, $settings = array()) {
		parent::__construct($View, $settings);

		$this->PiwikApi = new PiwikApi();
	}
	
/**
 * @brief image tracker when there is no js
 *
 * @param boolean $track should the view be tracked or not
 *
 * @return string
 *
 * @throws CakeException
 */
	public function image($track = true) {
		$queryParams = array(
			'rec' => $track ? 1 : 0,
			'action_name' => $this->_pageTitle(),
			'referer' => $this->request->referer()
		);

		return $this->Html->image($this->PiwikApi->url('piwik.php', $queryParams, true), array(
			'style' => 'border:0',
			'alt' => 'Piwik tracker'
		));
	}

/**
 * @brief generate an optout box
 *
 * @param array $options options for the iframe
 *
 * @return string
 */
	public function optout(array $options = array()) {
		$options = array_merge(array(
			'frameborder' => 'no',
			'width' => '600px',
			'height' => '200px',
			'src' => $this->PiwikApi->url('index.php', array(
				'module' => 'CoreAdminHome',
				'action' => 'optOut',
				'language' => 'en'
			))
		), $options);

		return $this->Html->tag('iframe', '', $options);
	}

/**
 * @brief get a logo that links to the tracking site.
 *
 * @return string
 */
	public function logo() {
		return $this->Html->link(
			$this->Html->image('InfinitasPiwik.icon.png'),
			$this->PiwikApi->trackingSite(),
			array(
				'style' => 'float: right;',
				'escape' => false,
				'target' => '_blank'
			)
		);
	}

/**
 * @brief get the page title
 *
 * @return string
 */
	protected function _pageTitle() {
		$contentTitle = Configure::read('Website.name');
		if(!empty($this->_View->viewVars['title_for_layout'])) {
			$siteName = Configure::read('Website.name');
			$contentTitle = sprintf('%s :: %s', substr($this->_View->viewVars['title_for_layout'], 0, 66 - strlen($siteName)), $siteName);
		}

		return $contentTitle;
	}

}