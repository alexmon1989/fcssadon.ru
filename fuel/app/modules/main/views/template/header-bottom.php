<div class="row header-bottom">      
    <div class="col-md-5 col-xs-12">        
        <?php $slider = Request::forge('main/widgets/slider', false)->execute(); echo $slider; ?>
    </div>   

    <div class="col-md-4">
        <div class="row">

            <div class="col-md-6 next-match">
                <?php $next_match = Request::forge('main/widgets/next_match', false)->execute(); echo $next_match; ?>                
            </div>

            <div class="col-md-6 previous-match">
                <?php $previous_match = Request::forge('main/widgets/previous_match', false)->execute(); echo $previous_match; ?>    
            </div>
        </div>

        <div class="row">

            <?php $strikers = Request::forge('main/widgets/strikers', false)->execute(); echo $strikers; ?>
            

            <div class="col-md-6 birthdays">
                <?php $birthdays = Request::forge('main/widgets/birthdays', false)->execute(); echo $birthdays; ?>                
            </div>
        </div>
    </div>

    <div class="col-md-3 results">
        <?php $table = Request::forge('main/widgets/table', false)->execute(); echo $table; ?>             
    </div>

</div>