<h2>Список матчей</h2>
<br>

<p>
	<?php echo Html::anchor('admin/competitions/matches/create', 'Создать', array('class' => 'btn btn-success')); ?>
</p>


<?php if ($matches): ?>
<table class="table table-striped table-bordered table-hover" id="matches" border="0" cellpadding="0" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th width="10%">Команда 1</th>
			<th width="10%">Команда 2</th>
			<th width="10%">Статус</th>
			<th>Сезон</th>
			<th width="10%">Дата матча</th>
			<th>Название</th>
			<th>Счёт</th>
			<th>Создано</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
        <tfoot>
		<tr>
			<th class="filter">Команда 1</th>
			<th class="filter">Команда 2</th>
			<th class="filter">Статус</th>
			<th class="filter">Сезон</th>
			<th class="filter">Дата матча</th>
			<th class="filter">Название</th>
			<th class="filter">Счёт</th>
			<th class="filter">Создано</th>
			<th>&nbsp;</th>
		</tr>
	</tfoot>
	<tbody>
<?php foreach ($matches as $item): ?>		<tr>

			<td><?php echo $item->team_1->value; ?></td>
			<td><?php echo $item->team_2->value; ?></td>
			<td><?php echo $item->status->value; ?></td>
			<td><?php echo $item->season->value; ?></td>
			<td><?php echo $item->date ? Date::forge($item->date)->format("%d.%m.%Y") : '-'; ?></td>
			<td><?php echo $item->name; ?></td>
			<td><?php echo $item->team_1_goals . ' - ' . $item->team_2_goals; ?></td>
			<td><?php echo Date::forge($item->created_at)->format("%d.%m.%Y"); ?></td>
			<td>
                            <div class="btn-toolbar">
                                <div class="btn-group">
                                    <?php echo Html::anchor('admin/competitions/matches/edit/'.$item->id, '<i class="glyphicon glyphicon-edit"></i>', array('class' => 'btn btn-sm btn-primary', 'title' => 'Редактировать')); ?>
                                    <?php echo Html::anchor('admin/competitions/matches/delete/'.$item->id, '<i class="glyphicon glyphicon-trash"></i>', array('class' => 'btn btn-sm btn-danger', 'title' => 'Удалить', 'onclick' => "return confirm('Вы уверены?')")); ?>
                                </div>
                            </div>   
			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<script>    
    $(document).ready(function() {
        
        (function($) {
        /*
         * Function: fnGetColumnData
         * Purpose:  Return an array of table values from a particular column.
         * Returns:  array string: 1d data array
         * Inputs:   object:oSettings - dataTable settings object. This is always the last argument past to the function
         *           int:iColumn - the id of the column to extract the data from
         *           bool:bUnique - optional - if set to false duplicated values are not filtered out
         *           bool:bFiltered - optional - if set to false all the table data is used (not only the filtered)
         *           bool:bIgnoreEmpty - optional - if set to false empty values are not filtered from the result array
         * Author:   Benedikt Forchhammer <b.forchhammer /AT\ mind2.de>
         */
        $.fn.dataTableExt.oApi.fnGetColumnData = function ( oSettings, iColumn, bUnique, bFiltered, bIgnoreEmpty ) {
            // check that we have a column id
            if ( typeof iColumn == "undefined" ) return new Array();

            // by default we only want unique data
            if ( typeof bUnique == "undefined" ) bUnique = true;

            // by default we do want to only look at filtered data
            if ( typeof bFiltered == "undefined" ) bFiltered = true;

            // by default we do not want to include empty values
            if ( typeof bIgnoreEmpty == "undefined" ) bIgnoreEmpty = true;

            // list of rows which we're going to loop through
            var aiRows;

            // use only filtered rows
            if (bFiltered == true) aiRows = oSettings.aiDisplay;
            // use all rows
            else aiRows = oSettings.aiDisplayMaster; // all row numbers

            // set up data array   
            var asResultData = new Array();

            for (var i=0,c=aiRows.length; i<c; i++) {
                iRow = aiRows[i];
                var aData = this.fnGetData(iRow);
                var sValue = aData[iColumn];

                // ignore empty values?
                if (bIgnoreEmpty == true && sValue.length == 0) continue;

                // ignore unique values?
                else if (bUnique == true && jQuery.inArray(sValue, asResultData) > -1) continue;

                // else push the value onto the result data array
                else asResultData.push(sValue);
            }

            return asResultData;
        }}(jQuery));


        function fnCreateSelect( aData )
        {
            var r='<select style="max-width: 110px;"><option value=""></option>', i, iLen=aData.length;
            for ( i=0 ; i<iLen ; i++ )
            {
                r += '<option value=\''+aData[i]+'\'>'+aData[i]+'</option>';
            }
            return r+'</select>';
        }
                
        var table = $('#matches').dataTable({"oLanguage": {
            "sUrl": "<?php echo Uri::create('assets/js/datatables_ru.txt'); ?>"
        }});
        
        /* Add a select menu for each TH element in the table footer */
        $("tfoot th.filter").each( function ( i ) {
            this.innerHTML = fnCreateSelect( table.fnGetColumnData(i) );
            $('select', this).change( function () {
                table.fnFilter( $(this).val(), i );
            } );
        } );
    } );    
</script>

<?php else: ?>
<p>Матчи отсутствуют.</p>

<?php endif; ?>