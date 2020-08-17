<?php
/**
 * eko_add_metabox_to_video
 *
 * @return void
 */
function eko_add_metabox_to_video() {
	add_meta_box(
		'ekoMetabox',
		'Eko',
		'eko_metabox_content',
		'eko-video',
		'normal',
		'high'
	);
}
/**
 * eko_duration_in_minutes
 *
 * convert seconds to minutes
 *
 * @param  mixed $eko_duration
 * @return string
 */
function eko_duration_in_minutes( $eko_duration ) {
	if ( is_numeric( $eko_duration ) ) {
		return floor( $eko_duration / 60 );
	}
	return 'Nan';
}
function eko_create_duration_div( $eko_duration ) {
	$duration_string = ( $eko_duration ? 'About ' . eko_duration_in_minutes( $eko_duration ) . ' minutes' : '' );
	// create the duration div with clock svg
	$output  = '<div class="video__watchTime">';
	$output .= '<div class="clockIcon hidden">';
	$output .= '<svg x="0px" y="0px" viewBox="0 0 16 16">';
	$output .= '<path d="M8,15.6c-4.2,0-7.6-3.4-7.6-7.6S3.8,0.4,8,0.4s7.6,3.4,7.6,7.6S12.2,15.6,8,15.6L8,15.6z M8,1.2c-3.7,0-6.8,3-6.8,6.8s3,6.8,6.8,6.8s6.8-3,6.8-6.8S11.7,1.2,8,1.2L8,1.2z"/>';
	$output .= '<polyline points="10.4,11.9 7.6,9.1 7.6,4 8.4,4 8.4,8.7 11,11.3 10.4,11.9 "/>';
	$output .= '</svg>';
	$output .= '</div>';
	$output .= '<div class="watchTime">' . $duration_string . '</div>';
	$output .= '</div>';
	return $output;
}
function eko_create_thumbnail_div( $eko_thumbnail ) {
	$output  = '<div class="video__image">';
	$output .= '<img id="video__image_img" src="' . $eko_thumbnail . '" />';
	$output .= '</div>';
	return $output;
}
function eko_create_video_info_preview( $eko_title, $eko_description, $eko_thumbnail, $eko_duration ) {
	$ep_desc  = '<p class="video__desc">' . $eko_description . '</p>';
	$ep_title = '<h1 class="video__title">' . $eko_title . '</h1>';
	// create the image div
	$side_image  = eko_create_thumbnail_div( $eko_thumbnail );
	$ep_duration = eko_create_duration_div( $eko_duration );
	// create the output
	$output  = '<div class="video__info">';
	$output .= '<div class="eko-left">';
	$output .= $ep_title;
	$output .= $ep_desc;
	$output .= $ep_duration;
	$output .= '</div><div class="eko-right">';
	$output .= $side_image;
	$output .= '</div></div>';
	return $output;
}

function eko_create_cpt_accordion( $embed_section, $details_list ) {
	$output  = '<div id="eko-accordion" style="display:flex; flex-direction:column;">';
	$output .= $embed_section;
	$output .= $details_list;
	$output .= '</div>';
	return $output;
}

function eko_create_embed_section( $eko_url, $eko_password, $video_info ) {
	$error_hidden  = ( $eko_url ? 'hidden' : '' );
	$iframe_hidden = ( $error_hidden ? '' : 'hidden' );

	$output  = '<h3>Preview<h3>';
	$output .= '<p class="eko-no-url ' . $error_hidden . '">No content yet</p>';
	$output .= '<div id="eko-embed" class="eko-player ' . $iframe_hidden . '" ></div>';
	$output .= $video_info;

	return $output;
}
function eko_add_list_item( $title, $name, $value, $readonly = true ) {
	$readonly_string = $readonly ? 'readonly' : '';
	$output          = '<li class="detail-item">';
	$output         .= '<label>' . $title . ':</label>';
	$output         .= '<input type="text" name="' . $name . '" value="' . esc_attr( $value ) . '"' . $readonly_string . ' >';
	$output         .= '</li>';
	return $output;
}
function eko_create_details_list( $list ) {
	$output  = '<h3>Fields</h3>';
	$output .= '<ul class="details-list ' . $list['hidden'] . '">';
	$output .= '<em> field\'s id for using the developers API in parentheses</em>';
	$output .= eko_add_list_item( 'Title (title)', 'eko_title', $list['title'] );
	$output .= eko_add_list_item( 'Description (description)', 'eko_description', $list['description'] );
	$output .= eko_add_list_item( 'Image (thumbnail)', 'eko_thumbnail', $list['thumbnail'] );
	$output .= eko_add_list_item( 'Canonical URL (canonical_url)', 'eko_canonical_url', $list['url'] );
	$output .= eko_add_list_item( 'Duration (duration)', 'eko_duration', $list['duration'] );
	$output .= eko_add_list_item( 'Kids Content (kids_content)', 'eko_kids_content', $list['kidsContent'] );
	$output .= eko_add_list_item( 'Orientation (orientation)', 'eko_orientation', $list['orientation'] );
	$output .= '</ul>';
	return $output;
}
function eko_create_password_input( $password ) {
	$output  = '<div>';
	$output .= '<ul>';
	$output .= '<p>Password (optional - for password protected eko videos):</p>';
	$output .= '<input id="videoPassword" placeholder="password" name="eko_password" value="' . esc_attr( $password ) . '" />';
	$output .= '</ul>';
	$output .= '</div>';
	return $output;
}
/**
 * eko_metabox_content
 *
 * this function does not retuan a value, but echo it (WordPress demends)
 * this is the function that echo the video content type metabox
 *
 * @param  mixed $post
 * @return void
 */
