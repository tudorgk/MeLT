<script type="text/javascript">
    $(document).ready(function() {
        var poll = new Poll("text", <?php echo json_encode($dates) ?>,<?php
        echo json_encode($schedule['id']);?>);
        // Setting the inner HTML with jQuery
        poll.displayPoll( "#polling-area" );
        poll.attachForm(document,document.getElementById("poll-form"),<?php
        echo json_encode($schedule['id']);?>);
        poll.populateTable(<?php echo json_encode($user_votes);?>)
    });
</script>

<?php
$attributes = array('id' => 'poll-form','name' => 'poll-form');
echo form_open('schedules/submitVote/'.$schedule['link_hash'],$attributes) ?>
<div id="polling-area">
        <?php
        echo '<h3>'.$schedule['name'].'</h3>';
        echo '<h1>'.$schedule['description'].'</h1>';?>
</div>
</FORM>
