<?php

/**
 * eko_the_field
 *
 * Echo a specific field to the screen.
 * If $post_id not supplied, get from current $post
 *
 * @param  mixed $field_name
 * @param  mixed $post_id
 * @return null
 */
function eko_the_field( $field_name, $post_id = false ) {
	$field_name = 'eko_' . $field_name;
	$post_id   = eko_get_the_post_id( $post_id );
	$post_meta = get_post_meta( $post_id, $field_name, true );
	echo isset( $post_meta ) ? $post_meta : null;

}

/**
 * eko_get_field
 *
 * Get a specific field.
 * If $post_id not supplied, get from current $post
 *
 * @param  mixed $field_name
 * @param  mixed $post_id
 * @return mixed
 */
function eko_get_field( $field_name, $post_id = false ) {
	$field_name = 'eko_' . $field_name;
	$post_id   = eko_get_the_post_id( $post_id );
	$post_meta = get_post_meta( $post_id, $field_name, true );
	return isset( $post_meta ) ? $post_meta : null;

}
/**
 * eko_get_fields
 *
 * Get list of fields
 * If $post_id not supplied, get from current $post
 *
 * @param  mixed $fields
 * @param  mixed $post_id
 * @return array
 */
function eko_get_fields( array $fields, $post_id = false ) {
	$all_meta = get_all_fields_formatted( $post_id );
	return array_intersect_key( $all_meta, array_flip( $fields ) );
}
/**
 * eko_get_field_object
 *
 * Get a specific field as an object
 * If $post_id not supplied, get from current $post
 *
 * @param  mixed $field_name
 * @param  mixed $post_id
 * @return array $post_meta
 */
function eko_get_field_object( $field_name, $post_id = false ) {
	$field_name = 'eko_' . $field_name;
	$post_id   = eko_get_the_post_id( $post_id );
	$post_meta = get_post_meta( $post_id, $field_name );
	return isset( $post_meta ) ? $post_meta : null;
}
/**
 * eko_get_all_fields_formatted
 *
 * Get all the fields of a post where each keys value is the first element
 * If $post_id not supplied, get from current $post
 *
 * @param  mixed $post_id
 * @return array mixed
 */
function eko_get_all_fields_formatted( $post_id = false ) {
	$post_id   = eko_get_the_post_id( $post_id );
	$post_meta = get_post_meta( $post_id );
	return array_map( 'eko_get_actual_field', $post_meta );
}


