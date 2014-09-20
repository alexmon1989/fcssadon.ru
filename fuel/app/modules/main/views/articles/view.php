<div class="row">
    <div class="col-md-12 news">       
        <div class="article">
            <h3><?php echo $article->title; ?></h3>

            <div class="details">Когда: <span class="date"><?php echo Date::forge($article->created_at)->format("%d.%m.%Y"); ?></span> / Комментариев: <span class="comments"><?php echo $article->vk_comments_count; ?></span></div>

            <?php echo $article->full_text ?>
        </div>
    </div>
</div>

<?php echo render('vk_comments', array('type' => 'article', 'id' => $article->id)); ?>