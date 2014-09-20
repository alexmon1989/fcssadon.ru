<div class="row">
    <div class="col-md-12 news">     
        <script type="text/javascript">
            VK.init({
                apiId: 4427613,
                onlyWidgets: true
            });
        </script>
        
        <div id="vk_comments"></div>
        
        <script type="text/javascript">
            function my_vk_callback(num, last_comment, date, sign) {
                <?php if ($type == 'article'): ?>
                    $.post("/main/articles/base/change_comments_num", {num : num, id : <?php echo $id; ?>});
                <?php endif; ?>
                    
                <?php if ($type == 'match'): ?>
                    $.post("/main/matches/change_comments_num", {num : num, id : <?php echo $id; ?>});
                <?php endif; ?>
            }
            
            VK.Widgets.Comments('vk_comments', {autoPublish: 0, onChange: my_vk_callback});
            
        </script>
    </div>
</div>