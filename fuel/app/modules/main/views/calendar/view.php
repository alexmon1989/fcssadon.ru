<div class="row">
    <div class="col-md-12 news">
        <h4>Календарь матчей сезона "<?php echo $matches[0]['matches'][0]->season->value ?>"</h4>
                
        <?php foreach ($matches as $item): ?>
            <br>
            <b><?php echo $item['name']; ?></b>
            <?php foreach ($item['matches'] as $match): ?>
                <br>
                <?php if ($match->status_id == 1): ?>
                    <?php echo Date::forge($match->date)->format('%d.%m.%Y') . ' ' . $match->team_1->value . ' - ' . $match->team_2->value; ?>
                <?php else: ?>
                    <?php echo Date::forge($match->date)->format('%d.%m.%Y') . ' ' . Html::anchor('matches/'.$match->id, $match->team_1->value . ' - ' . $match->team_2->value, array('title' => 'Посмотреть детали матча')) . ' - <b>' . $match->team_1_goals . ':' . $match->team_2_goals . '</b>'; ?>
                <?php endif; ?>
            <?php endforeach; ?>
            <br>
        <?php endforeach; ?>
        
        <br>
    </div>
</div>