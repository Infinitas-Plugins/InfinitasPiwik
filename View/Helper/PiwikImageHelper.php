<?php
class PiwikImageHelper extends PiwikHelper {
/**
 * @brief set this to false for lower quality quicker rendering images
 *
 * @var boolean
 */
	public $aliasedGraph = true;

/**
 * @brief render a graph
 *
 * @return string
 */
	public function graph(array $graph, array $options = array()) {
		try {
			return $this->Html->image($this->PiwikApi->url($graph), $options);
		} catch (Exception $e) {
			return $this->Html->tag('p', $e->getMessage());
		}
	}

/**
 * @brief render the markup for displaying user tracking reports
 *
 * If the chart is passed as a string it will be loaded as a presset using __call(),
 * and if passed as an array will use the PiwikImageHelper::draw() method.
 *
 * @param string|array $chart
 * @param array $options
 *
 * @return string
 */
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

		return $this->graph($this->PiwikApi->defaultApiCall($name, $params), $options);
	}

}
