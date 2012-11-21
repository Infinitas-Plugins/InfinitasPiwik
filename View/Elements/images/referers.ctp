<?php
echo $this->PiwikImage->draw('refererTypes', array(
	'title' => __d('infinitas_piwik', 'Referer types'),
	'div' => array(
		'class' => 'dashboard span6'
	)
));
echo $this->PiwikImage->draw('refererCampaigns', array(
	'title' => __d('infinitas_piwik', 'Referer campaigns'),
	'clear' => true
));
echo $this->PiwikImage->draw('refererSearchEngines', array(
	'title' => __d('infinitas_piwik', 'Referer search engines'),
	'width' => 920,
	'div' => array(
		'class' => 'dashboard'
	),
	'clear' => true
));
echo $this->PiwikImage->draw('refererWebsites', array(
	'title' => __d('infinitas_piwik', 'Referer websites'),
	'width' => 920,
	'div' => array(
		'class' => 'dashboard'
	),
	'clear' => true
));
echo $this->PiwikImage->draw('refererKeywords', array(
	'title' => __d('infinitas_piwik', 'Referer keywords'),
	'width' => 920,
	'height' => 400,
	'div' => array(
		'class' => 'dashboard'
	),
	'clear' => true
));
