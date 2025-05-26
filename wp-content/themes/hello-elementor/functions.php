<?php
/**
 * Theme functions and definitions
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'HELLO_ELEMENTOR_VERSION', '3.4.1' );
define( 'EHP_THEME_SLUG', 'hello-elementor' );

define( 'HELLO_THEME_PATH', get_template_directory() );
define( 'HELLO_THEME_URL', get_template_directory_uri() );
define( 'HELLO_THEME_ASSETS_PATH', HELLO_THEME_PATH . '/assets/' );
define( 'HELLO_THEME_ASSETS_URL', HELLO_THEME_URL . '/assets/' );
define( 'HELLO_THEME_SCRIPTS_PATH', HELLO_THEME_ASSETS_PATH . 'js/' );
define( 'HELLO_THEME_SCRIPTS_URL', HELLO_THEME_ASSETS_URL . 'js/' );
define( 'HELLO_THEME_STYLE_PATH', HELLO_THEME_ASSETS_PATH . 'css/' );
define( 'HELLO_THEME_STYLE_URL', HELLO_THEME_ASSETS_URL . 'css/' );
define( 'HELLO_THEME_IMAGES_PATH', HELLO_THEME_ASSETS_PATH . 'images/' );
define( 'HELLO_THEME_IMAGES_URL', HELLO_THEME_ASSETS_URL . 'images/' );

if ( ! isset( $content_width ) ) {
	$content_width = 800; // Pixels.
}

if ( ! function_exists( 'hello_elementor_setup' ) ) {
	/**
	 * Set up theme support.
	 *
	 * @return void
	 */
	function hello_elementor_setup() {
		if ( is_admin() ) {
			hello_maybe_update_theme_version_in_db();
		}

		if ( apply_filters( 'hello_elementor_register_menus', true ) ) {
			register_nav_menus( [ 'menu-1' => esc_html__( 'Header', 'hello-elementor' ) ] );
			register_nav_menus( [ 'menu-2' => esc_html__( 'Footer', 'hello-elementor' ) ] );
		}

		if ( apply_filters( 'hello_elementor_post_type_support', true ) ) {
			add_post_type_support( 'page', 'excerpt' );
		}

		if ( apply_filters( 'hello_elementor_add_theme_support', true ) ) {
			add_theme_support( 'post-thumbnails' );
			add_theme_support( 'automatic-feed-links' );
			add_theme_support( 'title-tag' );
			add_theme_support(
				'html5',
				[
					'search-form',
					'comment-form',
					'comment-list',
					'gallery',
					'caption',
					'script',
					'style',
				]
			);
			add_theme_support(
				'custom-logo',
				[
					'height'      => 100,
					'width'       => 350,
					'flex-height' => true,
					'flex-width'  => true,
				]
			);
			add_theme_support( 'align-wide' );
			add_theme_support( 'responsive-embeds' );

			/*
			 * Editor Styles
			 */
			add_theme_support( 'editor-styles' );
			add_editor_style( 'editor-styles.css' );

			/*
			 * WooCommerce.
			 */
			if ( apply_filters( 'hello_elementor_add_woocommerce_support', true ) ) {
				// WooCommerce in general.
				add_theme_support( 'woocommerce' );
				// Enabling WooCommerce product gallery features (are off by default since WC 3.0.0).
				// zoom.
				add_theme_support( 'wc-product-gallery-zoom' );
				// lightbox.
				add_theme_support( 'wc-product-gallery-lightbox' );
				// swipe.
				add_theme_support( 'wc-product-gallery-slider' );
			}
		}
	}
}
add_action( 'after_setup_theme', 'hello_elementor_setup' );

function hello_maybe_update_theme_version_in_db() {
	$theme_version_option_name = 'hello_theme_version';
	// The theme version saved in the database.
	$hello_theme_db_version = get_option( $theme_version_option_name );

	// If the 'hello_theme_version' option does not exist in the DB, or the version needs to be updated, do the update.
	if ( ! $hello_theme_db_version || version_compare( $hello_theme_db_version, HELLO_ELEMENTOR_VERSION, '<' ) ) {
		update_option( $theme_version_option_name, HELLO_ELEMENTOR_VERSION );
	}
}

if ( ! function_exists( 'hello_elementor_display_header_footer' ) ) {
	/**
	 * Check whether to display header footer.
	 *
	 * @return bool
	 */
	function hello_elementor_display_header_footer() {
		$hello_elementor_header_footer = true;

		return apply_filters( 'hello_elementor_header_footer', $hello_elementor_header_footer );
	}
}

