<?php
/**
 * Genesis Sample iGuRu.gr.
 *
 * This file adds functions to the Genesis Sample iGuRu.gr Theme.
 *
 * @package Genesis Sample
 * @author  StudioPress iGuRu.gr
 * @license GPL-2.0-or-later
 * @link    https://iGuRu.gr/
 */

// Starts the engine.
require_once get_template_directory() . '/lib/init.php';

// Sets up the Theme.
require_once get_stylesheet_directory() . '/lib/theme-defaults.php';

add_action( 'after_setup_theme', 'genesis_sample_localization_setup' );
/**
 * Sets localization (do not remove).
 *
 * @since 1.0.0
 */
function genesis_sample_localization_setup() {

	load_child_theme_textdomain( genesis_get_theme_handle(), get_stylesheet_directory() . '/languages' );

}

// Adds helper functions.
require_once get_stylesheet_directory() . '/lib/helper-functions.php';

// Adds image upload and color select to Customizer.
require_once get_stylesheet_directory() . '/lib/customize.php';

// Includes Customizer CSS.
require_once get_stylesheet_directory() . '/lib/output.php';

// Adds WooCommerce support.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-setup.php';

// Adds the required WooCommerce styles and Customizer CSS.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-output.php';

// Adds the Genesis Connect WooCommerce notice.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-notice.php';

add_action( 'after_setup_theme', 'genesis_child_gutenberg_support' );
/**
 * Adds Gutenberg opt-in features and styling.
 *
 * @since 2.7.0
 */
function genesis_child_gutenberg_support() { // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- using same in all child themes to allow action to be unhooked.
	require_once get_stylesheet_directory() . '/lib/gutenberg/init.php';
}

// Registers the responsive menus.
if ( function_exists( 'genesis_register_responsive_menus' ) ) {
	genesis_register_responsive_menus( genesis_get_config( 'responsive-menus' ) );
}

add_action( 'wp_enqueue_scripts', 'genesis_sample_enqueue_scripts_styles' );
/**
 * Enqueues scripts and styles.
 *
 * @since 1.0.0
 */
function genesis_sample_enqueue_scripts_styles() {

	$appearance = genesis_get_config( 'appearance' );

	wp_enqueue_style(
		genesis_get_theme_handle() . '-fonts',
		$appearance['fonts-url'],
		[],
		genesis_get_theme_version()
	);

	wp_enqueue_style( 'dashicons' );

	if ( genesis_is_amp() ) {
		wp_enqueue_style(
			genesis_get_theme_handle() . '-amp',
			get_stylesheet_directory_uri() . '/lib/amp/amp.css',
			[ genesis_get_theme_handle() ],
			genesis_get_theme_version()
		);
	}

}

add_action( 'after_setup_theme', 'genesis_sample_theme_support', 9 );
/**
 * Add desired theme supports.
 *
 * See config file at `config/theme-supports.php`.
 *
 * @since 3.0.0
 */
function genesis_sample_theme_support() {

	$theme_supports = genesis_get_config( 'theme-supports' );

	foreach ( $theme_supports as $feature => $args ) {
		add_theme_support( $feature, $args );
	}

}

add_action( 'after_setup_theme', 'genesis_sample_post_type_support', 9 );
/**
 * Add desired post type supports.
 *
 * See config file at `config/post-type-supports.php`.
 *
 * @since 3.0.0
 */
function genesis_sample_post_type_support() {

	$post_type_supports = genesis_get_config( 'post-type-supports' );

	foreach ( $post_type_supports as $post_type => $args ) {
		add_post_type_support( $post_type, $args );
	}

}

// Adds image sizes.
add_image_size( 'sidebar-featured', 75, 75, true );
add_image_size( 'iguru-mini', 60, 60, true );
add_image_size( 'genesis-singular-images', 702, 526, true );

// Removes header right widget area.
unregister_sidebar( 'header-right' );

// Removes secondary sidebar.
unregister_sidebar( 'sidebar-alt' );

// Removes site layouts.
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

// Repositions primary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 12 );

// Repositions the secondary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 10 );

add_filter( 'wp_nav_menu_args', 'genesis_sample_secondary_menu_args' );
/**
 * Reduces secondary navigation menu to one level depth.
 *
 * @since 2.2.3
 *
 * @param array $args Original menu options.
 * @return array Menu options with depth set to 1.
 */
