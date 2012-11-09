<?php
class PiwikApi {
/**
 * @brief magic method params
 *
 * @var array
 */
	protected static $_methods = array(
		'visitsSummary' => array(
			'apiModule' => 'VisitsSummary'
		),
		'visitsUnique' => array(
			'apiModule' => 'VisitsSummary',
			'apiAction' => 'getUniqueVisitors'
		),
		'visitsMaxActions' => array(
			'apiModule' => 'VisitsSummary',
			'apiAction' => 'getMaxActions'
		),
		'visitsBounceRate' => array(
			'apiModule' => 'VisitsSummary',
			'apiAction' => 'getBounceCount'
		),

		'visitsFrequency' => array(
			'apiModule' => 'VisitFrequency'
		),
		'visitsTimeLocal' => array(
			'apiModule' => 'VisitTime',
			'apiAction' => 'getVisitInformationPerLocalTime'
		),
		'visitsTimeServer' => array(
			'apiModule' => 'VisitTime',
			'apiAction' => 'getVisitInformationPerServerTime'
		),

		'refererTypes' => array(
			'apiModule' => 'Referers',
			'apiAction' => 'getRefererType'
		),
		'refererKeywords' => array(
			'apiModule' => 'Referers',
			'apiAction' => 'getKeywords'
		),
		'refererSearchEngines' => array(
			'apiModule' => 'Referers',
			'apiAction' => 'getSearchEngines',
			'graphType' => 'pie'
		),
		'refererCampaigns' => array(
			'apiModule' => 'Referers',
			'apiAction' => 'getCampaigns',
			'graphType' => 'hBar'
		),
		'refererWebsites' => array(
			'apiModule' => 'Referers',
			'apiAction' => 'getWebsites',
			'graphType' => 'vBar'
		),

		'userCountry' => array(
			'apiModule' => 'UserCountry',
			'apiAction' => 'getCountry',
			'graphType' => 'vBar'
		),
		'userBrowser' => array(
			'apiModule' => 'UserSettings',
			'apiAction' => 'getBrowser'
		),
		'userBrowserVersion' => array(
			'apiModule' => 'UserSettings',
			'apiAction' => 'getBrowserVersion'
		),
		'userBrowserType' => array(
			'apiModule' => 'UserSettings',
			'apiAction' => 'getBrowserType',
			'graphType' => 'vBar'
		),
		'userBrowserPlugins' => array(
			'apiModule' => 'UserSettings',
			'apiAction' => 'getPlugin',
			'graphType' => 'vBar'
		),
		'userScreen' => array(
			'apiModule' => 'UserSettings',
			'apiAction' => 'getResolution',
			'graphType' => 'line'
		),
		'userOs' => array(
			'apiModule' => 'UserSettings',
			'apiAction' => 'getOS'
		),
		'userOsFamily' => array(
			'apiModule' => 'UserSettings',
			'apiAction' => 'getOSFamily'
		)
	);

/**
 * @brief graph types
 *
 * @var array
 */
	protected $_graphTypes = array(
		'line' => 'evolution',
		'hBar' => 'horizontalBar',
		'vBar' => 'verticalBar',
		'pie' => 'pie'
	);

/**
 * @brief the available data types
 *
 * @var array
 */
	protected $_dataTypes = array(
		'visits' => 'nb_visits',
		'actions' => 'nb_actions',
		'visits_converted' => 'nb_visits_converted'
	);

/**
 * @brief available periods
 *
 * @var array
 */
	protected $_periods = array(
		'day',
		'week',
		'month',
		'year',
		'range'
	);

/**
 * @brief overload the url method
 *
 * All images use index.php, the first argument can be queryParams and the default
 * will be set for path.
 *
 * @param string $path the path to generate on
 * @param array $queryParams report params
 *
 * @return string
 */
	public function url($path, $queryParams = null, $tracking = false) {
		if($queryParams === null) {
			$queryParams = $path;
			$path = 'index.php';
		}

		$url = ':scheme://:host/:path?:query';
		if(!$queryParams) {
			$url = ':scheme://:host/:path';
		}

		if($tracking) {
			$query = self::trackingParams($queryParams);
		} else {
			$query = self::apiParams($queryParams);
		}

		return String::insert($url, array(
			'scheme' => $this->_scheme(),
			'host' => $this->_site(),
			'path' => $path,
			'query' => $query
		));
	}

