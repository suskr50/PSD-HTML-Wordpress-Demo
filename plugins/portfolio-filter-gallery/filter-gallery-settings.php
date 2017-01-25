<?php
//toggle button CSS
wp_enqueue_style('awl-em-css', plugin_dir_url( __FILE__ ) . 'css/toogle-button.css');
wp_enqueue_style('awl-go-top-css', plugin_dir_url( __FILE__ ) . 'css/go-to-top.css');
wp_enqueue_style( 'vg-font-awesome-css', plugin_dir_url( __FILE__ ).'css/font-awesome.min.css' );
wp_enqueue_style( 'awl-bootstrap-css', plugin_dir_url( __FILE__ ) .'css/bootstrap.css' );
wp_enqueue_style('awl-styles-css', plugin_dir_url( __FILE__ ) . 'css/styles.css');

//js
wp_enqueue_script('jquery');
wp_enqueue_script( 'awl-bootstrap-js',  plugin_dir_url( __FILE__ ) .'js/bootstrap.js', array( 'jquery' ), '', true  );
wp_enqueue_script( 'awl-go-top-js', plugin_dir_url( __FILE__ ) .'js/go-to-top.js', array( 'jquery' ), '', true  );

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
//load settings
$pf_gallery_settings = unserialize(base64_decode(get_post_meta( $post->ID, 'awl_filter_gallery'.$post->ID, true)));
$image_gallery_id = $post->ID;
?>
<!-- Return to Top -->
<a href="javascript:" id="return-to-top"><i class="fa fa-chevron-up"></i></a>

<style>
.selectbox_settings {
	width: 300px;
	margin-left: 20px;
} 
.pfg_cmnt_setting {
	font-size: 17px !important;
	padding-left: 20px;
	font: initial;
	margin-top: 5px;
	
}
.pfg_label_settings {
	
	background-color: #f6f6f6;
    color: #23282d;
    font-family: icon;
    font-size: 20px;
    font-weight: 500;
    margin-left: 10px;
    padding-left: 10px;
}
.pfg_spacing_md {
	padding-top:2%;
	padding-bottom:1%
}
.pfg_spacing_lg {
	padding-top:10%;
	padding-bottom:10%
}
</style>
<!--filter gallery settings-->
<p class="pfg_settings pfg_border">
	<p class="bg-title">1. Filter Gallery Thumbnail Size</p>
	<?php if(isset($pf_gallery_settings['gal_size'])) $gal_size = $pf_gallery_settings['gal_size']; else $gal_size = "large"; ?>
	<div class="pfg_spacing_md">
		<select id="gal_size" name="gal_size" class="selectbox_settings">
			<option value="thumbnail" <?php if($gal_size == "thumbnail") echo "selected=selected"; ?>>Thumbnail - 150 x 150</option>
			<option value="medium" <?php if($gal_size == "medium") echo "selected=selected"; ?>>Medium - 300 x 169</option>
			<option value="large" <?php if($gal_size == "large") echo "selected=selected"; ?>>Large - 840 x 473</option>
			<option value="full" <?php if($gal_size == "full") echo "selected=selected"; ?>>Full Size - 1280 x 720</option>
		</select><br><br>
		<p class="pfg_cmnt_setting"><?php _e('Select filter gallery thumbnails size to display into filter gallery', PFG_TXTDM); ?></p>
	</div>
</p>