function genesis_sample_secondary_menu_args( $args ) {

	if ( 'secondary' === $args['theme_location'] ) {
		$args['depth'] = 1;
	}

	return $args;

}

add_filter( 'genesis_author_box_gravatar_size', 'genesis_sample_author_box_gravatar' );
/**
 * Modifies size of the Gravatar in the author box.
 *
 * @since 2.2.3
 *
 * @param int $size Original icon size.
 * @return int Modified icon size.
 */
function genesis_sample_author_box_gravatar( $size ) {

	return 90;

}

add_filter( 'genesis_comment_list_args', 'genesis_sample_comments_gravatar' );
/**
 * Modifies size of the Gravatar in the entry comments.
 *
 * @since 2.2.3
 *
 * @param array $args Gravatar settings.
 * @return array Gravatar settings with modified size.
 */
function genesis_sample_comments_gravatar( $args ) {

	$args['avatar_size'] = 60;
	return $args;

}
//* Clear autoptimize cache at 512MB iGuRu.gr
if (class_exists('autoptimizeCache')) {
    $iguruMaxSize = 512000; 
    $statArr=autoptimizeCache::stats(); 
    $cacheSize=round($statArr[1]/1024);
    
    if ($cacheSize>$iguruMaxSize){
       autoptimizeCache::clearall();
       header("Refresh:0");
    }
}
add_image_size( 'small-featured', 80, 80, TRUE );

//* Mod Content iguru.gr
function hatom_mod_post_content ($content) {
  if ( in_the_loop() && !is_home() && !is_page() ) {
    $content = '<span class="entry-content">'.$content.'</span>';
  }
  return $content;
}
add_filter( 'the_content', 'hatom_mod_post_content');

//*Add Hatom Giorgos                                                                                          
function add_hatom_data($content) {
    $t = get_the_modified_time('F j, Y, g:i a');
    $author = get_the_author();
    $title = get_the_title();
if (is_singular()) {
        $content .= '<div class="hatom-extra" style="display:none;visibility:hidden;"><span class="entry-title">'.$title.'</span> was last modified: <span class="updated"> '.$t.'</span> by <span class="author vcard"><span class="fn">'.$author.'</span></span></div>';
    }
    return $content;
    }
add_filter('the_content', 'add_hatom_data');

if ( ! isset( $content_width ) ) $content_width = 800;

// Hook menu in footer.
add_action( 'genesis_footer', 'iguru_footer_menu', 12 );
function iguru_footer_menu() {
	printf( '<nav %s>', genesis_attr( 'nav-footer' ) );
	wp_nav_menu( array(
		'theme_location' => 'footer',
		'container'      => false,
		'depth'          => 1,
		'fallback_cb'    => false,
		'menu_class'     => 'genesis-nav-menu',
	) );
	echo '</nav>';
}
// Nav footer attributes.
add_filter( 'genesis_attr_nav-footer', 'iguru_footer_nav_attr' );
function iguru_footer_nav_attr( $attributes ) {
	$attributes['itemscope'] = true;
	$attributes['itemtype']  = 'http://schema.org/SiteNavigationElement';
	return $attributes;
}

// Adds support for after entry widget.
add_theme_support( 'genesis-after-entry-widget-area' );


add_filter( 'get_the_content_limit', 'iguru_content_limit_read_more_markup', 10, 3 );

add_filter ( 'genesis_next_link_text' , 'iguru_next_page_link' );
function giorgos_next_page_link ( $text ) {
    return '&#x0276D;';
}
add_filter ( 'genesis_prev_link_text' , 'iguru_prev_page_link' );
function giorgos_prev_page_link ( $text ) {
    return '&#x0276C;';
}

//* Hidden title for SEO iguru 
add_filter('genesis_footer_creds_text', 'iguru_footer_creds_text', 5, 3 );
function giorgos_footer_creds_text() {
    echo '<div class="seocreds"><p>';
    echo 'iGuRu.gr &nbsp;';
    echo ' Νέα Τεχνολογίας σε πραγματικό χρόνο. Απόψεις & Tweaks';  
    echo '</p></div>';
    }

//* Customize the credits iguru 
add_filter('genesis_footer_creds_text', 'custom_footer_creds_text');
function custom_footer_creds_text() {
    echo '<div class="creds"><p>';
    echo 'iGuRu.gr &copy; 2012 - ';
    echo date('Y');
    echo ' <span class="giorgos"> &#x2622;</span>   Keep it Simple Stupid Genesis Theme';  
    echo '</p></div>';
    }

