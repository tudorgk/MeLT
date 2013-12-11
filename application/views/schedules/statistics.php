<div class="statistics-panel clearfix" id = "statistics-panel-id">
    <canvas id="canvas" height="300" width="600"></canvas>
</div>

<script>
    $(document).ready(function() {
        generateStatics(document,<?php echo json_encode($dates)?>, <?php echo json_encode($user_votes)?> );
    });
</script>