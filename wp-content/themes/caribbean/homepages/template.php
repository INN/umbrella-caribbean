<?php
	global $shown_ids;

	$topstory = largo_home_single_top();
	$shown_ids[] = $topstory->ID;

	$featured_stories = largo_home_featured_stories( 3 );
?>

<div id="widget-area" class="clearfix">
    <div class="widget-area-left">
        <?php
            dynamic_sidebar( 'Homepage Left' );
        ?>
    </div>
    <div class="widget-area-right">
        <?php
            dynamic_sidebar( 'Homepage Right' );
        ?>
    </div>
</div>