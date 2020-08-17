<?php
/*
 Template Name: single-eko-video
 Template Post Type: eko-video
 */

get_header(); ?>
<div class="entry-content" id='entry-head'>
	<div id='video-container' style="position:relative;height:100%"></div>
	<?php
	echo eko_embed_current_video( array(), 'video-container');
	?>
	<div class="video__content">
		<div class="video__info">
			<?php
			if ( eko_get_field( 'thumbnail' ) ) :
				;
				?>
				<div class="bgSideImage">
					<img src="<?php echo eko_get_field( 'thumbnail' ); ?>" />
					<div class="gradientOverImage" style="background-image: linear-gradient(to right, #00112B 0%, transparent 100%)"></div>
				</div>
			<?php endif; ?>
			<?php
			if ( eko_get_field( 'title' ) ) :
				;
				?>
				<h1 class="video__title"><?php echo eko_get_field( 'title' ); ?></h1><?php endif; ?>
			<?php
			if ( eko_get_field( 'duration' ) ) :
				;
				?>
				<div class="video__watchTime">
					<div class="clockIcon">
						<svg x="0px" y="0px" viewBox="0 0 16 16">
							<path d="M8,15.6c-4.2,0-7.6-3.4-7.6-7.6S3.8,0.4,8,0.4s7.6,3.4,7.6,7.6S12.2,15.6,8,15.6L8,15.6z M8,1.2c-3.7,0-6.8,3-6.8,6.8s3,6.8,6.8,6.8s6.8-3,6.8-6.8S11.7,1.2,8,1.2L8,1.2z"/>
							<polyline points="10.4,11.9 7.6,9.1 7.6,4 8.4,4 8.4,8.7 11,11.3 10.4,11.9 "/>
						</svg>
					</div>
					<div class="watchTime">About <?php echo eko_duration_in_minutes( eko_get_field( 'duration' ) ); ?> minutes</div>
				</div>
			<?php endif; ?>
			<?php
			if ( eko_get_field( 'description' ) ) :
				;
				?>
				<p class="video__desc"><?php echo eko_get_field( 'description' ); ?></p><?php endif; ?>
		</div>
	</div>
</div>
</script>
<?php wp_reset_query(); ?>
<?php get_footer(); ?>
