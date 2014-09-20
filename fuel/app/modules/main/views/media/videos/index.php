<?php echo render('media/nav'); ?>

<div class="row">
    
    <center><?php echo $pagination != '' ? $pagination : '&nbsp'; ?></center>
    
    <?php $videos = array_values($videos);?>
    <?php for ($i = 0; $i < count($videos); $i = $i+2): ?>
        <div class="col-md-6">            
            <iframe width="460" height="275" src="//www.youtube.com/embed/<?php echo $videos[$i]->videoid; ?>" frameborder="0" allowfullscreen></iframe>
            <p><b><?php echo $videos[$i]->title; ?></b><br><br></p>
        </div>
        <div class="col-md-6">
            <?php if (isset($videos[$i+1])): ?>
            <iframe width="460" height="275" src="//www.youtube.com/embed/<?php echo $videos[$i+1]->videoid; ?>" frameborder="0" allowfullscreen></iframe>
            <p><b><?php echo $videos[$i+1]->title; ?></b><br><br></p>
            <?php else: ?>
                &nbsp;
            <?php endif; ?>
        </div>
    <?php endfor; ?>
    
    <div class="row">
        <div class="col-md-12">            
            <center><?php echo $pagination; ?></center>
        </div>
    </div>
</div>