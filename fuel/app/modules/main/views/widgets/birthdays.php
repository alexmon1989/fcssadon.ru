<div class="green-header">Happy Birthday</div>

<?php if (count($birthdays) > 0): ?>
<table class="table-birthdays">   
    <?php foreach ($birthdays as $item): ?>
        <tr>
            <td><?php echo Date::forge($item->birthdate)->format("%d.%m.%Y"); ?></td>
            <?php $name = explode(' ', $item->player_name); ?> 
            <td><?php echo Html::anchor('team/core/view/'.$item->id, $name[0]); ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<?php else: ?>
    <div class="no_birthdays">Дни рождения отсутствуют.</div>
<?php endif; ?>


