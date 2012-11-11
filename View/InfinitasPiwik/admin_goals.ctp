<?php
    echo $this->Form->create(false, array('action' => 'mass'));
	echo $this->Infinitas->adminIndexHead(null, array(
		'add',
	));
?>
<div class="table">
    <table class="listing" cellpadding="0" cellspacing="0">
        <?php
            echo $this->Infinitas->adminTableHeader(
                array(
                    __d('infinitas_piwik', 'Id'),
                    __d('infinitas_piwik', 'Name'),
                    __d('infinitas_piwik', 'Pattern'),
                    __d('infinitas_piwik', 'Case'),
                    __d('infinitas_piwik', 'Multiple'),
                    __d('infinitas_piwik', 'Revenue'),
                    __d('infinitas_piwik', 'Actions'),
                )
            );

            foreach($piwikGoals as $piwikGoal) {
				if($piwikGoal['deleted']) {
					continue;
				}  ?>
				<tr class="<?php echo $this->Infinitas->rowClass(); ?>">
					<td><?php echo $piwikGoal['idgoal']; ?>&nbsp;</td>
					<td><?php echo sprintf('%s (%s)', $piwikGoal['name'], $piwikGoal['match_attribute']); ?>&nbsp;</td>
					<td><?php echo sprintf('%s (%s)', $piwikGoal['pattern'], $piwikGoal['pattern_type']); ?>&nbsp;</td>
					<td>
						<?php
							echo $this->Infinitas->status($piwikGoal['case_sensitive'], array(
								'title_yes' => __d('infinitas_piwik', 'Case sensitive :: The match is case sensitive'),
								'title_no' => __d('infinitas_piwik', 'Case insensitive :: The match is not case sensitive'),
							));
						?>
					</td>
					<td>
						<?php
							echo $this->Infinitas->status($piwikGoal['allow_multiple'], array(
								'title_yes' => __d('infinitas_piwik', 'Multiple conversions :: This goal allows multiple conversions per visit'),
								'title_no' => __d('infinitas_piwik', 'Single Conversion :: This goal will only track a single conversion per visit'),
							));
						?>
					</td>
					<td><?php echo CakeNumber::currency($piwikGoal['revenue']); ?>&nbsp;</td>
					<td>
						<?php
							echo implode(' ', array(
								$this->Html->link(__d('infinitas_piwik', 'Edit'), array(
									'action' => 'goal_form',
									$piwikGoal['idgoal']
								)),
								$this->Html->link(__d('infinitas_piwik', 'Delete'), array(
									'action' => 'goal_delete',
									$piwikGoal['idgoal']
								))
							))
						?>&nbsp;
					</td>
				</tr> <?php
            }
        ?>
    </table>
    <?php echo $this->Form->end(); ?>
</div>
