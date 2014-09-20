<div class="votes">
    <h4>Опрос</h4>
    <p><b><?php echo $question;; ?></b></p>
    <?php foreach ($answers as $item): ?>
        <?php if ($item->answer != ''): ?>
            <?php echo $item->answer . ' (' . $item->count . ')'; ?>
            <div class="progress">
                <?php $count != 0 ? $value = round(($item->count*100)/$count) : $value = 0; ?>
                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $value; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $value; ?>%;">
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
    
    Всего проголосовало: <?php echo $count; ?>
</div>