// Enqueue dequeue files.

function remove_devicepx() {
    wp_dequeue_script( 'devicepx' );
}
add_action( 'wp_enqueue_scripts', 'remove_devicepx');
add_action( 'admin_enqueue_scripts', 'remove_devicepx' );

//* iguru add entry title link

add_filter( 'genesis_post_title_output', 'iguru_post_title_output', 15 );
 function iguru_post_title_output( $title ) {
 if ( is_single() )
 $title = sprintf( '<a href="%s" title="%s" rel="bookmark">%s</a>', get_permalink(), the_title_attribute( 'echo=0' ), apply_filters( 'genesis_post_title_text', $title ) );
 return $title;
}

add_filter( 'genesis_show_comment_date', 'iguru_remove_comment_time_and_link' );
function iguru_remove_comment_time_and_link( $comment_date ) {
	printf( '<p %s>', genesis_attr( 'comment-meta' ) );
	printf( '<time %s>', genesis_attr( 'comment-time' ) );
	echo    esc_html( get_comment_date() );
	echo    '</time></p>';
	return false;
}
//* query strings iguru
function _remove_script_version( $src ){
	$parts = explode( '?', $src );
	return $parts[0];
}
add_filter( 'script_loader_src', '_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', '_remove_script_version', 15, 1 );


add_action( 'wp_print_styles', 'iguru_dequeue_font_awesome_style' );
function iguru_dequeue_font_awesome_style() {
      wp_dequeue_style( 'fontawesome' );
      wp_deregister_style( 'fontawesome' );
}

add_filter( 'genesis_title_comments', 'iguru_genesis_title_comments' );
function iguru_genesis_title_comments() {
	$title = '<h6><strong>Σχόλια</strong></h6>';
	return $title;
}

add_filter( 'comment_form_defaults', 'iguru_comment_submit_button' );
function iguru_comment_submit_button( $defaults ) {
 
        $defaults['label_submit'] = __( 'Δημοσίευση', 'custom' );
        return $defaults;
 
}
add_filter( 'comment_form_defaults', 'iguru_comment_form_defaults' );
function iguru_comment_form_defaults( $defaults ) {
	$defaults['title_reply'] = __( '<strong><h6>Αφήστε το σχόλιό σας</h6></strong>' );
	return $defaults;
}
add_action( 'genesis_after_comments', 'iguru_comment_policy' );
function iguru_comment_policy() {
	if ( is_single() && !is_user_logged_in() && comments_open() ) {
	?>
	<div class="comment-policy-box">
<p class="comment-policy"><strong>Comment Policy:</strong>
		</p>
		<h3><p>Tο iGuRu.gr δεν δημοσιεύει άμεσα τα σχόλια. Κακόβουλα σχόλια, σχόλια που συμπεριλαμβάνουν διαφημίσεις, ή σχόλια με ύβρεις διαγράφονται χωρίς καμία προειδοποίηση. Δεν υιοθετούμε τις απόψεις που εκφράζουν οι αναγνώστες μας.<br>Τα σχολιά σας θα εμφανιστούν μετά την έγκρισή τους από τους διαχειριστές</p></h3><hr>
	</div>
	<?php
	}
}
add_filter( 'genesis_comment_list_args', 'iguru_comments_gravatar' );
function iguru_comments_gravatar( $args ) {
	$args['avatar_size'] = 77;
	return $args;
}


add_filter( 'comment_form_default_fields', 'iguru_modify_comment_author_email_url_labels' );
function iguru_modify_comment_author_email_url_labels( $fields ) {
	$commenter = wp_get_current_commenter();
	$req      = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );
	$args = wp_parse_args( $args );
	if ( ! isset( $args['format'] ) )
		$args['format'] = current_theme_supports( 'html5', 'comment-form' ) ? 'html5' : 'xhtml';
	$html5    = 'html5' === $args['format'];
	$fields   =  array(
		'author' => '<p class="comment-form-author">' . '<i class="fa fa-user-o"></i> <label for="author">' . __( '<strong>Όνομα</strong>' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
		            '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
		'email'  => '<p class="comment-form-email"><i class="fa fa-envelope-o"></i> <label for="email">' . __( '<strong>Email</strong>' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
		            '<input id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>',
	);
	return $fields;
}
add_filter( 'comment_form_defaults', 'iguru_change_comment_label' );
function iguru_change_comment_label( $args ) {
	$args['comment_field'] = '<p class="comment-form-comment"><i class="fa fa-commenting-o"></i> <label for="comment">' . _x( '<strong>Το σχόλιό σας</strong>', 'noun' ) . '</label> <textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>';
	return $args;
}

// Disable WP Emoji's
function disable_emojis() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
 
    add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
}
add_action( 'init', 'disable_emojis' );
 
