<div class="row">
    <div class="col-md-8 news">
        <h4><?php echo Html::anchor(Uri::create('news'), 'Новости'); ?></h4>

        <?php foreach ($news as $value): ?>
            <div class="article">                    
                <h3><?php echo Html::anchor(Uri::create('news/shahter/view/'.$value->id), $value->title); ?></h3>

                <div class="details">Когда: <span class="date"><?php echo Date::forge($value->created_at)->format("%d.%m.%Y"); ?></span> / Комментариев: <span class="comments"><?php echo $value->vk_comments_count; ?></span></div>

                <?php echo $value->preview; ?>             
                <p><?php echo Html::anchor(Uri::create('news/shahter/view/'.$value->id), 'Читать далее', array('class' => 'btn btn-success')); ?></p>
            </div>
        <?php endforeach; ?>

    </div>

    <div class="col-md-4">
        <?php $videos = Request::forge('main/widgets/videos', false)->execute(); echo $videos; ?>    
        <?php $votes = Request::forge('main/widgets/votes', false)->execute(); echo $votes; ?>    
    </div>
</div>