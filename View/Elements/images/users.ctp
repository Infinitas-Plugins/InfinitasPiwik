<?php
echo $this->PiwikImage->draw('userBrowser', array(
	'title' => __d('infinitas_piwik', 'Browser')
));
echo $this->PiwikImage->draw('userBrowserVersion', array(
	'title' => __d('infinitas_piwik', 'Browser version'),
	'clear' => true
));
echo $this->PiwikImage->draw('userBrowserType', array(
	'title' => __d('infinitas_piwik', 'Browser Type'),
	'width' => 920,
	'div' => array(
		'class' => 'dashboard'
	),
	'clear' => true
));
echo $this->PiwikImage->draw('userBrowserPlugins', array(
	'title' => __d('infinitas_piwik', 'Browser plugins'),
	'width' => 920,
	'div' => array(
		'class' => 'dashboard'
	),
	'clear' => true
));


echo $this->PiwikImage->draw('userScreen', array(
	'title' => __d('infinitas_piwik', 'User: Screen resolution'),
	'width' => 920,
	'div' => array(
		'class' => 'dashboard'
	),
	'clear' => true
));
echo $this->PiwikImage->draw('userOs', array(
	'title' => __d('infinitas_piwik', 'User: Opperating system')
));
echo $this->PiwikImage->draw('userOsFamily', array(
	'title' => __d('infinitas_piwik', 'User: Opperating system family'),
	'clear' => true
));