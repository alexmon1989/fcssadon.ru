<div class="videos">
        <h4>Видео</h4>

        <?php foreach ($videos as $item): ?>    
            <iframe width="365" height="250" src="//www.youtube.com/embed/<?php echo $item->videoid; ?>" frameborder="0" allowfullscreen></iframe>        
        <?php endforeach; ?>
</div>