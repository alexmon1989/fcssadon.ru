<div class="row">
    <div class="col-md-12 news">
        <h4>Персонал</h4>
        
        <?php if ($staff): ?>
                <?php $staff = array_values($staff); ?>
        
                <?php for ($i = 0; $i <= count($staff); $i = $i + 6): ?>
                    <div class="row">
                        <?php for ($j=0; $j<=5; $j++): ?>
                        <div class="col-md-2 player">
                            <?php if (isset($staff[$i+$j])): ?>
                                <?php if ($staff[$i+$j]->image_uri): ?>
                                    <?php echo Html::anchor('team/staff/view/'.$staff[$i+$j]->id, Asset::img('staff/'.$staff[$i+$j]->image_uri, array('class' => 'img-thumbnail'))); ?>
                                <?php else: ?>
                                    <?php echo Html::anchor('team/staff/view/'.$staff[$i+$j]->id, Asset::img('players/no.png', array('class' => 'img-thumbnail'))); ?>
                                <?php endif; ?>
                                <?php echo Html::anchor('team/staff/view/'.$staff[$i+$j]->id, $staff[$i+$j]->staff_name); ?>
                            <?php endif; ?>
                        </div>
                        <?php endfor; ?>
                    </div>
                <?php endfor; ?>
        
        <?php else: ?>
                <p>Персонал отсутствует.</p>
        <?php endif; ?>
        
    </div>
</div>
