
<?php foreach ($schedules as $schedule_item): ?>

    <h2><?php echo $schedule_item['name'] ?></h2>
    <div id="main">
        <?php echo $schedule_item['description'] ?>
    </div>
    <p><a href="schedules/<?php echo $schedule_item['id'] ?>">View schedule</a></p>

<?php endforeach ?>
