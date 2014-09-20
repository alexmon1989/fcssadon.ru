<div class="row">
    <div class="col-md-12 news">        
        <h4><?php echo $player->player_name; ?></h4>
        <p><?php echo Html::anchor('team/core', 'Назад ко всем игрокам') ?></p>
        <div class="row">
            <div class="col-md-4">
                <?php if ($player->image_uri): ?>
                <?php echo Asset::img('players/'.$player->image_uri, array('class' => 'img-thumbnail')); ?>
                <?php else: ?>
                <?php echo Asset::img('players/no.png', array('class' => 'img-thumbnail')); ?>
                <?php endif; ?>
            </div>
            <div class="col-md-">
                <p>Дата рождения: <i><?php echo !is_null($player->birthdate) ? Date::forge($player->birthdate)->format("%d.%m.%Y") : 'Не указано'; ?></i></p>                
                <p><?php echo $player->data; ?></p>
            </div>
        </div>
    </div>
</div>