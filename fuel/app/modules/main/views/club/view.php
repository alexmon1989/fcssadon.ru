<div class="row">
    <div class="col-md-12 news">       
        <div class="article">
            <h3><?php echo $article->title; ?></h3>
            
            <?php echo $article->full_text ?>
        </div>
    </div>
</div>

<?php echo render('vk_comments', array('type' => 'article', 'id' => $article->id)); ?>