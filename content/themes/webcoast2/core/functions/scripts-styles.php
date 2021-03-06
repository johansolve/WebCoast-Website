<?php
/**
 * Header Functions
 *
 * Contains functions that hook into wp_head and/or output their content
 * to wp_head via other actions/hooks such as scripts and stylesheets.
 *
 * @since WebCoast 1.0
 * @author XLD Studios
 * @version 1.0
 * @package WebCoast
 **/

/**
 * Stylesheets
 *
 * Registeres and enqueues theme stylesheets.
 *
 * @since 1.0
 **/
function webcoast_enqueue_styles() {

	// Register
	// wp_register_style( $handle, $src, $deps, $ver, $media );
	wp_register_style( 'base', THEME_CSS_URI . '/layout.css', array( 'webfont-open-sans' ), THEME_VERSION, 'all' );
	wp_register_style( 'webfont-open-sans', '//fonts.googleapis.com/css?family=Open+Sans:400italic,400,700', false, false, 'all' );
	wp_register_style( 'webfont-sintony', '//fonts.googleapis.com/css?family=Sintony:400,700', false, false, 'all' );

	// Enqueue
	wp_enqueue_style( 'webfont-open-sans' );
	wp_enqueue_style( 'webfont-sintony' );
	wp_enqueue_style( 'base' );

	// If we have a custom.css stylesheet, include that too. This makes it easier for
	// clients to modify the CSS quickly without having to know and use SASS.
	if( file_exists( THEME_CSS_URI . '/custom.css' ) ) {
		wp_register_style( 'custom', THEME_CSS_URI . '/custom.css', false, THEME_VERSION, 'all' );

		wp_enqueue_style( 'custom' );
	}

}

// Register Styles with WordPress
add_action( 'wp_enqueue_scripts', 'webcoast_enqueue_styles' );

/**
 * Enqueue Scripts on public side
 *
 * @since WebCoast 1.0
 **/
function webcoast_enqueue_scripts() {

	// Register
	// wp_register_script( $handle, $src, $deps, $ver, $in_footer );
	wp_register_script( 'modernizr', THEME_JS_URI . '/vendor/custom.modernizr.js', false, '2.6.2', false );
	wp_register_script( 'scripts', THEME_JS_URI . '/main.min.js', array( 'jquery', 'packery', 'imagesloaded' ), THEME_VERSION, true );
	wp_register_script( 'imagesloaded', THEME_JS_URI . '/vendor/imagesloaded.pkgd.min.js', array( 'jquery' ), '3.1.8', true );
	wp_register_script( 'packery', THEME_JS_URI . '/vendor/packery.pkgd.min.js', array( 'jquery', 'imagesloaded' ), '1.3.0', true );
	wp_register_script( 'foundation', THEME_JS_URI . '/foundation/foundation.js', array( 'jquery' ), THEME_VERSION, true );
	wp_register_script( 'foundation-magellan', THEME_JS_URI . '/foundation/foundation.magellan.js', array( 'jquery', 'foundation' ), THEME_VERSION, true );


	// Enqueue
	wp_enqueue_script( 'modernizr' );
	wp_enqueue_script( 'foundation' );
	wp_enqueue_script( 'foundation-magellan' );
	wp_enqueue_script( 'scripts' );
	wp_enqueue_script( 'imagesloaded' );
	wp_enqueue_script( 'packery' );

	$translation_array = array(
		'ajax_url' => admin_url( 'admin-ajax.php' ),
		'nonce'    => wp_create_nonce( 'webcoast-ajax-nonce' )
	);

	wp_localize_script( 'scripts', 'webcoast_scripts', $translation_array );

	if ( is_singular() )
		wp_enqueue_script( 'comment-reply' );

}

// Register Scripts with WordPress
add_action('wp_enqueue_scripts', 'webcoast_enqueue_scripts');

/**
 * Adds a favicon to the site
 *
 * Will load any favicon that is added into the
 * theme image directory.
 *
 * @since WebCoast 1.0
 **/
function webcoast_favicon() {

	echo '<link rel="Shortcut Icon" type="image/x-icon" href="' . THEME_IMAGES_URI . '/favicon.ico">';

}

add_action('wp_head', 'webcoast_favicon'); // Adds the favicon to frontend
add_action('admin_head', 'webcoast_favicon'); // Adds the favicon to backend

if ( ! function_exists( 'webcoast_remarketing' ) ) :

	/**
	 * WebCoast Remarketing Tags
	 */
	function webcoast_remarketing() {

		ob_start(); ?>

			<!-- Googles kod för remarketing-taggen -->
			<!--------------------------------------------------
			Remarketing-taggar får inte vara kopplade till personligt identifierande information eller placeras på sidor relaterade till känsliga kategorier. Läs mer information och anvisningar om hur du ställer in taggen på: http://google.com/ads/remarketingsetup
			--------------------------------------------------->
			<script type="text/javascript">
			/* <![CDATA[ */
			var google_conversion_id = 954419884;
			var google_custom_params = window.google_tag_params;
			var google_remarketing_only = true;
			/* ]]> */
			</script>
			<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
			</script>
			<noscript>
			<div style="display:inline;">
			<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/954419884/?value=0&amp;guid=ON&amp;script=0"/>
			</div>
			</noscript>

		<?php
		$output = ob_get_clean();

		echo $output;

	}

	add_action( 'wp_footer', 'webcoast_remarketing' );

endif;