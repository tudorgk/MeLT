<script type="text/javascript">
    var lastSelectedDates = [];

    function addClickListener(id, fn) {
        $(id).click(function() { fn(event); });
    }

    function get_type(thing){
        if(thing===null)return "[object Null]"; // special case
        return Object.prototype.toString.call(thing);
    }


    $(document).ready(function() {
        $("#date-picker" ).multiDatesPicker();
        addClickListener("#date-picker tr td", clickFn);

        // Attach a submit handler to the form
        $( "#schedule-form" ).submit(function( event ) {

            // Stop form from submitting normally
            event.preventDefault();

            // Get some values from elements on the page:
            var $form = $( this),
                scheduleName = $form.find( "input[name='name']" ).val(),
                scheduleDescription = $form.find( "textarea[name='description']" ).val(),
                url = $form.attr( "action" );

            var datesDictionary = [];
            //Get the dates and intervals and put them in a dictionary
            for (var i = 0 ; i < lastSelectedDates.length ; i++){
                var intervalArray = [];

                var interval1 = $form.find( 'input[name=' + lastSelectedDates[i] + '_interval_1]').val();
                var interval2 = $form.find( 'input[name=' + lastSelectedDates[i] + '_interval_2]').val();
                var interval3 = $form.find( 'input[name=' + lastSelectedDates[i] + '_interval_3]').val();

                intervalArray.push(interval1,interval2,interval3);

                datesDictionary.push({
                    key : lastSelectedDates[i],
                    value : intervalArray
                });

            }
            // Send the data using post
            var posting = $.post( url, { name: scheduleName,
                                         description : scheduleDescription,
                                         selectedDates : datesDictionary
            });

            // Put the results in a div
            posting.done(function( data ) {
                var newDoc = document.open("text/html", "replace");
                newDoc.write(data);
                newDoc.close();
            });
        });
    });

    function clickFn() {
        var dates = $( "#date-picker" ).multiDatesPicker('getDates');
        var table = $('table.interval-table');

        for(var i =0; i< dates.length; i++){
            dates[i] = dates[i].replace(/\//g, "-");
        }
        for(var i =0; i< lastSelectedDates.length; i++){
            lastSelectedDates[i] = lastSelectedDates[i].replace(/\//g, "-");
        }

        if (dates.length > lastSelectedDates.length){
            <!-- on add -->
            console.log("adding");

            for(var i=0; i<dates.length; i++){
                if ($(jQuery.inArray( dates[i] , lastSelectedDates))[0] == -1){
                    var newRow =
                        '<tr id="' + dates[i] + '">' +
                            '<td><input type="input" placeholder="Interval for ' + dates[i] + '" name="' + dates[i] + '_interval_1" required/></td>' +
                            '<td><input type="input" placeholder="Interval for ' + dates[i] + '" name="' + dates[i] + '_interval_2"/></td>' +
                            '<td><input type="input" placeholder="Interval for ' + dates[i] + '" name="' + dates[i] + '_interval_3"/></td>' +
                            '</tr>';
                    table.append(newRow);
                }
            }
        }else{
            <!-- on remove -->
            console.log("removing");

            for(var i=0; i<lastSelectedDates.length; i++){
                if ($(jQuery.inArray( lastSelectedDates[i] , dates ))[0] == -1){
                    var idToDelete = lastSelectedDates[i];
                    $('tr[id=' + idToDelete+ ']').remove();
                }
            }
        }

        addClickListener("#date-picker tr td", clickFn);
        lastSelectedDates = dates;
    }

</script>


<h2>Create a schedule</h2>

<?php
$attributes = array('id' => 'schedule-form');
echo form_open('schedules/create',$attributes) ?>
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
        <input type="submit" class="large button blue evenspaced" name="submit" value="Create schedule"/>
    </p>
</div>
    <div id="table-container" >
        <table class="interval-table">
        </table>
    </div>
</form>