<p class="pfg_settings pfg_border">
	
	<p class="bg-title">2. Columns Settings</p>
	<div class="pfg_spacing_md">
		<p class="bg-lower-title">Columns On Large Desktops</p>
		<?php if(isset($pf_gallery_settings['col_large_desktops'])) $col_large_desktops = $pf_gallery_settings['col_large_desktops']; else $col_large_desktops = "col-lg-4"; ?>
		<select id="col_large_desktops" name="col_large_desktops" class="selectbox_settings">
			<option value="col-lg-6" <?php if($col_large_desktops == "col-lg-6") echo "selected=selected"; ?>>2 Column</option>
			<option value="col-lg-4" <?php if($col_large_desktops == "col-lg-4") echo "selected=selected"; ?>>3 Column</option>
		</select><br><br>
		<p class="pfg_cmnt_setting"><?php _e('Select filter gallery column layout for large desktop devices', PFG_TXTDM); ?></p>

		<p class="bg-lower-title">Columns On Desktops</p>
		<?php if(isset($pf_gallery_settings['col_desktops'])) $col_desktops = $pf_gallery_settings['col_desktops']; else $col_desktops = "col-md-4"; ?>
		<select id="col_desktops" name="col_desktops" class="selectbox_settings">
			<option value="col-md-6" <?php if($col_desktops == "col-md-6") echo "selected=selected"; ?>>2 Column</option>
			<option value="col-md-4" <?php if($col_desktops == "col-md-4") echo "selected=selected"; ?>>3 Column</option>
		</select><br><br>
		<p class="pfg_cmnt_setting"><?php _e('Select filter gallery column layout for desktop devices', PFG_TXTDM); ?></p>



		<p class="bg-lower-title">Columns On Tablets</p>
		<?php if(isset($pf_gallery_settings['col_tablets'])) $col_tablets = $pf_gallery_settings['col_tablets']; else $col_tablets = "col-sm-4"; ?>
		<select id="col_tablets" name="col_tablets" class="selectbox_settings">
			<option value="col-sm-6" <?php if($col_tablets == "col-sm-12") echo "selected=selected"; ?>>2 Column</option>
			<option value="col-sm-4" <?php if($col_tablets == "col-sm-4") echo "selected=selected"; ?>>3 Column</option>
		</select><br><br>
		<p class="pfg_cmnt_setting"><?php _e('Select filter gallery column layout for tablet devices', PFG_TXTDM); ?></p>

		<p class="bg-lower-title">Columns On Phones</p>
		<?php if(isset($pf_gallery_settings['col_phones'])) $col_phones = $pf_gallery_settings['col_phones']; else $col_phones = "col-xs-6"; ?>
		<select id="col_phones" name="col_phones" class="selectbox_settings">
			<option value="col-xs-6" <?php if($col_phones == "col-xs-6") echo "selected=selected"; ?>>2 Column</option>
			<option value="col-xs-4" <?php if($col_phones == "col-xs-4") echo "selected=selected"; ?>>3 Column</option>
		</select><br><br>
		<p class="pfg_cmnt_setting"><?php _e('Select filter gallery column layout for phone devices', PFG_TXTDM); ?></p>
	</div>
