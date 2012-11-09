<?php

echo $this->PiwikImage->draw('visitsSummary', array(
	'title' => __d('infinitas_piwik', 'Visitors per day')
));
echo $this->PiwikImage->draw('userCountry', array(
	'title' => __d('infinitas_piwik', 'Visitors (By country)'),
	'clear' => true
));
echo $this->PiwikImage->draw('visitsFrequency', array(
	'title' => __d('infinitas_piwik', 'Visit frequency'),
	'width' => 920,
	'div' => array(
		'class' => 'dashboard'
	),
	'clear' => true
));
echo $this->PiwikImage->draw('visitsUnique', array(
	'title' => __d('infinitas_piwik', 'Visit unique'),
	'width' => 920,
	'div' => array(
		'class' => 'dashboard'
	),
	'clear' => true
));
echo $this->PiwikImage->draw('visitsMaxActions', array(
	'title' => __d('infinitas_piwik', 'Visitors per day')
));
echo $this->PiwikImage->draw('visitsBounceRate', array(
	'title' => __d('infinitas_piwik', 'Visitors (By country)'),
	'clear' => true
));

echo $this->PiwikImage->draw('visitsTimeLocal', array(
	'title' => __d('infinitas_piwik', 'Visit time (local)')
));
echo $this->PiwikImage->draw('visitsTimeServer', array(
	'title' => __d('infinitas_piwik', 'Visit time (server)'),
	'clear' => true
));

