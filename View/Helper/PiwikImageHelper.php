<?php
class PiwikImageHelper extends PiwikHelper {
/**
 * @brief set this to false for lower quality quicker rendering images
 *
 * @var boolean
 */
	public $aliasedGraph = true;

/**
 * @brief magic method params
 *
 * @var array
 */
	protected $_methods = array(
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
 * @brief default query params
 *
 * @var array
 */
	protected $_queryParamDefaults = array();

/**
 * @brief Set up the default query params
 *
 * @param View $View The view being rendered
 *
 * @param array $settings the settings for the helper
 */
	protected function _defaults() {
		$this->_queryParamDefaults = array(
			'module' => 'API',
			'method' => 'ImageGraph.get',
			'apiModule' => null,
			'idSite' => $this->_siteId(),
			'apiAction' => 'get',
			'token_auth' => $this->_token(),
			'graphType' => 'line',
			'column' => 'visits',
			'period' => 'day',
			'date' => 'previous30',
			'width' => 500,
			'height' => 250
		);
	}

/**
 * @brief render a graph
 *
 * @return string
 */
	public function graph(array $graph, array $options = array()) {
		$this->_defaults();
		try {
			return $this->_image($graph, $options);
		} catch (Exception $e) {
			return $this->Html->tag('p', $e->getMessage());
		}
	}

	public function draw($chart, array $options = array()) {
		$options = array_merge(array(
			'title' => __d('infinitas_piwik', 'Chart'),
			'width' => 450,
			'height' => 200,
			'clear' => false,
			'div' => array(
				'class' => 'dashboard half'
			)
		), $options);

		$title = $options['title'];
		$div = $options['div'];
		$clear = $options['clear'] ? $this->Html->tag('div', '', array('class' => 'clear')) : null;
		unset($options['title'], $options['div'], $options['clear']);
		if(is_array($chart)) {
			$chart = $this->graph($chart, $options);
		} else {
			$chart = $this->{$chart}($options);
		}

		return $this->Html->tag('div', $this->Html->tag('h1', $title) . $chart, $div) . $clear;
	}

/**
 * @brief get an image based on the url
 *
 * @param array $url the url to get
 * @param array $options options for the image
 *
 * @return string
 */
	protected function _image(array $url, array $options) {
		return $this->Html->image($this->_url($url), $options);
	}

/**
 * @brief magic method for using presets
 *
 * @code
 *	$this->PiwikImage->methodName($params, $options);
 *
 * // same as (but with params pre set)
 *
 *	$this->PiwikImage->graph($params, $options);
 * @endcode
 *
 * @param type $name
 * @param type $params
 * @return type
 * @throws InvalidArgumentException
 */
	public function __call($name, $params) {
		$options = !empty($params[1]) ? $params[1] : array();
		$params = !empty($params[0]) ? $params[0] : array();
		if(empty($this->_methods[$name])) {
			throw new InvalidArgumentException(__d('infinitas_piwik', 'Unknown chart type "%s"', $name));
		}

		return $this->graph(array_merge($this->_methods[$name], $params), $options);
	}

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
	protected function _url($path, $queryParams = null) {
		if($queryParams === null) {
			$queryParams = $path;
			$path = 'index.php';
		}

		return parent::_url($path, $this->_queryParams($queryParams));
	}

/**
 * @brief clear up the query params and check that the required are available.
 *
 * @param array $queryParams
 *
 * @return string
 *
 * @throws InvalidArgumentException
 */
	protected function _queryParams(array $queryParams) {
		$queryParams = array_merge($this->_queryParamDefaults, $queryParams);

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

		return $queryParams;
	}

/**
 * @brief get site id
 *
 * reports can be on multiple sites so a report id is available that can be set
 * with many ids or 'all'. If not available will use the default tracking id
 *
 * @return string|integer
 */
	protected function _siteId() {
		$siteId = Configure::read('InfinitasPiwik.report.site_id');
		if($siteId) {
			if(is_array($siteId)) {
				$siteId = implode(',', $siteId);
			}
			return $siteId;
		}
		return parent::_siteId();
	}
}