</p>
<div class="pfg_border">
	<p class="bg-title"><?php _e('3. Image Hover Effect Type', PFG_TXTDM); ?></p>
	<div class="pfg_spacing_md">
		<p class="pfg_settings">
			<p class="switch-field em_size_field">
				<?php if(isset($pf_gallery_settings['image_hover_effect_type'])) $image_hover_effect_type = $pf_gallery_settings['image_hover_effect_type']; else $image_hover_effect_type = "sg"; ?>
				<input type="radio" name="image_hover_effect_type" id="image_hover_effect_type1" value="no" <?php if($image_hover_effect_type == "no") echo "checked=checked"; ?>>
				<label for="image_hover_effect_type1"><?php _e('None', PFG_TXTDM); ?></label>
				<input type="radio" name="image_hover_effect_type" id="image_hover_effect_type2" value="sg" <?php if($image_hover_effect_type == "sg") echo "checked=checked"; ?>>
				<label for="image_hover_effect_type2"><?php _e('Shadow & Glow', PFG_TXTDM); ?></label>
				<p class="pfg_cmnt_setting"><?php _e('Select a image hover effect type', PFG_TXTDM); ?></p>
			</p>
		</p>
		<p class="he_four pfg_settings">
			<p class="he_four pfg_label_settings"><?php _e('Image Hover Effects', PFG_TXTDM); ?></p><br>
			<?php if(isset($pf_gallery_settings['image_hover_effect_four'])) $image_hover_effect_four = $pf_gallery_settings['image_hover_effect_four']; else $image_hover_effect_four = "hvr-box-shadow-outset"; ?>
			<select name="image_hover_effect_four" id="image_hover_effect_four" class="selectbox_settings he_four">
				<optgroup label="Shadow and Glow Transitions Effects" class="sg">
					<option value="hvr-grow-shadow" <?php if($image_hover_effect_four == "hvr-grow-shadow") echo "selected=selected"; ?>>Grow Shadow</option>
					<option value="hvr-float-shadow" <?php if($image_hover_effect_four == "hvr-float-shadow") echo "selected=selected"; ?>>Float Shadow</option>
					<option value="hvr-glow" <?php if($image_hover_effect_four == "hvr-glow") echo "selected=selected"; ?>>Glow</option>
					<!--<option value="hvr-shadow-radial" <?php //if($image_hover_effect_four == "hvr-shadow-radial") echo "selected=selected"; ?>>Shadow Radial</option>-->
					<option value="hvr-box-shadow-outset" <?php if($image_hover_effect_four == "hvr-box-shadow-outset") echo "selected=selected"; ?>>Box Shadow Outset</option>
					<option value="hvr-box-shadow-inset" <?php if($image_hover_effect_four == "hvr-box-shadow-inset") echo "selected=selected"; ?>>Box Shadow Inset</option>
				</optgroup>
			</select><br><br>
			<p class="he_four pfg_cmnt_setting"><?php _e('Set an image hover effect on gallery', PFG_TXTDM); ?></p>
		</p>
	</div>
</div>

<p class="pfg_settings pfg_border">
	<p class="bg-title"><?php _e('4. Light Box Style', PFG_TXTDM); ?></p>
	<div class="pfg_spacing_md">
		<?php if(isset($pf_gallery_settings['light-box'])) $light_box = $pf_gallery_settings['light-box']; else $light_box = 5; ?>
		<select name="light-box" id="light-box" class="selectbox_settings">	
			<option value="0" <?php if($light_box == 0) echo "selected=selected"; ?>>None</option>
			<option value="5" <?php if($light_box == 5) echo "selected=selected"; ?>>Bootstrap 3 Light Box</option>
		</select><br><br>
		<p class="pfg_cmnt_setting"><?php _e('Select a light box style', PFG_TXTDM); ?></p>
	</div>
</p>

<div class="pfg_border">
	<p class="pfg_settings">
		<p class="bg-title"><?php _e('5. Filter Background Color', PFG_TXTDM); ?></p>
		<div class="pfg_spacing_md">
			<p class="switch-field em_size_field">
				<?php if(isset($pf_gallery_settings['filter_bg'])) $filter_bg = $pf_gallery_settings['filter_bg']; else $filter_bg = "red"; ?>
					<input type="radio" name="filter_bg" id="filter_bg1" value="white" <?php if($filter_bg == 'white') echo "checked=checked"; ?>>
					<label for="filter_bg1"><?php _e('White', PFG_TXTDM); ?></label>
					<input type="radio" name="filter_bg" id="filter_bg2" value="red" <?php if($filter_bg == 'red') echo "checked=checked"; ?>>
					<label for="filter_bg2"><?php _e('Red', PFG_TXTDM); ?></label>
					<input type="radio" name="filter_bg" id="filter_bg3" value="green" <?php if($filter_bg == 'green') echo "checked=checked"; ?>>
					<label for="filter_bg3"><?php _e('Green', PFG_TXTDM); ?></label>
					<input type="radio" name="filter_bg" id="filter_bg4" value="blue" <?php if($filter_bg == 'blue') echo "checked=checked"; ?>>
					<label for="filter_bg4"><?php _e('Blue', PFG_TXTDM); ?></label>
				<p class="pfg_cmnt_setting"><?php _e('Chose a color for filter background', PFG_TXTDM); ?></p>
			</p>
		</div>
	</p>
