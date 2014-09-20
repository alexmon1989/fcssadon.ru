<div class="row">
    <div class="col-md-12 content">
        
        <h4>Медиа</h4>
        
        <br>
        
        <ul class="nav nav-pills">
            <li class="<?php echo Arr::get($subnav, 'photos'); ?>"><?php echo Html::anchor('media/photos', 'Фото') ?></li>
            <li class="<?php echo Arr::get($subnav, 'videos'); ?>"><?php echo Html::anchor('media/videos', 'Видео') ?></li>
        </ul>
    </div>
</div>

