<?php if ($slider): ?>
<div class="slider">
    <div id="slider_main_image"></div>

    <ul id="slider_thumbs" class="list-inline">
        <?php foreach ($slider as $item): ?>
        <li>
            <?php echo Html::anchor('assets/img/slider/'.$item->img_path, Asset::img('slider/'.$item->img_path, array('height'=>60, 'data-desoslide-caption'=>$item->description, 'data-desoslide-href'=>Uri::create($item->uri)))); ?>
        </li>
        <?php endforeach; ?>
    </ul>            
</div>
<?php endif; ?>