</div>

<p class="pfg_settings pfg_border">
	<p class="bg-title"><?php _e('6. Image Gray Scale (Gray Effect)', PFG_TXTDM); ?></p>
	<div class="pfg_spacing_md">
		<p class="switch-field em_size_field">
			<?php if(isset($pf_gallery_settings['gray_scale'])) $gray_scale = $pf_gallery_settings['gray_scale']; else $gray_scale = 0; ?>
			<input type="radio" name="gray_scale" id="gray_scale1" value="1" <?php if($gray_scale == 1) echo "checked=checked"; ?>>
			<label for="gray_scale1"><?php _e('Yes', PFG_TXTDM); ?></label>
			<input type="radio" name="gray_scale" id="gray_scale2" value="0" <?php if($gray_scale == 0) echo "checked=checked"; ?>>
			<label for="gray_scale2"><?php _e('No', PFG_TXTDM); ?></label>
			<p class="pfg_cmnt_setting"><?php _e('Select gray scale on images', PFG_TXTDM); ?></p>
		</p>
	</div>
</p>

<div class="pfg_border">
	<p class="pfg_settings">
		<p class="bg-title"><?php _e('7. Title On Thumbnail', PFG_TXTDM); ?></p>
		<div class="pfg_spacing_md">
			<p class="switch-field em_size_field">
				<?php if(isset($pf_gallery_settings['title_thumb'])) $title_thumb = $pf_gallery_settings['title_thumb']; else $title_thumb = "show"; ?>
				<input type="radio" name="title_thumb" id="title_thumb1" value="show" <?php if($title_thumb == "show") echo "checked=checked"; ?>>
				<label for="title_thumb1"><?php _e('Show', PFG_TXTDM); ?></label>
				<input type="radio" name="title_thumb" id="title_thumb2" value="hide" <?php if($title_thumb == "hide") echo "checked=checked"; ?>>
				<label for="title_thumb2"><?php _e('Hide', PFG_TXTDM); ?></label>
				<p class="pfg_cmnt_setting"><?php _e('Show or hide title on your thumbnails', PFG_TXTDM); ?></p>
			</p>
		</div>
	</p>
</div>
	
<p class="pfg_settings pfg_border">
	<p class="bg-title"><?php _e('9. Show Numbering On Thumbnails', PFG_TXTDM); ?></p>
	<div class="pfg_spacing_md">
		<p class="switch-field em_size_field">
			<?php if(isset($pf_gallery_settings['image_numbering'])) $image_numbering = $pf_gallery_settings['image_numbering']; else $image_numbering = "1"; ?>
			<input type="radio" name="image_numbering" id="image_numbering1" value="1" <?php if($image_numbering == 1) echo "checked=checked"; ?>>
			<label for="image_numbering1"><?php _e('Yes', PFG_TXTDM); ?></label>
			<input type="radio" name="image_numbering" id="image_numbering2" value="0" <?php if($image_numbering == 0) echo "checked=checked"; ?>>
			<label for="image_numbering2"><?php _e('No', PFG_TXTDM); ?></label>
			<p class="pfg_cmnt_setting"><?php _e('Show numbering on thumbnails', PFG_TXTDM); ?></p>
		</p>
	</div>
</p>

<p class="pfg_settings pfg_border">
	<p class="bg-title"><?php _e('10. Hide Thumbnails Spacing', PFG_TXTDM); ?></p>
	<div class="pfg_spacing_md">
		<p class="switch-field em_size_field">
			<?php if(isset($pf_gallery_settings['no_spacing'])) $no_spacing = $pf_gallery_settings['no_spacing']; else $no_spacing = 0; ?>
			<input type="radio" name="no_spacing" id="no_spacing1" value="1" <?php if($no_spacing == 1) echo "checked=checked"; ?>>
			<label for="no_spacing1"><?php _e('Yes', PFG_TXTDM); ?></label>
			<input type="radio" name="no_spacing" id="no_spacing2" value="0" <?php if($no_spacing == 0) echo "checked=checked"; ?>>
			<label for="no_spacing2"><?php _e('No', PFG_TXTDM); ?></label>
			<p class="pfg_cmnt_setting"><?php _e('Hide gap / margin / padding / spacing between gallery thumbnails', PFG_TXTDM); ?></p>
		</p>
	</div>
