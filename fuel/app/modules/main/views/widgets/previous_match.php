<div class="green-header">Предыдущий матч</div>
<div class="description" <?php if ($match): ?> onclick="location.href='<?php echo Uri::create('matches/'.$match->id); ?>'" style="cursor: pointer" title="Посмотреть данные матча" <?php endif; ?>>
    <?php if ($match): ?>
        <b><i><?php echo $match->season->value; ?></i></b><br>
        <?php echo $match->name; ?><br>
        <?php echo date('d.m.Y', $match->date); ?><br>

        <div class="match-commands">
            <?php $team_1_name = str_replace('"', '', $match->team_1->value); $team_2_name = str_replace('"', '', $match->team_2->value); ?>

            <?php echo Html::img('assets/img/teams/'.$match->team_1->logo_uri, array('alt' => $team_1_name, 'title' => $team_1_name)); ?>

            <span class="match-result"><?php echo $match->team_1_goals.':'.$match->team_2_goals; ?></span>

            <?php echo Html::img('assets/img/teams/'.$match->team_2->logo_uri, array('alt' => $team_2_name, 'title' => $team_2_name)); ?>
        </div>
    <?php else: ?>
        Данные отсутствуют.<br><br>
    <?php endif; ?>
</div>