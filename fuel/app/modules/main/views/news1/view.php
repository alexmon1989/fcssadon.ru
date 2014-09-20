<div class="row">
    <div class="col-md-12 news">       
        <div class="article">
            <h3><?php echo $news->title; ?></h3>

            <div class="details">Когда: <span class="date"><?php echo Date::forge($news->created_at)->format("%d.%m.%Y"); ?></span> / Комментариев: <span class="comments">7</span></div>

            <?php echo $news->full_text ?>
        </div>
    </div>
</div>