if ( ! function_exists( 'hello_elementor_scripts_styles' ) ) {
	/**
	 * Theme Scripts & Styles.
	 *
	 * @return void
	 */
	function hello_elementor_scripts_styles() {
		$min_suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		if ( apply_filters( 'hello_elementor_enqueue_style', true ) ) {
			wp_enqueue_style(
				'hello-elementor',
				get_template_directory_uri() . '/style' . $min_suffix . '.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}

		if ( apply_filters( 'hello_elementor_enqueue_theme_style', true ) ) {
			wp_enqueue_style(
				'hello-elementor-theme-style',
				get_template_directory_uri() . '/theme' . $min_suffix . '.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}

		if ( hello_elementor_display_header_footer() ) {
			wp_enqueue_style(
				'hello-elementor-header-footer',
				get_template_directory_uri() . '/header-footer' . $min_suffix . '.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}
	}
}
add_action( 'wp_enqueue_scripts', 'hello_elementor_scripts_styles' );

if ( ! function_exists( 'hello_elementor_register_elementor_locations' ) ) {
	/**
	 * Register Elementor Locations.
	 *
	 * @param ElementorPro\Modules\ThemeBuilder\Classes\Locations_Manager $elementor_theme_manager theme manager.
	 *
	 * @return void
	 */
	function hello_elementor_register_elementor_locations( $elementor_theme_manager ) {
		if ( apply_filters( 'hello_elementor_register_elementor_locations', true ) ) {
			$elementor_theme_manager->register_all_core_location();
		}
	}
}
add_action( 'elementor/theme/register_locations', 'hello_elementor_register_elementor_locations' );

if ( ! function_exists( 'hello_elementor_content_width' ) ) {
	/**
	 * Set default content width.
	 *
	 * @return void
	 */
	function hello_elementor_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'hello_elementor_content_width', 800 );
	}
}
add_action( 'after_setup_theme', 'hello_elementor_content_width', 0 );

if ( ! function_exists( 'hello_elementor_add_description_meta_tag' ) ) {
	/**
	 * Add description meta tag with excerpt text.
	 *
	 * @return void
	 */
	function hello_elementor_add_description_meta_tag() {
		if ( ! apply_filters( 'hello_elementor_description_meta_tag', true ) ) {
			return;
		}

		if ( ! is_singular() ) {
			return;
		}

		$post = get_queried_object();
		if ( empty( $post->post_excerpt ) ) {
			return;
		}

		echo '<meta name="description" content="' . esc_attr( wp_strip_all_tags( $post->post_excerpt ) ) . '">' . "\n";
	}
}
add_action( 'wp_head', 'hello_elementor_add_description_meta_tag' );

// Settings page
require get_template_directory() . '/includes/settings-functions.php';

// Header & footer styling option, inside Elementor
require get_template_directory() . '/includes/elementor-functions.php';

if ( ! function_exists( 'hello_elementor_customizer' ) ) {
	// Customizer controls
	function hello_elementor_customizer() {
		if ( ! is_customize_preview() ) {
			return;
		}

		if ( ! hello_elementor_display_header_footer() ) {
			return;
		}

		require get_template_directory() . '/includes/customizer-functions.php';
	}
}
add_action( 'init', 'hello_elementor_customizer' );

if ( ! function_exists( 'hello_elementor_check_hide_title' ) ) {
	/**
	 * Check whether to display the page title.
	 *
	 * @param bool $val default value.
	 *
	 * @return bool
	 */
	function hello_elementor_check_hide_title( $val ) {
		if ( defined( 'ELEMENTOR_VERSION' ) ) {
			$current_doc = Elementor\Plugin::instance()->documents->get( get_the_ID() );
			if ( $current_doc && 'yes' === $current_doc->get_settings( 'hide_title' ) ) {
				$val = false;
			}
		}
		return $val;
	}
}
add_filter( 'hello_elementor_page_title', 'hello_elementor_check_hide_title' );

/**
 * BC:
 * In v2.7.0 the theme removed the `hello_elementor_body_open()` from `header.php` replacing it with `wp_body_open()`.
 * The following code prevents fatal errors in child themes that still use this function.
 */
if ( ! function_exists( 'hello_elementor_body_open' ) ) {
	function hello_elementor_body_open() {
		wp_body_open();
	}
}

// Count post views
function wpb_set_post_views($postID) {
    $count_key = 'wpb_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    
    if($count == '') {
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    } else {
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

// Get post views
function wpb_get_post_views($postID){
    $count_key = 'wpb_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    
    if($count == ''){
        return "0 Views";
    }
    return $count . ' Views';
}

// Hook into single post view
function wpb_track_post_views($post_id) {
    if (!is_single()) return;
    if (empty($post_id)) {
        global $post;
        $post_id = $post->ID;
    }
    wpb_set_post_views($post_id);
}
add_action('wp_head', 'wpb_track_post_views');

// Create shortcode
function wpb_post_views_shortcode($atts) {
    global $post;
    if (!isset($post->ID)) return '';
    return wpb_get_post_views($post->ID);
}
add_shortcode('post_views', 'wpb_post_views_shortcode');


// Shortcode for post update date
function shortcode_post_modified_date() {
    if (is_singular()) {
        return get_the_modified_date('Y-m-d');
    }
    return '';
}
add_shortcode('post_modified_date', 'shortcode_post_modified_date');

// Count post under the category
function showing_filtered_post_count_shortcode() {
    // Get total number of published posts (change 'post' to your CPT if needed)
    $total_posts = wp_count_posts('post')->publish;

    ob_start();
    ?>
    <div id="post-count-info">Showing all <?php echo $total_posts; ?> articles</div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const postCountDiv = document.getElementById('post-count-info');

        // Observe when posts change inside the Loop Grid
        const loopGrid = document.querySelector('.e-loop-container'); // Make sure this class matches yours
        if (!loopGrid || !postCountDiv) return;

        const updatePostCount = () => {
            const visiblePosts = loopGrid.querySelectorAll('.e-loop-item').length;
            const totalPosts = <?php echo $total_posts; ?>;
            postCountDiv.textContent = `Showing ${visiblePosts} of ${totalPosts} articles`;
        };

        // Watch for changes in the loop (posts being filtered)
        const observer = new MutationObserver(updatePostCount);
        observer.observe(loopGrid, { childList: true, subtree: true });

        // Run once on load
        updatePostCount();
    });
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('post_count_tracker', 'showing_filtered_post_count_shortcode');

// Test
function custom_category_post_count($atts) {
    $atts = shortcode_atts(array(
        'category' => '',
    ), $atts, 'category_post_count');

    if (empty($atts['category'])) {
        return '';
    }

    $term = get_term_by('slug', $atts['category'], 'category');
    if (!$term) {
        return '';
    }

    return $term->count;
}
add_shortcode('category_post_count', 'custom_category_post_count');

add_action('wp_ajax_get_category_post_count', 'get_category_post_count');
add_action('wp_ajax_nopriv_get_category_post_count', 'get_category_post_count');

function get_category_post_count() {
    if (isset($_POST['category'])) {
        $category_slug = sanitize_text_field($_POST['category']);
        $term = get_term_by('slug', $category_slug, 'category');

        if ($term && !is_wp_error($term)) {
            echo $term->count;
        } else {
            echo '0';
        }
    } else {
        echo '0';
    }
    wp_die();
}

add_action('wp_head', function() {
    ?>
    <script>
        var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
    </script>
    <?php
});


// test 2
function display_taxonomy_post_count() {
    // Get the current taxonomy term slug from the query string (assuming the URL includes the taxonomy filter)
    if (isset($_GET['post_cat'])) {
        $category_slug = sanitize_text_field($_GET['post_cat']);
    } else {
        return ''; // Return empty if no category is selected
    }

    // Set the parameters for the query
    $args = array(
        'post_type' => 'post', // Replace 'post' with your custom post type if needed
        'posts_per_page' => -1, // Get all posts
        'tax_query' => array(
            array(
                'taxonomy' => 'category', // Replace 'category' with your custom taxonomy if needed
                'field'    => 'slug',
                'terms'    => $category_slug,
                'operator' => 'IN',
            ),
        ),
    );

    // Get the posts based on the selected category
    $query = new WP_Query($args);
    $filtered_posts_count = $query->found_posts;

    // Get the total number of posts across all categories
    $total_posts_count = wp_count_posts()->publish;

    // Return the desired output
    return 'Showing ' . $filtered_posts_count . ' of ' . $total_posts_count . ' articles';
}
add_shortcode('taxonomy_post_count', 'display_taxonomy_post_count');

// Heading title
function show_taxonomy_title_articles() {
    if (is_tax() || is_category() || is_tag()) {
        $term = get_queried_object();
        if ($term && isset($term->name)) {
            return esc_html($term->name . ' Articles');
        }
    }
    return 'All Articles';
}
add_shortcode('taxonomy_title', 'show_taxonomy_title_articles');

// Calculate video length
function show_video_duration() {
    global $post;
    $duration = get_post_meta($post->ID, 'video_duration', true);
    return $duration ? esc_html($duration) : 'N/A';
}
add_shortcode('video_duration', 'show_video_duration');


require HELLO_THEME_PATH . '/theme.php';

HelloTheme\Theme::instance();
