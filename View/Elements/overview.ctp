<table class="listing">
	<thead>
		<tr>
			<th><?php echo __d('infinitas_piwik', 'Data'); ?>&nbsp;</th>
			<th><?php echo __d('infinitas_piwik', 'This Month'); ?>&nbsp;</th>
			<th><?php echo __d('infinitas_piwik', 'Last Month'); ?>&nbsp;</th>
			<th><?php echo __d('infinitas_piwik', 'Change'); ?>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach($piwikOverview as $overview) { ?>
				<tr>
					<td><?php echo $overview['info']; ?>&nbsp;</td>
					<td><?php echo $overview['value'] ? $overview['value'] : '-'; ?>&nbsp;</td>
					<td><?php echo $overview['last'] ? $overview['last'] : '-'; ?>&nbsp;</td>
					<td><?php echo $overview['change'] ? round($overview['change'], 2) : '-'; ?>&nbsp;</td>
				</tr><?php
			}
		?>
	</tbody>
</table>