</p>


<p class="pfg_settings pfg_border">
	<p class="bg-title"><?php _e('11. Open Image Link URL', PFG_TXTDM); ?></p>
	<div class="pfg_spacing_md">
		<p class="switch-field em_size_field">
			<?php if(isset($pf_gallery_settings['url_target'])) $url_target = $pf_gallery_settings['url_target']; else $url_target = "_new"; ?>
			<input type="radio" name="url_target" id="url_target1" value="_new" <?php if($url_target == "_new") echo "checked=checked"; ?>>
			<label for="url_target1"><?php _e('Into New Tab', PFG_TXTDM); ?></label>
			<input type="radio" name="url_target" id="url_target2" value="_self" <?php if($url_target == "_self") echo "checked=checked"; ?>>
			<label for="url_target2"><?php _e('Into Same Tab', PFG_TXTDM); ?></label>
			<p class="pfg_cmnt_setting"><?php _e('Set a image URL opening target', PFG_TXTDM); ?></p>
		</p>
	</div>
</p>

<!-- custom css -->
<p class="pfg_settings gg_border">
	<p class="bg-title"><?php _e('12. Custom CSS', PFG_TXTDM); ?></p>
	<div class="pfg_spacing_md">
		<?php if(isset($pf_gallery_settings['custom-css'])) $custom_css = $pf_gallery_settings['custom-css']; else $custom_css = ""; ?>
		<textarea name="custom-css" id="custom-css" style="width: 100%; height: 120px;" placeholder="Type direct CSS code here. Don't use <style>...</style> tag."><?php echo $custom_css; ?></textarea><br>
		<br>
		<p class="pfg_cmnt_setting"><?php _e('Apply own css on image gallery and dont use style tag', PFG_TXTDM); ?></p>
	</div>
</p>

<?php 
	// syntax: wp_nonce_field( 'name_of_my_action', 'name_of_nonce_field' );
	wp_nonce_field( 'pfg_save_settings', 'pfg_save_nonce' );
?>

