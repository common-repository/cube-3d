<script>



		jQuery(document).ready(function(){



			//jQuery('input[name=faces_color]').wpColorPicker();



			jQuery('#cubes-3d-list .remove').click(function(){

				var c3d = jQuery(this).parent('form').parent('.cube-3d');

				jQuery.post(ajaxurl, {action: 'remove_c3d', id: jQuery(this).attr('rel'), _ajax_nonce: '<?php echo esc_attr(wp_create_nonce( "remove_c3d" )); ?>' }, function(){

					jQuery(c3d).remove();

				});

			});



			//choix d'une image dans la librairie Wordpress

		    jQuery('.form_c3d .choose_img').click(function(e) {

		    	var _this = this;

		        e.preventDefault();

		        var image = wp.media({ 

		            title: 'Upload Image',

		            // mutiple: true if you want to upload multiple files at once

		            multiple: false

		        }).open()

		        .on('select', function(e){

		            // This will return the selected image from the Media Uploader, the result is an object

		            var uploaded_image = image.state().get('selection').first();

		            // We convert uploaded_image to a JSON object to make accessing it easier

		            // Output to the console uploaded_image

		            var image_url = uploaded_image.toJSON().url;

		            // Let's assign the url value to the input field

		            jQuery('.form_c3d input[name=faces_image]').val(image_url);

		        });

		    });



		});



</script>



<h2>All cube 3D</h2>

<form action="" method="post" class="form_c3d">

<?php wp_nonce_field( 'edit_c3d' ) ?>

<b>Add a new cube 3d</b><br />

	<label>Name : </label><input type="text" name="name" /><br />

	<label>Width : </label><input type="text" name="width" />px<br />

	<label>Faces color : </label><input type="color" name="faces_color" /><br />

	<label>Faces image : </label><input type="text" name="faces_image" /> <button class="choose_img button-secondary">Browser library</button><br />

	<input type="submit" value="Add" class="button button-primary" />

</form>



<div id="cubes-3d-list">

<?php



if(sizeof($cubes) > 0)

{

	foreach($cubes as $cube)

	{

		echo '<div class="cube-3d"><form action="" method="post" class="form_c3d">';

		wp_nonce_field( 'edit_c3d', "_wpnonce", true );

		echo '<label>Name : </label><input type="text" name="name" value="'.esc_attr($cube->name).'" /><input type="hidden" name="id" value="'.(int)$cube->id.'" /> <br />';

		echo '<label>Width : </label>';

		echo '<input type="text" name="width" value="'.(int)$cube->width.'" />px<br />';

		echo '<label>Faces color : </label>';

		echo '<input type="color" name="faces_color" value="'.esc_attr($cube->faces_color).'" /><br />';

		echo '<label>Faces image : </label>';

		echo '<input type="text" name="faces_image" value="'.esc_url($cube->faces_image).'" /> <button class="choose_img button-secondary">Browser library</button><br />';

		echo '<input type="image" src="'.esc_url(plugins_url( 'images/save.png', dirname(__FILE__))).'" title="Save" />	

		<img title="Remove this flipping cards grid" class="remove action" rel="'.(int)$cube->id.'" src="'.esc_url(plugins_url( 'images/remove.png', dirname(__FILE__))).'" />

		Shortcode : <input type="text" value="[cube-3d id='.(int)$cube->id.']" readonly />

		</form>

		</div>';

	}

}

else

	echo '</p>No Cube 3D created yet !</p>';



?>

</div>



<div id="c3d_pro">

	<h2>Need more options ? Look at <a href="https://www.info-d-74.com/en/produit/cube-3d-pro-plugin-wordpress/" target="_blank">Cube 3D Pro !</a></h2>

	<a href="http://www.info-d-74.com/produit/cube-3d-pro/" target="_blank">

		<img src="<?php echo esc_url(plugins_url( 'images/pro.png', dirname(__FILE__))) ?>" width="250px" />

	</a>

</div>