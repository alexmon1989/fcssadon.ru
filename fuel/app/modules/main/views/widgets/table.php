<?php if ($results): ?>
    <div class="black-header">Таблица чемпионата</div>
    
    <table class="table-results">
        <thead>
            <tr>
                <th width="10%">#</th>
                <th>Команда</th>
                <th>И</th>
                <th>О</th>
              </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $item): ?>
                <tr>
                    <td><?php echo $item->place; ?></td>
                    <td><?php echo $item->name; ?></td>
                    <td><?php echo $item->games; ?></td>
                    <td><?php echo $item->points; ?></td>
                </tr>                
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <p style="text-align: right; margin-right: 15px;"><?php echo Html::anchor('table/'.$season_id, 'Детальнее') ?></p>
    
    <script>
        $(function() {
            // Раскрашиваем строку нашей команды в зелёный цвет
            $('td:contains("Шахтёр Садон")').parent().css( "background-color", "#5CB85C" );
        });        
    </script>
<?php endif; ?>

        