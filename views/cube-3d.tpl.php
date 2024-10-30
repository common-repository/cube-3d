<style>



#cube-3d-<?php echo (int)$atts['id'] ?> {

	margin: <?php echo (int)floor($cube->width/2) ?>px;

}



#cube-3d-<?php echo (int)$atts['id'] ?> .cube-3d {

  	width: <?php echo (int)$cube->width ?>px;

	height: <?php echo (int)$cube->width ?>px;

}

#cube-3d-<?php echo (int)$atts['id'] ?> .cube-3d div{

	transform-origin: 50% 50% -<?php echo (int)floor($cube->width/2) ?>px;

	-webkit-transform-origin: 50% 50% -<?php echo (int)floor($cube->width/2) ?>px;

	width: <?php echo (int)$cube->width ?>px;

	height: <?php echo (int)$cube->width ?>px;

	background: <?php echo esc_attr($cube->faces_color) ?> url(<?php echo esc_url($cube->faces_image) ?>) no-repeat top left;

	background-size:  100% 100%;

}



</style>



<div id="cube-3d-<?php echo (int)$atts['id'] ?>">

	<div class="cube-3d">

		<div class="front"></div>

		<div class="back"></div>

		<div class="right"></div>

		<div class="left"></div>

		<div class="up"></div>

		<div class="bottom"></div>

	</div>

</div>