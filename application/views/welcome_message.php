<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="shortcut icon" href="favicon.ico">
    <title>MeLT</title>

    <!-- loads jquery and jquery ui -->
    <script type="text/javascript" src="<?php echo asset_url();?>js/jquery-1.10.2.min.js"></script>

    <!-- loads some utilities (not needed for your developments) -->
    <link rel="stylesheet" type="text/css" href="<?php echo asset_url();?>css/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo asset_url();?>css/main.css">
    <link rel="stylesheet" type="text/css" href="<?php echo asset_url();?>css/normalize.css">
    <link rel="stylesheet" type="text/css" href="<?php echo asset_url();?>css/prettify.css">
    <script type="text/javascript" src="<?php echo asset_url();?>js/prettify.js"></script>
    <script type="text/javascript" src="<?php echo asset_url();?>js/lang-css.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#generate-schedule-button").click(function () {
                $.ajax({
                    type: "POST",
                    url: "controllers/ScheduleManagerHandler.php",
                    data: {generateSchedule:true},
                    dataType: "html",
                    async: false,
                    success: function(hash){
                        alert("success");
                    },
                    fail: function(){
                        alert("did fail");
                    }
                });
            });
        });
    </script>
    <script type="text/javascript">
        $(function() {
            prettyPrint();
        });
    </script>

</head>
<body>
<div id="header">
    <h2>MeLT</h2>
</div>
<div id="page" style="text-align: center">
    <h3>Hi there! Welcome to MeLT!</h3>
    <p>Melt is a super-minimalistic event planner. You just set your time frames and share the link with other people.
        They in turn will set their time-frames and you can see when can you set your meeting point.</p>
    <p style="text-align: center">
        <a class="large button blue" id="generate-schedule-button">Generate Schedule</a>
    </p>
</div>
</body>
</html>