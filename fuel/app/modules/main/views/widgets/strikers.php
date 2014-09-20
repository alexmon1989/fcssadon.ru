<?php if ($settings->show == 1): ?>
    <div class="col-md-6 bombardiers">
        <div class="green-header">ТОП бомбардиры</div>
        
        <div class="description">
            <i><?php echo $season->value; ?></i>                
        </div>
        
        <?php if (count($goals) > 0): ?>
            <table class="table-bombardiers">
                <?php foreach ($goals as $value): ?>
                <tr>
                    <td><?php echo $value['player']; ?></td>
                    <td><?php echo $value['goals']; ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <small>Голов пока не забивали.</small>
        <?php endif; ?>
        
    </div>
<?php endif; ?>