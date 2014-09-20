<div class="row">
    <div class="col-md-12 news">
        <h4>Список сезонов и соревнований</h4>
        <br>
        <?php foreach ($seasons as $item): ?>
        <h5><strong><?php echo Html::anchor('team/calendar/view/'.$item->id, $item->value); ?></strong></h5>
        <?php endforeach; ?>
        <br>
    </div>
</div>