// Disable TinyMCE Emoji's
function disable_emojis_tinymce( $plugins ) {
    if ( is_array( $plugins ) ) {
        return array_diff( $plugins, array( 'wpemoji' ) );
    } else {
        return array();
    }
}

// Register widget areas.
genesis_register_sidebar( array(
	'id'          => 'topbar',
	'name'        => __( 'Topbar', 'custom-iguru-theme' ),
	'description' => __( 'This is the topbar section.', 'custom-iguru-theme' ),
) );

// Topbar with contact info and social links.
add_action( 'genesis_after_header', 'iguru_topbar' );
function iguru_topbar()	{
	if( is_front_page() && is_active_sidebar('topbar') ) {
	
		genesis_widget_area( 'topbar', array(
			'before' => '<div class="site-topbar" class="widget-area">',
			'after'	 => '</div>',		
		
	) );
 }


}
//* Add widget area between and after 4 posts iguru
add_action( 'genesis_after_entry', 'iguru_between_posts_area' );

function iguru_between_posts_area() {
global $loop_counter;

$loop_counter++;

if( $loop_counter == 4 ) {


if ( is_active_sidebar( 'between-posts-area' ) ) {
    echo '<div class="between-posts-area widget-area"><div class="wrap">';
	dynamic_sidebar( 'between-posts-area' );
	echo '</div></div><!-- end .top -->';
	}

$loop_counter = 10;

}

}
genesis_register_sidebar( array(
	'id' 			=> 'between-posts-area',
	'name' 			=> __( 'Between Posts Area', 'custom-iguru-theme' ),
	'description' 	=> __( 'This widget area is shows after every fourth blog post to display an ad.', 'custom-iguru-theme' ),
) );

//* Register widget areas
genesis_register_sidebar( array(
	'id'          => 'home-featured',
	'name'        => __( 'Home Featured', '$text_domain' ),
	'description' => __( 'Home Featured Widget First Page Only', '$text_domain' ),
) );

//* Hook Home Featured Widget First Page Only
add_action( 'genesis_before_loop', 'front_page_featured_widget' );

function front_page_featured_widget() {

	if( is_front_page() && is_active_sidebar('home-featured') ) {
	
		genesis_widget_area( 'home-featured', array(
			'before' => '<div class="home-featured" class="widget-area">',
			'after'	 => '</div>',
		) );



     }


}
genesis_register_widget_area(array(
        'id'          => 'ad-content',
        'name'        => __( 'Ad Content', 'text-domain' ),
        'description' => __( 'This is the ad content section.', 'text-domain' ),
    )
);

add_filter( 'the_content', 'custom_insert_widget_area' );
/**
 * Filters the content to insert widget area after specified paragraph of single post content.
 *
 * @param string $content Existing post content.
 * @return string Modified post content.
 */
function custom_insert_widget_area( $content ) {

    ob_start();
        genesis_widget_area( 'ad-content', array(
            'before' => '<div class="ad-content widget-area"><div class="wrap">',
            'after'  => '</div></div>',
        ) );
    $widget_area_html = ob_get_clean();

    if ( is_singular( 'post' ) ) {
        $content = custom_insert_after_paragraph( $widget_area_html, 3, $content ); 
    }

    return $content;
}

//* Callback function
function custom_insert_after_paragraph( $insertion, $paragraph_id, $content ) {

    $closing_p = '</p>';

    $paragraphs = explode( $closing_p, $content );

    foreach ( $paragraphs as $index => $paragraph ) {

        if ( trim( $paragraph ) ) {
            $paragraphs[ $index ] .= $closing_p;
        }

        if ( $paragraph_id === $index + 1 ) {
            $paragraphs[ $index ] .= $insertion;
        }
    }

    return implode( '', $paragraphs );

}
//** new loop
// Register loopnews widget area.
genesis_register_sidebar( array(
	'id'          => 'newsletter',
	'name'        => __( 'Loop Widget', 'iguru-Pro' ),
	'description' => __( 'This is a Loop widget area.', 'iguru-Pro' ),
) );
	  
