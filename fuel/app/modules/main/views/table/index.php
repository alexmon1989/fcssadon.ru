<div class="row">
    <div class="col-md-12 news">
        <h4>Таблица чемпионата</h4>
        <?php if ($table): ?>
        <h5><?php echo $table->season->value; ?></h5>
        <table class="table table-striped table-bordered table-results-full">
            <thead>
                <tr>
                    <th>#</th>
                    <th colspan="2">Команда</th>
                    <th>Игр</th>
                    <th>Выигрыши</th>
                    <th>Ничьи</th>
                    <th>Поражения</th>
                    <th>Мячи</th>
                    <th>Очков</th>
                </tr>
            </thead>
            
            <tbody>
                <?php foreach ($table->results as $item): ?>
                <tr<?php echo Config::get('main_team_id') == $item->id ? ' class="success"' : ''; ?>>
                        <td><?php echo $item->place; ?></td>
                        <td class="logo"><?php echo  Asset::img('teams/'.$item->logo_uri); ?></td>
                        <td><?php echo $item->name; ?></td>
                        <td><?php echo $item->games; ?></td>
                        <td><?php echo $item->wins; ?></td>
                        <td><?php echo $item->draws; ?></td>
                        <td><?php echo $item->loss; ?></td>
                        <td><?php echo $item->goals_out . ' - ' . $item->goals_in; ?></td>
                        <td><?php echo $item->points; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <?php else: ?>
            Таблица отсутствует
        <?php endif; ?>
    </div>
</div>