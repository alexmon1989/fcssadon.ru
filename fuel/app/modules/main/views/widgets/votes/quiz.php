<div class="votes">
    <h4>Опрос</h4>
    <p><b><?php echo $question;; ?></b></p>
    <?php echo Form::open(); ?>
    <?php foreach ($answers as $item): ?>
        <?php if ($item->answer != ''): ?>
            <div class="radio">
                <label>
                    <?php echo Form::radio('answers', $item->answer); ?>
                    <?php echo $item->answer; ?>
                </label>
            </div>    
        <?php endif; ?>
    <?php endforeach; ?>
    <?php echo Form::submit('submit', 'Голосовать', array('class' => 'btn btn-success')); ?>	
    <?php echo Form::close(); ?>
</div>