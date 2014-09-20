<div class="row">
    <div class="col-md-12 news">        
        <h4><?php echo $staff->player_name; ?></h4>
        <p><?php echo Html::anchor('team/past', 'Назад ко всем игрокам') ?></p>
        <div class="row">
            <div class="col-md-4">
                <?php if ($staff->image_uri): ?>
                <?php echo Asset::img('players/'.$staff->image_uri, array('class' => 'img-thumbnail')); ?>
                <?php else: ?>
                <?php echo Asset::img('players/no.png', array('class' => 'img-thumbnail')); ?>
                <?php endif; ?>
            </div>
            <div class="col-md-">
                <p>Дата рождения: <i><?php echo !is_null($staff->birthdate) ? Date::forge($staff->birthdate)->format("%d.%m.%Y") : 'Не указано'; ?></i></p>                
                <p><?php echo $staff->data; ?></p>
            </div>
        </div>
    </div>
</div>