add_action( 'genesis_after_entry', 'theme_newsletter_widget_area' );
function theme_newsletter_widget_area() {
	if( is_front_page() && !is_paged() && is_active_sidebar('newsletter') ) {
	global $wp_query;
	$counter = $wp_query->current_post;
	if ( 3 == $counter ) {
		genesis_widget_area( 'newsletter', array(
			'before' => '<div class="loopnews">',
			'after'  => '</div>',
		) );
	}
}	}  

// Register second loopnews widget area.
genesis_register_sidebar( array(
	'id'          => 'news',
	'name'        => __( 'Second Loop Widget', 'iguru-Pro' ),
	'description' => __( 'This is a Loop (2) widget area.', 'iguru-Pro' ),
) );
	  
add_action( 'genesis_after_entry', 'theme_news_widget_area' );
function theme_news_widget_area() {
	if( is_front_page() && !is_paged() && is_active_sidebar('news') ) {
	global $wp_query;
	$counter = $wp_query->current_post;
	if ( 7 == $counter ) {
		genesis_widget_area( 'news', array(
			'before' => '<div class="loopnews">',
			'after'  => '</div>',
		) );
	}
}	}  




add_filter( 'genesis_breadcrumb_args', 'child_theme_breadcrumb_modifications' );
function child_theme_breadcrumb_modifications( $args ) {
$args['labels']['prefix'] = '';
$args['home'] = 'home';
	return $args;
}
// Disable oEmbed Discovery Links
remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);

function oiw_remove_head_scripts() {
remove_action('wp_head', 'wp_print_scripts');
remove_action('wp_head', 'wp_print_head_scripts', 9);
remove_action('wp_head', 'wp_enqueue_scripts', 1);
 
add_action('wp_footer', 'wp_print_scripts', 5);
add_action('wp_footer', 'wp_enqueue_scripts', 5);
add_action('wp_footer', 'wp_print_head_scripts', 5);
}
function my_deregister_javascript() 
 { 
    if ( is_front_page() || is_home() ) 
      {
        wp_dequeue_script( 'fitvids' );
		wp_dequeue_script( 'svg-x-use' );
		wp_dequeue_script( 'arqicon.ttf' );
		wp_dequeue_script ( 'arqam-scripts' );
		wp_dequeue_script ( 'jquery-migrate' );
		wp_dequeue_script ( 'ai-jquery' );
		wp_dequeue_script ( 'html5shiv' );
		wp_dequeue_script( 'toc-front' );
		wp_dequeue_script( 'superfish' );
		wp_dequeue_script( 'superfish-args' );
      } 
 }
 
 //* Security Headers iGuRu.gr
add_action('send_headers', function(){ 
	header("X-Content-Type-Options: nosniff");
	header("Referrer-Policy: no-referrer-when-downgrade");
}, 1);
@ini_set('session.cookie_httponly', true);
@ini_set('session.cookie_secure', true);
@ini_set('session.use_only_cookies', true);
remove_action('xmlrpc_rsd_apis', 'rest_output_rsd');
          remove_action('wp_head', 'rest_output_link_wp_head');
        remove_action('template_redirect', 'rest_output_link_header', 11, 0);

//* SEO Framework iGuRu.gr

add_filter('the_seo_framework_og_image_args', function($args) {
    $args['image'] = home_url('https://iguru.gr/wp-content/uploads/2018/07/iguru.jpg');

    return $args;
});


add_filter('the_seo_framework_indicator', '__return_false');

add_action( 'get_header', 'sk_set_full_layout' );
function sk_set_full_layout() {
	if ( ! ( is_singular( 'post' ) || is_archive() ) ) {
		return;
	}
//* Force full width content
	add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
}
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
add_action( 'genesis_entry_header', 'genesis_do_post_image', 5 );

add_action( 'genesis_after_entry_content', 'sk_remove_entry_footer' );

 //* Removes the entry footer except.

function iguru_remove_entry_footer() {

    if ( is_singular( 'post' ) ) {
        return;
    }

    remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
    remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
    remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );

}
