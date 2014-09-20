<div class="row">
    <div class="col-md-12 news">
        <h4>Данные матча</h4>
                
        <center>
            <?php echo '<b>' . $match->team_1->value . '</b> ' . Html::img('assets/img/teams/'.$match->team_1->logo_uri); ?>
            <?php echo ' <b><font size="5" color="#2e830f">' . $match->team_1_goals . ' : ' . $match->team_2_goals . '</font></b> '; ?>
            <?php echo Html::img('assets/img/teams/'.$match->team_2->logo_uri) . ' <b>' . $match->team_2->value . '</b>'; ?>
        </center>
        
        <br>
        <small><i>                
            <?php echo $match->name; ?><br>
            <?php echo $match->season->value; ?><br>
            <?php echo Date::forge($match->date)->format('%d.%m.%Y'); ?></i>
        </small>
        
        <?php $goals = ''; ?>
        <?php $f = TRUE; ?>
        <?php $exist_1 = FALSE; ?>
        <?php foreach ($match->matches_events as $item): ?>
            <?php if ($item->team_id == $match->team_1->id and $item->event_id == 1): ?>
                <?php if ($f == FALSE) $goals .= ', '; ?>
                <?php $goals .= $item->player.', '.$item->time; ?>
                <?php if ($item->comment != '') $goals .=  ' ('.$item->comment.') '; ?>
                <?php $f = FALSE; ?>
                <?php $exist_1 = TRUE; ?>
            <?php endif; ?>
        <?php endforeach; ?>
        <?php $f = TRUE; ?>        
        <?php foreach ($match->matches_events as $item): ?>
            <?php if ($item->team_id == $match->team_2->id and $item->event_id == 1): ?>
                <?php if ($f == TRUE and $exist_1 == TRUE) $goals .= ' - '; ?>
                <?php if ($f == FALSE) $goals .= ', '; ?>
                <?php $goals .= $item->player.', '.$item->time; ?>
                <?php if ($item->comment != '') $goals .=  ' ('.$item->comment.') '; ?>
                <?php $f = FALSE; ?>
            <?php endif; ?>
        <?php endforeach; ?>
        <?php if ($goals != ''): ?>
            <br><br>         
            <b>Голы:</b><?php echo ' ' . $goals; ?>
        <?php endif; ?>
        
        <br><br>        
        <?php echo '<b>' . $match->team_1->value . '</b>: '; ?>
        <?php echo ($match->team_1_lineup != '') ? $match->team_1_lineup : 'Нет данных.'  ?>
        <br><br> 
        <?php echo '<b>' . $match->team_2->value . '</b>: '; ?>
        <?php echo ($match->team_2_lineup != '') ? $match->team_2_lineup : 'Нет данных.'  ?>
        
        <?php $yellow = ''; ?>
        <?php $f = TRUE; ?>
        <?php $exist_1 = FALSE; ?>
        <?php foreach ($match->matches_events as $item): ?>
            <?php if ($item->team_id == $match->team_1->id and $item->event_id == 2): ?>
                <?php if ($f == FALSE) $yellow .=  ', '; ?>
                <?php $yellow .= $item->player.', '.$item->time; ?>
                <?php if ($item->comment != '') $yellow .=  ' ('.$item->comment.') '; ?>
                <?php $f = FALSE; ?>
                <?php $exist_1 = TRUE; ?>
            <?php endif; ?>
        <?php endforeach; ?>
        <?php $f = TRUE; ?>        
        <?php foreach ($match->matches_events as $item): ?>
            <?php if ($item->team_id == $match->team_2->id and $item->event_id == 2): ?>
                <?php if ($f == TRUE and $exist_1 == TRUE) $yellow .=  ' - '; ?>
                <?php if ($f == FALSE) $yellow .=  ', '; ?>
                <?php $yellow .= $item->player.', '.$item->time; ?>
                <?php if ($item->comment) $yellow .=  ' ('.$item->comment.') '; ?>
                <?php $f = FALSE; ?>
            <?php endif; ?>
        <?php endforeach; ?>
        <?php if ($yellow != ''): ?>
            <br><br>         
            <b>Предупреждения:</b><?php echo ' ' . $yellow; ?>
        <?php endif; ?>
        
        <?php $red = ''; ?>
        <?php $f = TRUE; ?>
        <?php $exist_1 = FALSE; ?>
        <?php foreach ($match->matches_events as $item): ?>
            <?php if ($item->team_id == $match->team_1->id and $item->event_id == 3): ?>
                <?php if ($f == FALSE) $red .= ', '; ?>
                <?php $red .= $item->player.', '.$item->time; ?>
                <?php if ($item->comment != '') $red .=  ' ('.$item->comment.') '; ?>
                <?php $f = FALSE; ?>
                <?php $exist_1 = TRUE; ?>
            <?php endif; ?>
        <?php endforeach; ?>
        <?php $f = TRUE; ?>        
        <?php foreach ($match->matches_events as $item): ?>
            <?php if ($item->team_id == $match->team_2->id and $item->event_id == 3): ?>
                <?php if ($f == TRUE and $exist_1 == TRUE) $red .= ' - '; ?>
                <?php if ($f == FALSE) $red .= ', '; ?>
                <?php $red .= $item->player.', '.$item->time; ?>
                <?php if ($item->comment != '') $red .=  ' ('.$item->comment.') '; ?>
                <?php $f = FALSE; ?>
            <?php endif; ?>
        <?php endforeach; ?>
        <?php if ($red != ''): ?>
            <br><br>         
            <b>Удаления:</b><?php echo ' ' . $red; ?>
        <?php endif; ?>
            
        <br><br>    
        <?php echo html_entity_decode($match->add_data); ?>
    </div>
</div>

<?php echo render('vk_comments', array('type' => 'match', 'id' => $match->id)); ?>