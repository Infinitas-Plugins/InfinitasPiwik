<?php
echo $this->Form->create(false, array('type' => 'file'));
	echo $this->Infinitas->adminEditHead();
	echo $this->Form->hidden('idgoal');

	$tabs = array(
		__d('infinitas_piwik', 'Goal')
	);

	$content = array(
		implode('', array(
			$this->Form->input('name'),
			$this->Form->input('match_attribute', array(
				'type' => 'select',
				'options' => array(
					'url' => __d('infinitas_piwik', 'URL'),
					'title' => __d('infinitas_piwik', 'Title'),
					'file' => __d('infinitas_piwik', 'File'),
					'external_website' => __d('infinitas_piwik', 'External site')
				)
			)),
			$this->Form->input('pattern'),
			$this->Form->input('pattern_type', array(
				'type' => 'select',
				'options' => array(
					'contains' => __d('infinitas_piwik', 'Contains'),
					'exact' => __d('infinitas_piwik', 'Exact match'),
					'regex' => __d('infinitas_piwik', 'Regular expression'),
				)
			)),
			$this->Form->input('case_sensitive', array(
				'type' => 'checkbox'
			)),
			$this->Form->input('allow_multiple', array(
				'type' => 'checkbox'
			)),
			$this->Form->input('revenue', array(
				'type' => 'number'
			))
		))
	);

	echo $this->Design->tabs($tabs, $content);
echo $this->Form->end();