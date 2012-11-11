<?php

$tabs = array(
	__d('infinitas_piwik', 'Info'),
	__d('infinitas_piwik', 'Overview'),
	__d('infinitas_piwik', 'Referers'),
	__d('infinitas_piwik', 'Users')
);
$contents = array(
	$this->element('InfinitasPiwik.overview', array('piwikOverview' => $piwikOverview)),
	$this->element('InfinitasPiwik.images/overview'),
	$this->element('InfinitasPiwik.images/referers'),
	$this->element('InfinitasPiwik.images/users'),
);

echo $this->Design->tabs($tabs, $contents);
echo $this->Html->tag('p', __d('infinitas_piwik', '%s version %s', array(
	$this->Html->link('Piwik', 'http://piwik.org', array(
		'target' => '_blank'
	)),
	$piwikVersion
)));

echo $this->Piwik->logo();