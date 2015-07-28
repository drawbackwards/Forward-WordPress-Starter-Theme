<?php
/**
 * Forward functions and definitions
 *
 * @package Forward
 */


if ( ! function_exists( 'forward_google_fonts' ) ) :
/**
 * Adds google font support.
 * 
 */
function forward_google_fonts() {
	$query_args = array(
		'family' => 'Source+Sans+Pro:200,300,400,600',

		// Here's an example for changing fonts.
		// 
		// 'family' => 'Open+Sans:400,700|Oswald:700',
		// 'subset' => 'latin,latin-ext',
	);

	wp_register_style( 'source-sans', add_query_arg( $query_args, "//fonts.googleapis.com/css" ), array(), null );

	wp_enqueue_style('source-sans');
}
endif; // forward_google_fonts
add_action('wp_enqueue_scripts', 'forward_google_fonts');

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}


if ( ! function_exists( 'forward_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function forward_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Forward, use a find and replace
	 * to change 'forward' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'forward', get_template_directory() . '/languages' );

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
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'forward' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'forward_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // forward_setup
add_action( 'after_setup_theme', 'forward_setup' );


if ( ! function_exists( 'forward_widgets_init' ) ) :
/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function forward_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'forward' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
endif; // forward_widgets_init
add_action( 'widgets_init', 'forward_widgets_init' );

if ( ! function_exists( 'forward_scripts' ) ) :
/**
 * Enqueue scripts and styles.
 */
function forward_scripts() {
	wp_enqueue_style( 'forward-style', get_stylesheet_uri() );

	// Front-end scripts
	if ( !is_admin() ) {

	  // Load minified scripts if debug mode is off
	  if ( WP_DEBUG === true ) {
	    $suffix = '';
	  } else {
	    $suffix = '.min';
	  }

	  // Load theme-specific JavaScript with versioning based on last modified time; http://www.ericmmartin.com/5-tips-for-using-jquery-with-wordpress/
	  wp_enqueue_script( 'forward-js-core', get_stylesheet_directory_uri() . '/js/core' . $suffix . '.js', array( 'jquery' ), filemtime( get_template_directory() . '/js/core' . $suffix . '.js' ), true );

	  // Conditionally load another script
	  // if ( is_singular() ) {
	  //   wp_enqueue_script( 'my-theme-extras', get_stylesheet_directory_uri() . '/js/extras' . $suffix . '.js', array( 'jquery' ), filemtime( get_template_directory() . '/js/extras' . $suffix . '.js' ), true );
	  // }
	}

	// wp_enqueue_script( 'forward-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	// wp_enqueue_script( 'forward-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
endif; // forward_scripts
add_action( 'wp_enqueue_scripts', 'forward_scripts' );


/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Enable automatic theme updates.
 */
require_once('wp-updates-theme.php');
new WPUpdatesThemeUpdater_1511( 'http://wp-updates.com/api/2/theme', basename( get_template_directory() ) );
