<script type="text/javascript">
    var $lastSelectedDates = [];

    function addClickListener(id, fn) {
        $(id).click(function() { fn(event); });
    }

    $(document).ready(function() {
        $("#date-picker" ).multiDatesPicker();
        addClickListener("#date-picker tr td", clickFn);
    });

    function clickFn() {
        var $dates = $( "#date-picker" ).multiDatesPicker('getDates');
        var $table = $('table.interval-table');

        console.log('dates = ' + $dates);
        console.log('lastSelectedDates= ' + $lastSelectedDates);


        if ($dates.length > $lastSelectedDates.length){
            <!-- on add -->
            console.log("adding");

            for(var i=0; i<$dates.length; i++){
                if ($(jQuery.inArray( $dates[i] , $lastSelectedDates))[0] == -1){
                    var newRow =
                        '<tr id="' + $dates[i].hashCode() + '">' +
                            '<td><input type="input" placeholder="Interval for ' + $dates[i] + '" name="' + $dates[i] + '_interval_1"/></td>' +
                            '<td><input type="input" placeholder="Interval for ' + $dates[i] + '" name="' + $dates[i] + '_interval_2"/></td>' +
                            '<td><input type="input" placeholder="Interval for ' + $dates[i] + '" name="' + $dates[i] + '_interval_3"/></td>' +
                            '</tr>';
                    $table.append(newRow);
                }
            }
        }else{
            <!-- on remove -->
            console.log("removing");

            for(var i=0; i<$lastSelectedDates.length; i++){
                if ($(jQuery.inArray( $lastSelectedDates[i] , $dates ))[0] == -1){
                    var idToDelete = $lastSelectedDates[i];
                    $('tr[id=' + idToDelete.hashCode() + ']').remove();
                }
            }
        }

        addClickListener("#date-picker tr td", clickFn);
        $lastSelectedDates = $dates;
    }
</script>


<h2>Create a schedule</h2>

<?php echo form_open('schedules/create') ?>
<div id="form-panel">
    <div class="validation-errors">
        <?php echo validation_errors(); ?>
    </div>
    <p>
        <input style="width:300px" type="input" name="name" placeholder="Schedule name"/>
    </p>

    <p>
        <textarea placeholder="Description" name="description"></textarea>
    </p>

    <div id="date-picker">
    </div>

    <p class="submit">
        <input type="submit" class="large button blue evenspaced" name="submit" value="Create schedule" onclick="getDates()"/>
    </p>
</div>
    <div id="table-container" >
        <table class="interval-table">
        </table>
    </div>
    </form>
