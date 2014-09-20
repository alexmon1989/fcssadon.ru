<?php echo render('media/nav'); ?>

<div class="row">
    
    <center><?php echo $pagination != '' ? $pagination : '&nbsp'; ?></center>
    
    <?php $сategories = array_values($сategories);?>
    <?php for ($i = 0; $i < count($сategories); $i = $i+3): ?>
    <div class="row">
        <div class="col-md-4 news">       
            <?php if (isset($сategories[$i])): ?>  
                <b><?php echo Html::anchor('media/photos/categories/view/'.$сategories[$i]->id, $сategories[$i]->title); ?></b><br>
                <?php if ($сategories[$i]->photos): ?>
                
                Фотографий: <i><?php echo count($сategories[$i]->photos); ?></i><br>
                <?php echo Html::anchor('media/photos/categories/view/'.$сategories[$i]->id, Asset::img('gallery/thumbnails/'.end($сategories[$i]->photos)->image_path, array('class' => 'img-thumbnail'))); ?>
                
                <?php endif; ?>
                <br><br>
            
            <?php else: ?>
                &nbsp;
            <?php endif; ?>
        </div>
    
        <div class="col-md-4 news">
            <?php if (isset($сategories[$i+1])): ?>
                <b><?php echo Html::anchor('media/photos/categories/view/'.$сategories[$i+1]->id, $сategories[$i+1]->title); ?></b><br>
                Фотографий: <i><?php echo count($сategories[$i+1]->photos); ?></i><br>
                <?php if ($сategories[$i+1]->photos): ?>
                <?php echo Html::anchor('media/photos/categories/view/'.$сategories[$i+1]->id, Asset::img('gallery/thumbnails/'.end($сategories[$i+1]->photos)->image_path, array('class' => 'img-thumbnail'))); ?>
                <?php endif; ?>
                <br><br>
           
            <?php else: ?>
                &nbsp;
            <?php endif; ?>
        </div>
    
        <div class="col-md-4 news">
            <?php if (isset($сategories[$i+2])): ?>
                <b><?php echo Html::anchor('media/photos/categories/view/'.$сategories[$i+1]->id, $сategories[$i+2]->title); ?></b><br>
                Фотографий: <i><?php echo count($сategories[$i+2]->photos); ?></i><br>
                <?php if ($сategories[$i+2]->photos): ?>
                <?php echo Html::anchor('media/photos/categories/view/'.$сategories[$i+2]->id, Asset::img('gallery/thumbnails/'.end($сategories[$i+2]->photos)->image_path, array('class' => 'img-thumbnail'))); ?>
                <?php endif; ?>
                <br><br>
           
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
</div>