	public function trackingSite() {
		return sprintf('%s://%s/', $this->_scheme(), $this->_site());
	}

	public function defaultApiCall($method, array $options = array()) {
		if(empty(self::$_methods[$method])) {
			throw new InvalidArgumentException(__d('infinitas_piwik', 'Unknown method "%s"', $method));
		}

		return array_merge(self::$_methods[$method], $options);
	}

/**
 * @brief figure out the scheme being used on the application
 *
 * @return string
 */
	protected function _scheme() {
		return 'http';
	}

	/**
 * @brief Set up the default query params
 *
 * @param View $View The view being rendered
 *
 * @param array $settings the settings for the helper
 *
 * @return array
 */
	public function defaultApiQuery() {
		return array(
			'module' => 'API',
			'method' => 'ImageGraph.get',
			'apiModule' => null,
			'idSite' => self::_siteId(),
			'apiAction' => 'get',
			'token_auth' => self::_token(),
			'graphType' => 'line',
			'column' => 'visits',
			'period' => 'day',
			'date' => 'previous30',
			'width' => 500,
			'height' => 250
		);
	}

/**
 * @brief default query params for tracking code generaltion
 *
 * @return array
 */
	public function defaultTrackingQuery() {
		return array(
			'idsite' => self::_siteId(),
			'rand' => microtime(true),
			'_id' => AuthComponent::user('id'),
			'_idts' => AuthComponent::user('created'),
			'rec' => 1,
			'action_name' => 'No title',
			'referer' => '/'
		);
	}

	public function trackingParams($queryParams) {
		if(is_string($queryParams) || empty($queryParams)) {
			return $queryParams;
		}
		return http_build_query(array_merge(self::defaultTrackingQuery(), $queryParams));
	}

/**
 * @brief clear up the api query params and check that the required are available.
 *
 * @param array|string $queryParams
 *
 * @return string
 *
 * @throws InvalidArgumentException
 */
	public function apiParams($queryParams) {
		if(is_string($queryParams) || empty($queryParams)) {
			return $queryParams;
		}

		$queryParams = array_merge(self::defaultApiQuery(), $queryParams);

		if(empty($this->_graphTypes[$queryParams['graphType']])) {
			throw new InvalidArgumentException(__d('infinitas_piwik', 'Invalid graph type "%s"', $queryParams['graphType']));
		}
		$queryParams['graphType'] = $this->_graphTypes[$queryParams['graphType']];

		if(empty($this->_dataTypes[$queryParams['column']])) {
			throw new InvalidArgumentException(__d('infinitas_piwik', 'Invalid data type "%s"', $queryParams['column']));
		}
		$queryParams['column'] = $this->_dataTypes[$queryParams['column']];

		if(!in_array($queryParams['period'], $this->_periods)) {
			throw new InvalidArgumentException(__d('infinitas_piwik', 'Invalid period "%s"', $queryParams['period']));
		}

		if(!is_array($queryParams['date'])) {
			$queryParams['date'] = array($queryParams['date']);
		}
		foreach($queryParams['date'] as &$date) {

		}
		if($queryParams['period'] == 'range' && count($queryParams['date']) != 2) {
			throw new InvalidArgumentException(__d('infinitas_piwik', 'Date for range should be array of two dates'));
		}
		if($queryParams['period'] != 'range' && (count($queryParams['date']) != 1)) {
			throw new InvalidArgumentException(__d('infinitas_piwik', 'Date can only'));
		}
		$queryParams['date'] = implode(',', $queryParams['date']);

		return http_build_query($queryParams);
	}

/**
 * @brief get site id
 *
 * reports can be on multiple sites so a report id is available that can be set
 * with many ids or 'all'. If not available will use the default tracking id
 *
 * @return string|integer
 */
	protected function _reportSiteId() {
		$siteId = Configure::read('InfinitasPiwik.report.site_id');
		if($siteId) {
			if(is_array($siteId)) {
				$siteId = implode(',', $siteId);
			}
			return $siteId;
		}
		return self::_siteId();
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
			throw new CakeException('Piwik not configured "InfinitasPiwik.site_id"');
		}

		return $siteId;
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
			throw new CakeException('Piwik tracking site not configured "InfinitasPiwik.piwik"');
		}

		return $site;
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
			throw new CakeException('Piwik auth token not configured "InfinitasPiwik.report.auth_token"');
		}

		return $token;
	}

}