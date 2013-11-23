<script type="text/javascript">
    var dates;

    function addClickListener(id, fn) {
        $(id).click(function() { fn(event); });
    }

    $(document).ready(function() {
        $("#date-picker" ).multiDatesPicker();
        addClickListener("#date-picker tr td", clickFn);
    });

    function clickFn() {
        dates = $( "#date-picker" ).multiDatesPicker('getDates');
        console.log(dates);
        addClickListener("#date-picker tr td", clickFn);
    }

    function getDates(){
        alert(dates);
    }
</script>
<h2>Create a schedule</h2>
<div id="form-panel">
    <div class="validation-errors">
    <?php echo validation_errors(); ?>
    </div>
    <?php echo form_open('schedules/create') ?>

    <p>
    <input type="input" name="name" placeholder="Schedule name"/>
    </p>

    <p>
    <textarea placeholder="Description" name="description"></textarea>
    </p>

    <div id="date-picker">
    </div>
    <p class="submit">
    <input type="submit" class="large button blue evenspaced" name="submit" value="Create schedule" onclick="getDates()"/>
    </p>
    </form>

    <table id="myTable">
        <tbody>
        <tr>...</tr>
        <tr>...</tr>
        </tbody>
    </table>
</div>