<script>
	// title size range settings.  on change range value
	function updateRange(val, id) {
		jQuery("#" + id).val(val);
		jQuery("#" + id + "_text").val(val);	  
	}
	
		
	//color-picker
	(function( jQuery ) {
		jQuery(function() {
			// Add Color Picker to all inputs that have 'color-field' class
			jQuery('#title_color').wpColorPicker();
			jQuery('#title_bg_color').wpColorPicker();
			jQuery('#border_color').wpColorPicker();
			jQuery('#filter_bg_color').wpColorPicker();
			jQuery('#filter_title_color').wpColorPicker();
			jQuery('#sorting_control_color').wpColorPicker();
			jQuery('#shuffle_bg').wpColorPicker();
			
		});
	})( jQuery );
	
	jQuery(document).ajaxComplete(function() {
		jQuery('#title_color,#title_bg_color,#border_color,#filter_bg_color,#filter_title_color,#sorting_control_color,#shuffle_bg').wpColorPicker();
	});	
	var effect_type = jQuery('input[name="image_hover_effect_type"]:checked').val();
	
	//alert(effect_type);
	if(effect_type == "no") {
		jQuery('.he_one').hide();
		jQuery('.he_four').hide();
		jQuery('.he_ancore').show();
	}
	if(effect_type == "2d") {
		jQuery('.he_one').show();
		jQuery('.he_four').hide();
		jQuery('.he_ancore').hide();
	}
	if(effect_type == "sg") {
		jQuery('.he_one').hide();
		jQuery('.he_ancore').hide();
		jQuery('.he_four').show();
	}
	var border_setting = jQuery('input[name="border_hide"]:checked').val();
	if(border_setting == 1){
		jQuery('#border_settings').show();
		jQuery('.border_ancore').hide();
	}
	if(border_setting == 0){
		jQuery('#border_settings').hide();
		jQuery('.border_ancore').show();
	}

	var title_thumbnail = jQuery('input[name="title_thumb"]:checked').val();
	if(title_thumbnail == "show"){
		jQuery('.title_set').show();
		jQuery('.title_ancore').hide();
	}
	if(title_thumbnail == "hide"){
		jQuery('.title_set').hide();
		jQuery('.title_ancore').show();
	}
	
	var filter_setting = jQuery('input[name="filter_setting"]:checked').val();
	if(filter_setting == "open"){
		jQuery('.filter_set').show();
		jQuery('.filt_ancore').hide();
	}
	if(filter_setting == "close"){
		jQuery('.filter_set').hide();
		jQuery('.filt_ancore').show();
	}
	
	var sort_control = jQuery('input[name="sort_control"]:checked').val();
	if(sort_control == "open"){
		jQuery('.sort_set').show();
		jQuery('.sort_ancore').hide();
	}
	if(sort_control == "close"){
		jQuery('.sort_set').hide();
		jQuery('.sort_ancore').show();
	}

	//on change effect
	jQuery(document).ready(function() {
		jQuery('input[name="image_hover_effect_type"]').change(function(){
			var effect_type = jQuery('input[name="image_hover_effect_type"]:checked').val();
			
			//alert(effect_type);
			if(effect_type == "no") {
				jQuery('.he_one').hide();
				jQuery('.he_four').hide();
				jQuery('.he_ancore').show();
			}
			if(effect_type == "2d") {
				jQuery('.he_one').show();
				jQuery('.he_four').hide();
				jQuery('.he_ancore').hide();
			}
			if(effect_type == "sg") {
				jQuery('.he_one').hide();
				jQuery('.he_ancore').hide();
				jQuery('.he_four').show();
			}
			
		});
		jQuery('input[name="border_hide"]').change(function(){
			var border_setting = jQuery('input[name="border_hide"]:checked').val();
			if(border_setting == 1){
				jQuery('#border_settings').show();
				jQuery('.border_ancore').hide();
			}
			if(border_setting == 0){
				jQuery('#border_settings').hide();
				jQuery('.border_ancore').show();
			}
		});
		jQuery('input[name="title_thumb"]').change(function(){
			var title_thumbnail = jQuery('input[name="title_thumb"]:checked').val();
			if(title_thumbnail == "show"){
				jQuery('.title_set').show();
				jQuery('.title_ancore').hide();
			}
			if(title_thumbnail == "hide"){
				jQuery('.title_set').hide();
				jQuery('.title_ancore').show();
			}
		});
		
		jQuery('input[name="filter_setting"]').change(function(){
			var filter_setting = jQuery('input[name="filter_setting"]:checked').val();
			if(filter_setting == "open"){
				jQuery('.filter_set').show();
				jQuery('.filt_ancore').hide();
			}
			if(filter_setting == "close"){
				jQuery('.filter_set').hide();
				jQuery('.filt_ancore').show();
			}
	
		});
		
		jQuery('input[name="sort_control"]').change(function(){
			var sort_control = jQuery('input[name="sort_control"]:checked').val();
			if(sort_control == "open"){
				jQuery('.sort_set').show();
				jQuery('.sort_ancore').hide();
			}
			if(sort_control == "close"){
				jQuery('.sort_set').hide();
				jQuery('.sort_ancore').show();
			}
		});
	});
	// start pulse on page load
	function pulseEff() {
	   jQuery('#shortcode').fadeOut(600).fadeIn(600);
	};
	var Interval;
	Interval = setInterval(pulseEff,1500);

	// stop pulse
	function pulseOff() {
		clearInterval(Interval);
	}
	// start pulse
	function pulseStart() {
		Interval = setInterval(pulseEff,1500);
	}
