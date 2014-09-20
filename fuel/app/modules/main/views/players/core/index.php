<div class="row">
    <div class="col-md-12 news">
        <h4>Основной состав</h4>
        <?php foreach ($players as $value): ?>
            
            <h5><b><?php echo $value->value; ?>:</b></h5>
            
            <?php if ($value->players): ?>
                <?php $value->players = array_values($value->players); ?>
            
                <?php for ($i = 0; $i <= count($value->players); $i = $i + 6): ?>
                    <div class="row">
                        <?php for ($j=0; $j<=5; $j++): ?>
                        <div class="col-md-2 player">
                            <?php if (isset($value->players[$i+$j])): ?>
                                <?php if ($value->players[$i+$j]->image_uri): ?>
                                    <?php echo Html::anchor('team/core/view/'.$value->players[$i+$j]->id, Asset::img('players/'.$value->players[$i+$j]->image_uri, array('class' => 'img-thumbnail'))); ?>
                                <?php else: ?>
                                    <?php echo Html::anchor('team/core/view/'.$value->players[$i+$j]->id, Asset::img('players/no.png', array('class' => 'img-thumbnail'))); ?>
                                <?php endif; ?>
                                <?php echo Html::anchor('team/core/view/'.$value->players[$i+$j]->id, $value->players[$i+$j]->player_name); ?>
                            <?php endif; ?>
                        </div>
                        <?php endfor; ?>
                    </div>
                <?php endfor; ?>
            
            <?php else: ?>
                <p><?php echo $value->value; ?> отсутствуют.</p>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>