function eko_metabox_content( $post ) {
	// load all meta data
	$eko_video_id     = get_post_meta( $post->ID, 'eko_video_id', true );
	$eko_title        = get_post_meta( $post->ID, 'eko_title', true );
	$eko_description  = get_post_meta( $post->ID, 'eko_description', true );
	$eko_thumbnail    = get_post_meta( $post->ID, 'eko_thumbnail', true );
	$eko_url          = get_post_meta( $post->ID, 'eko_canonical_url', true );
	$eko_duration     = get_post_meta( $post->ID, 'eko_duration', true );
	$eko_kids_content = get_post_meta( $post->ID, 'eko_kids_content', true );
	$eko_orientation  = get_post_meta( $post->ID, 'eko_orientation', true );
	$eko_password     = get_post_meta( $post->ID, 'eko_password', true );
	// if no id -> hidden
	$hidden      = $eko_video_id ? '' : 'hidden';
	$desc_hidden = $eko_video_id ? 'hidden' : '';
	// create all ui elements
	$video_info         = eko_create_video_info_preview( $eko_title, $eko_description, $eko_thumbnail, $eko_duration );
	$video_details_list = eko_create_details_list(
		array(
			'hidden'      => $hidden,
			'title'       => $eko_title,
			'description' => $eko_description,
			'thumbnail'   => $eko_thumbnail,
			'url'         => $eko_url,
			'duration'    => $eko_duration,
			'kidsContent' => $eko_kids_content,
			'orientation' => $eko_orientation,
		)
	);
	$embed_section      = eko_create_embed_section( $eko_url, $eko_password, $video_info );
	$accordion          = eko_create_cpt_accordion( $embed_section, $video_details_list );
	// start of output
	$output  = '<div class="main-content">';
	$output .= '<div class="eko-metabox-description ' . $desc_hidden . '">';
	$output .= '<p>To get details for an eko video, please enter its Falcon ID.</p>';
	$output .= '</div>';
	$output .= '<div class="field-container">';
	$output .= '<p>Id of the eko Video (video_id):</p>';
	$output .= '<input placeholder="Video ID" name="eko_video_id" id="videoId" value="' . esc_attr( $eko_video_id ) . '" />';
	$output .= '<div class="loader hidden"></div>'; //for the loader
	$output .= '</div>';
	$output .= eko_create_password_input( $eko_password );
	$output .= $accordion;
	$output .= '</div>';
	echo $output;
}

/**
 * eko_save_meta_box
 *
 * @param  mixed $post_id
 * @return void
 */
function eko_save_meta_box( $post_id ) {
	// verify post type and that we have at least an id
	if (
		get_post_type( $post_id ) === 'eko-video'
		&& isset( $_POST['eko_video_id'] )
	) {
		// skip auto saving ????
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		// save meta box data as post meta fields
		update_post_meta( $post_id, 'eko_video_id', sanitize_text_field( $_POST['eko_video_id'] ) );
		update_post_meta( $post_id, 'eko_title', sanitize_text_field( $_POST['eko_title'] ) );
		update_post_meta( $post_id, 'eko_description', sanitize_text_field( $_POST['eko_description'] ) );
		update_post_meta( $post_id, 'eko_thumbnail', sanitize_text_field( $_POST['eko_thumbnail'] ) );
		update_post_meta( $post_id, 'eko_canonical_url', sanitize_text_field( $_POST['eko_canonical_url'] ) );
		update_post_meta( $post_id, 'eko_duration', sanitize_text_field( $_POST['eko_duration'] ) );
		update_post_meta( $post_id, 'eko_kids_content', sanitize_text_field( $_POST['eko_kids_content'] ) );
		update_post_meta( $post_id, 'eko_orientation', sanitize_text_field( $_POST['eko_orientation'] ) );
		update_post_meta( $post_id, 'eko_password', sanitize_text_field( $_POST['eko_password'] ) );
	}
}
