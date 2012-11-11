<?php
App::uses('PiwikSocket', 'InfinitasPiwik.Lib/Piwik');

class InfinitasPiwik extends InfinitasPiwikAppModel {
/**
 * @brief no table being used
 *
 * @var boolean
 */
	public $useTable = false;

/**
 * @brief constructor
 *
 * Load the piwik socket for doing api calls
 *
 * @param type $id
 * @param type $table
 * @param type $ds
 *
 * @return void
 */
	public function __construct($id = false, $table = null, $ds = null) {
		$this->PiwikSocket = new PiwikSocket();

		parent::__construct($id, $table, $ds);
	}

/**
 * @brief get the piwik version
 *
 * @return array
 */
	public function version() {
		return current($this->PiwikSocket->api(array(
			'apiModule' => 'API',
			'apiAction' => 'getPiwikVersion',
			'api' => true
		)));
	}

/**
 * @brief overview comparing this month to last
 *
 * @return array
 */
	public function overview() {
		$translation = current($this->PiwikSocket->api(array(
			'apiModule' => 'API',
			'apiAction' => 'getDefaultMetricTranslations',
			'api' => true
		)));

		$data = current($this->PiwikSocket->api(array(
			'apiModule' => 'API',
			'apiAction' => 'get',
			'period' => 'month',
			'date' => 'last1',
			'api' => true
		)));

		$previous = current($this->PiwikSocket->api(array(
			'apiModule' => 'API',
			'apiAction' => 'get',
			'period' => 'month',
			'date' => 'previous1',
			'api' => true
		)));

		$regex = '/([0-9\.]+)/';
		$retun = array();
		foreach($data as $k => $value) {
			if(!$value && !$previous[$k]) {
				continue;
			}

			$match = array();
			preg_match($regex, $previous[$k], $match['last']);
			preg_match($regex, $value, $match['this']);
			$change = 0;
			if($match['last'][0]) {
				$change = $match['this'][0] / $match['last'][0];
			}

			$retun[] = array(
				'value' => $value,
				'name' => $k,
				'info' => !empty($translation[$k]) ? $translation[$k] : Inflector::humanize(str_replace('nb_', '', $k)),
				'last' => $previous[$k],
				'change' => $change
			);
		}

		return $retun;
	}

/**
 * @brief get all goals
 *
 * @return array
 */
	public function goalAll() {
		return $this->PiwikSocket->api(array(
			'apiModule' => 'Goals',
			'apiAction' => 'getGoals',
			'api' => true
		));
	}

/**
 * @brief get a single goal
 *
 * @param integer $id the goal id to get
 *
 * @return array
 */
	public function goal($id) {
		$goals = $this->goalAll();
		foreach($goals as $goal) {
			if($goal['idgoal'] == $id) {
				return $goal;
			}
		}

		return array();
	}

/**
 * @brief add / update a goal
 *
 * @param integer $id the id of the goal to update (empty to add)
 *
 * @return bool
 */
	public function goalAdd($data) {
		foreach($data as $k => $v) {
			$do = true;
			switch($k) {
				case 'match_attribute':
					$data['matchAttribute'] = $v;
					break;

				case 'pattern_type':
					$data['patternType'] = $v;
					break;

				case 'case_sensitive':
					$data['caseSensitive'] = $v;
					break;

				case 'allow_multiple':
					$data['allowMultipleConversionsPerVisit'] = $v;
					break;

				default:
					$do = false;
					break;
			}

			if($do) {
				unset($data[$k]);
			}
		}
		$url = array(
			'apiModule' => 'Goals',
			'apiAction' => 'updateGoal',
			'api' => true
		);
		if(empty($data['idgoal'])) {
			$url['apiAction'] = 'addGoal';
			unset($data['idgoal']);
		}

		return (bool)$this->PiwikSocket->api(array_merge($url, $data));
	}

/**
 * @brief delete a goal
 *
 * @param integer $id the id of the goal to delete
 *
 * @return bool
 */
	public function goalDelete($id) {
		$deleted = $this->PiwikSocket->api(array(
			'apiModule' => 'Goals',
			'apiAction' => 'deleteGoal',
			'idGoal' => $id,
			'api' => true
		));

		return !empty($deleted['result']) && $deleted['result'] == 'success';
	}

}
