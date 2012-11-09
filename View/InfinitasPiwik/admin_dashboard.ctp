<?php

$tabs = array(
	__d('infinitas_piwik', 'Overview'),
	__d('infinitas_piwik', 'Referers'),
	__d('infinitas_piwik', 'Users')
);
$contents = array(
	$this->element('InfinitasPiwik.images/overview'),
	$this->element('InfinitasPiwik.images/referers'),
	$this->element('InfinitasPiwik.images/users'),
);

echo $this->Design->tabs($tabs, $contents);

echo $this->Piwik->logo();