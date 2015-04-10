<li class="nt-editable box bannerWidget<?php echo ($settings['class']) ? " ".$settings['class'] : ''; ?>" id="<?php echo $widgetName; ?>">
<?php if ($heading_title) { ?><div class="header" id="<?php echo $widgetName; ?>Header"><hgroup><h1><?php echo $heading_title; ?></h1></hgroup></div><?php } ?>
<?php if (count($banner['items'])) { ?>
<div class="content" id="<?php echo $widgetName; ?>Content">
    <div class="plasma_player" id="<?php echo $widgetName; ?>slider">
	    <ul>
	    <?php foreach ($banner['items'] as $item) { ?>
	        <?php if (empty($item['image'])) continue; ?>
	    	<li class="slide">
	    		<?php if (!empty($item['link'])) { ?><a href="<?php echo $item['link']; ?>" title="<?php echo $item['title']; ?>"><?php } ?>
	        	<img src="<?php echo HTTP_IMAGE . $item['image']; ?>" alt="<?php echo $item['title']; ?><em><?php echo $item['description']; ?></em>" />
	        	<?php if (!empty($item['link'])) { ?></a><?php } ?>
		    </li>
	    <?php } ?>
	    </ul>
    </div>
</div>
<div class="clear"></div><br />
<script>
if (!$.fx.plasma_slideshow) {
    $(document.createElement('link')).attr({
        'href':'<?php echo HTTP_CSS; ?>sliders/plasma-v1.0/slider.css',
        'rel':'stylesheet',
        'media':'screen'
    }).appendTo('head');
    $(document.createElement('script')).attr({
        'src':'<?php echo HTTP_JS; ?>sliders/plasma-v1.0/slider.js',
        'type':'text/javascript'
    }).appendTo('head');
}
$(function() {
    var ref = $("#<?php echo $widgetName; ?>slider").plasma_slideshow({
    	auto_play: true,
        navi_offset: 0,
        navi_position: 'bottom',
	navi_mode: 'full',
	slide_easing_type: 'easeOutBack'
    });
									
    $('#prev_ext_button').click(function() {
        ref.plasma_slideshow.Prev_Slide();
    });
			
    $('#play_ext_button').click(function() {
        ref.plasma_slideshow.Toggle_Play();
    });
			
    $('#next_ext_button').click(function() {
        ref.plasma_slideshow.Next_Slide();
    });
			
    $('#show_ext_button').click(function() {
        var index = parseInt( $('#slide_number').val() );
	if( !isNaN( index ) ) {
            var ret = ref.plasma_slideshow.Show_Slide( index );
            if( !ret ) alert("Index out of bounds!!!");
	} 
    });
			
    $('#tooltip_button').on('click', function(event) {
        alert("You clicked: '" + $(this).text() + "' button");
    });
			
    function getCurrentTime() {
        var date = new Date();
	hours = date.getHours();
	minutes = date.getMinutes();
	seconds = date.getSeconds();
	mili_seconds = date.getMilliseconds();
	
        if( hours < 10 ) {
            hours = "0" + hours;
        }
	if( minutes < 10 ) {
            minutes = "0" + minutes;
        }
	if( seconds < 10 ) {
            seconds = "0" + seconds;
        }
	if( mili_seconds < 10 ) {
            mili_seconds = "00" + mili_seconds;
        }
	else if( mili_seconds < 100 ) {
            mili_seconds = "0" + mili_seconds;
        }
					
	return hours + ":" + minutes + ":" + seconds + "." + mili_seconds;
    }	
			
    ref.on('plasma_slide_triggered', function(event, param) { 
        console.log(getCurrentTime() + " - Slide trigger event: " + event.type + ", index: " + param + "\n");
    });
		  
    ref.on('plasma_slide_mouseleave', function(event, param) {
        console.log(getCurrentTime() + " - Slide mouseleave event, index: " + param);
    });
		  
    ref.on('plasma_slide_showed', function(event, param) {
        console.log(getCurrentTime() + " - Slide showed event, index: " + param);
    });
		  
    ref.on('plasma_playback_state_changed', function(event, param) { 
        var text = ( param ) ? 'Pause':'Play';
	$('#play_ext_button').text(text);
        console.log(getCurrentTime() + " - Playback state changed, is playing: " + param);
    });
    
    ref.on('plasma_next_clicked', function(event) {
        console.log(getCurrentTime() + " - Next clicked!");
    });
		  
    ref.on('plasma_prev_clicked', function(event) {
        console.log(getCurrentTime() + " - Prev clicked!");
    });
		  
    ref.on('plasma_play_clicked', function(event) {
        console.log(getCurrentTime() + " - Play/Pause clicked!");
    });											
});	
</script>
<?php } ?>
</li>