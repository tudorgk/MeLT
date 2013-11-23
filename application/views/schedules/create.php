<script type="text/javascript">
    $(document).ready(function() {
        $( "#date-picker" ).multiDatesPicker()
    });

    function getDates(){
        var dates = $( "#date-picker" ).multiDatesPicker('getDates');
        console.log(dates);
        alert(dates);
    }
</script>

<h2>Create a schedule</h2>

<?php echo validation_errors(); ?>

<?php echo form_open('schedules/create') ?>

<label for="name">Schedule name</label>
<input type="input" name="name" /><br />

<label for="Description">Description</label>
<textarea name="description"></textarea><br />

<div id="date-picker">

</div>

<input class="large button blue" type="submit" name="submit" value="Create schedule" onclick="getDates()"/>

</form>
