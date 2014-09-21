<div class="row">
    <div class="col-md-12 news">
        <h4><?php echo $page_title ?></h4>
        <?php foreach ($articles as $value): ?>
            <div class="article">                    
                <h3><?php echo Html::anchor(Uri::create("news/{$uri}/view/".$value->id), $value->title); ?></h3>

                <div class="details">Когда: <span class="date"><?php echo Date::forge($value->created_at)->format("%d.%m.%Y"); ?></span> / Комментариев: <span class="comments"><?php echo $value->vk_comments_count; ?></span></div>

                <?php echo $value->preview; ?>
                <p><?php echo Html::anchor(Uri::create("news/{$uri}/view/".$value->id), 'Читать далее', array('class' => 'btn btn-success')); ?></p>
            </div>
        <?php endforeach; ?>
        
        <center><?php echo $pagination;?></center>
    </div>
</div>