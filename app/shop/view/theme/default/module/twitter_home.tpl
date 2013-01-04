<div class="content">
    <div class="header"><hgroup><h1>Tweets</h1></hgroup></div>
    <div class="content">
        <div id="twitterUserTimeline" class="tweets"></div>
        <div id="twitterSearch" class="tweets"></div>
    </div>
</div>
<script type="text/javascript">
$('#twitterSearch').liveTwitter('<?php echo $twitter_search; ?>', {limit: <?php echo $twitter_search_limit; ?>, rate: <?php echo $twitter_search_rate; ?>});
$('#twitterUserTimeline').liveTwitter('<?php echo $twitter_time; ?>', {limit: <?php echo $twitter_time_limit; ?>, refresh: <?php echo $twitter_time_refresh; ?>, mode: '<?php echo $twitter_time_mode; ?>'});
$('#searchLinks a').each(function(){
    var query = $(this).text();
    $(this).click(function(){
        $('#twitterSearch').liveTwitter(query);
        $('#searchTerm').text(query);
        return false;
    });
});
</script>