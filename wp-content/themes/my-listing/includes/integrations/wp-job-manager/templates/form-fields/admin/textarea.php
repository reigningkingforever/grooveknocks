<?php
global $thepostid;

if ( ! isset( $field['value'] ) ) {
	$field['value'] = get_post_meta( $thepostid, $key, true );
}
if ( ! empty( $field['name'] ) ) {
	$name = $field['name'];
} else {
	$name = $key;
}

// Set the description field ID to '#content' so that it's
// recognizable by plugins like Yoast SEO.
$editor_id = ( $key === '_job_description' ) ? 'content' : $key;

?>

<?php if ( $name === '_job_description' ): ?>
	<div class="form-field"></div>
<?php endif; ?>

<div class="form-field <?php echo esc_attr( "form-field-{$name}" ) ?>">
	<label for="<?php echo esc_attr( $key ); ?>"><?php echo wp_strip_all_tags( $field['label'] ) ; ?>: <?php if ( ! empty( $field['description'] ) ) : ?><span class="tips" data-tip="<?php echo esc_attr( $field['description'] ); ?>">[?]</span><?php endif; ?></label>
	<textarea name="<?php echo esc_attr( $name ); ?>" id="<?php echo esc_attr( $editor_id ); ?>" placeholder="<?php echo esc_attr( $field['placeholder'] ); ?>"><?php echo esc_html( $field['value'] ); ?></textarea>
</div>