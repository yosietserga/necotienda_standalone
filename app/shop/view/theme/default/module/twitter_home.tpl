<div class="content">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center">
        <h1 id="searchLinks">Tweets</h1>
    </div>
</div>
<div class="middle">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center">
        <div id="twitterUserTimeline" class="tweets"></div>
        <div id="twitterSearch" class="tweets"></div>
    </div>
</div>
<div class="bottom">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center"></div>
</div>
	<script type="text/javascript">
		$('#twitterSearch').liveTwitter('<?php echo $twitter_search; ?>', {limit: <?php echo $twitter_search_limit; ?>, rate: <?php echo $twitter_search_rate; ?>});
		$('#twitterUserTimeline').liveTwitter('<?php echo $twitter_time; ?>', {limit: <?php echo $twitter_time_limit; ?>, refresh: <?php echo $twitter_time_refresh; ?>, mode: '<?php echo $twitter_time_mode; ?>'});
		$('#searchLinks a').each(function(){
			var query = $(this).text();
			$(this).click(function(){
				// Update the search
				$('#twitterSearch').liveTwitter(query);
				// Update the header
				$('#searchTerm').text(query);
				return false;
			});
		});

</script>