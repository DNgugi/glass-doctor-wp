<?php
/**
 * Glass Doctor functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Glass_Doctor
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'gdoc_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function gdoc_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Glass Doctor, use a find and replace
		 * to change 'gdoc' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'gdoc', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'gdoc' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'gdoc_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'gdoc_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function gdoc_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'gdoc_content_width', 640 );
}
add_action( 'after_setup_theme', 'gdoc_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function gdoc_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'gdoc' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'gdoc' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'gdoc_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function gdoc_scripts() {
	wp_enqueue_style( "g-fonts", 'https://fonts.googleapis.com/css2?family=Josefin+Sans&family=Yeseva+One&display=swap');
	wp_enqueue_style( "g-font", 'https://fonts.googleapis.com/css2?family=Montserrat&display=swap');
	wp_enqueue_style( "material-icons", 'https://fonts.googleapis.com/icon?family=Material+Icons');
	wp_enqueue_style( 'materialize', get_template_directory_uri( ) . '/css/materialize.min.css');
	wp_enqueue_style( 'custom-css', get_template_directory_uri( ) . '/css/dist/style.css');
	wp_enqueue_style( 'gdoc-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'gdoc-style', 'rtl', 'replace' );

	wp_enqueue_script( 'gdoc-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'materialize-js', get_template_directory_uri() . '/js/materialize.min.js', array('jquery'), _S_VERSION, true);
	wp_enqueue_script( 'gdoc-js', get_template_directory_uri() . '/js/init.js', array('jquery'), _S_VERSION, true );


	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'gdoc_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}
add_filter( 'woocommerce_checkout_fields', 'gdoc_remove_fields', 9999 );

function gdoc_remove_fields( $woo_checkout_fields_array ) {
 
	// she wanted me to leave these fields in checkout
	// unset( $woo_checkout_fields_array['billing']['billing_first_name'] );
	// unset( $woo_checkout_fields_array['billing']['billing_last_name'] );
	// unset( $woo_checkout_fields_array['billing']['billing_phone'] );
	// unset( $woo_checkout_fields_array['billing']['billing_email'] );
	// unset( $woo_checkout_fields_array['order']['order_comments'] ); // remove order notes
 
	// and to remove the billing fields below
	unset( $woo_checkout_fields_array['billing']['billing_phone'] );
	unset( $woo_checkout_fields_array['billing']['billing_company'] ); // remove company field
	unset( $woo_checkout_fields_array['billing']['billing_country'] );
	unset( $woo_checkout_fields_array['billing']['billing_address_1'] );
	unset( $woo_checkout_fields_array['billing']['billing_address_2'] );
	unset( $woo_checkout_fields_array['billing']['billing_city'] );
	unset( $woo_checkout_fields_array['billing']['billing_state'] ); // remove state field
	unset( $woo_checkout_fields_array['billing']['billing_postcode'] ); // remove zip code field
 
	return $woo_checkout_fields_array;
}