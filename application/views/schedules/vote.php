<script type="text/javascript">
    $(document).ready(function() {
        var poll = new Poll("text", <?php echo json_encode($dates) ?>);
        // Setting the inner HTML with jQuery
        poll.displayPoll( "#polling-area" );
        $('.polling-table').click(function(){
            poll.addRow();
        })
    });
</script>


<form name="poll-form" ACTION="" METHOD="POST">
<div id="polling-area">
        <?php
        echo '<h3>'.$schedule['name'].'</h3>';
        echo '<h1>'.$schedule['description'].'</h1>';?>
</div>
</FORM>
<?php echo  json_encode($dates)?>
    <div id="disqus-area">
        <div id="disqus_thread"></div>
        <script type="text/javascript">
            /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
            var disqus_shortname = 'melt2' ; // required: replace example with your forum shortname

            /* * * DON'T EDIT BELOW THIS LINE * * */
            (function() {
                var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
                dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
                (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
            })();
        </script>
    </div>
