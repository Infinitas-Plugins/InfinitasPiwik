<?php
class PiwikHelper extends AppHelper {
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
			'idsite' => $this->_siteId(),
			'rec' => $track ? 1 : 0,
			'action_name' => $this->_pageTitle(),
			'referer' => $this->request->referer(),
			'rand' => microtime(true),
			'_id' => AuthComponent::user('id'),
			'_idts' => AuthComponent::user('created')
		);

		return $this->Html->image($this->_url('piwik.php', $queryParams), array(
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
			'src' => $this->_url('index.php', array(
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
			sprintf('http://%s/', $this->_site()),
			array(
				'style' => 'float: right;',
				'escape' => false,
				'target' => '_blank'
			)
		);
	}

/**
 * @brief generate a url to the piwik install
 *
 * @param string $path the path to run
 * @param array|string $queryParams the query parameters
 *
 * @return string
 *
 * @throws CakeException
 */
	protected function _url($path, $queryParams = null) {
		if(is_array($queryParams)) {
			$queryParams = http_build_query($queryParams);
		}

		$url = ':scheme://:host/:path?:query';
		if(!$queryParams) {
			$url = ':scheme://:host/:path';
		}
		return String::insert($url, array(
			'scheme' => 'http',
			'host' => $this->_site(),
			'path' => $path,
			'query' => (string)$queryParams
		));
	}

/**
 * @brief get the piwik tracking site
 *
 * @return string
 *
 * @throws CakeException
 */
	protected function _site() {
		$site = Configure::read('InfinitasPiwik.piwik');
		if(!$site) {
			throw new CakeException('Piwik not configured');
		}

		return $site;
	}

/**
 * @brief get the site id being tracked
 *
 * @return integer
 *
 * @throws CakeException
 */
	protected function _siteId() {
		$siteId = Configure::read('InfinitasPiwik.site_id');
		if(!$siteId) {
			throw new CakeException('Piwik not configured');
		}

		return $siteId;
	}

/**
 * @brief get the token for api calls
 *
 * @return string
 *
 * @throws CakeException
 */
	protected function _token() {
		$token = Configure::read('InfinitasPiwik.report.auth_token');
		if(!$token) {
			throw new CakeException('Piwik auth token not configured');
		}

		return $token;
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