</script>
	<p class="text-center">
		<br>
		<a href="http://awplife.com/account/signup/portfolio-filter-gallery" target="_blank" class="button button-primary button-hero load-customize hide-if-no-customize">Buy Premium Version</a>
		<a href="http://demo.awplife.com/portfolio-filter-gallery-premium/" target="_blank" class="button button-primary button-hero load-customize hide-if-no-customize">Check Live Demo</a>
		<a href="http://demo.awplife.com/portfolio-filter-gallery-premium-admin-demo" target="_blank" class="button button-primary button-hero load-customize hide-if-no-customize">Try Admin Demo</a>
	</p>	
	<hr>
	<style>
		.awp_bale_offer {
			background-image: url("<?php echo PFG_PLUGIN_URL ?>/img/awp-bale.jpg");
			background-repeat:no-repeat;
			padding:30px;
		}
		.awp_bale_offer h1 {
			font-size:35px;
			color:#006B9F;
		}
		.awp_bale_offer h3 {
			font-size:25px;
			color:#000000;
		}
	</style>
	<div class="row awp_bale_offer">
		<div class="">
			<h1>Plugin's Bale Offer</h1>
			<h3>Get All Premium Plugin ( Personal Licence) in just $99 </h3>
			<h3><strike>$149</strike> For $99 Only</h3>
		</div>
		<div class="">
			<a href="http://awplife.com/account/signup/all-premium-plugins" target="_blank" class="button button-primary button-hero load-customize hide-if-no-customize">BUY NOW</a>
		</div>
	</div>
<hr>
<p class="">
	<h1><strong>Try Our Other Free Plugins:</strong></h1>
	<br>
	<a href="https://wordpress.org/plugins/new-grid-gallery/" target="_blank" class="button button-primary load-customize hide-if-no-customize">Grid Gallery</a>
	<a href="https://wordpress.org/plugins/new-social-media-widget/" target="_blank" class="button button-primary load-customize hide-if-no-customize">Social Media</a>
	<a href="https://wordpress.org/plugins/new-image-gallery/" target="_blank" class="button button-primary load-customize hide-if-no-customize">Image Gallery</a>
	<a href="https://wordpress.org/plugins/new-photo-gallery/" target="_blank" class="button button-primary load-customize hide-if-no-customize">Photo Gallery</a>
	<a href="https://wordpress.org/plugins/responsive-slider-gallery/" target="_blank" class="button button-primary load-customize hide-if-no-customize">Responsive Slider Gallery</a>
	<a href="https://wordpress.org/plugins/new-contact-form-widget/" target="_blank" class="button button-primary load-customize hide-if-no-customize">Contact Form Widget</a>
	<a href="https://wordpress.org/plugins/facebook-likebox-widget-and-shortcode/" target="_blank" class="button button-primary load-customize hide-if-no-customize">Facebook Likebox Plugin</a>
	<a href="https://wordpress.org/plugins/slider-responsive-slideshow/" target="_blank" class="button button-primary load-customize hide-if-no-customize">Slider Responsive Slideshow</a>
	<a href="https://wordpress.org/plugins/new-video-gallery/" target="_blank" class="button button-primary load-customize hide-if-no-customize">Video Gallery</a><br><br>
	<a href="https://wordpress.org/plugins/new-facebook-like-share-follow-button/" target="_blank" class="button button-primary load-customize hide-if-no-customize">Facebook Like Share Follow Button</a>
	<a href="https://wordpress.org/plugins/new-google-plus-badge/" target="_blank" class="button button-primary load-customize hide-if-no-customize">Google Plus Badge</a>
	<a href="https://wordpress.org/plugins/media-slider/" target="_blank" class="button button-primary load-customize hide-if-no-customize">Media Slider</a>
	<a href="https://wordpress.org/plugins/weather-effect/" target="_blank" class="button button-primary load-customize hide-if-no-customize">Weather Effect</a>
</p>
