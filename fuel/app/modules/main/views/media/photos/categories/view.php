<?php echo render('media/nav'); ?>

<?php if ($photos): ?>
    <br>
    <div class="row">
        <h3><?php echo current($photos)->category->title; ?></h3>
    
        <p><?php echo Html::anchor('media/photos', 'Назад ко всем галереям') ?></p>
            
        <center><?php echo $pagination != '' ? $pagination : '&nbsp'; ?></center>
    </div>
    
     
    <?php $photos = array_values($photos);?>
    <?php for ($i = 0; $i < count($photos); $i = $i+3): ?>
    <div class="row">
        <div class="col-md-4 news">       
            <?php if (isset($photos[$i])): ?>            
            <p>   
                <?php echo Html::anchor('assets/img/gallery/'.$photos[$i]->image_path, Asset::img('gallery/thumbnails/'.$photos[$i]->image_path, array('class' => 'img-thumbnail')), array('data-lightbox' => 'gallery')); ?>                
                <br><br>
            </p>
            
            <?php else: ?>
                &nbsp;
            <?php endif; ?>
        </div>
    
        <div class="col-md-4 news">
            <?php if (isset($photos[$i+1])): ?>
            <p>
                <?php echo Html::anchor('assets/img/gallery/'.$photos[$i+1]->image_path, Asset::img('gallery/thumbnails/'.$photos[$i+1]->image_path, array('class' => 'img-thumbnail')), array('data-lightbox' => 'gallery')); ?>                
                <br><br>
            </p>
           
            <?php else: ?>
                &nbsp;
            <?php endif; ?>
        </div>
     
        <div class="col-md-4 news">
            <?php if (isset($photos[$i+2])): ?>
            <p>
                <?php echo Html::anchor('assets/img/gallery/'.$photos[$i+2]->image_path, Asset::img('gallery/thumbnails/'.$photos[$i+2]->image_path, array('class' => 'img-thumbnail')), array('data-lightbox' => 'gallery')); ?>                
                <br><br>
            </p>
           
            <?php else: ?>
                &nbsp;
            <?php endif; ?>
        </div>
    </div>
    <?php endfor; ?>
    
    <div class="row">
        <div class="col-md-12">            
            <center><?php echo $pagination; ?></center>            
        </div>
    </div>
<?php else: ?>
     Фотографии отсутствуют.     
    <p><?php echo Html::anchor('media/photos', 'Назад ко всем галереям') ?></p>
<?php endif; ?>
     
