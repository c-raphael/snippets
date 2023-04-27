<?php

define('... app name ...', '0.1');


// Include other functions
get_template_part('functions/init');
get_template_part('functions/editor');


// Set the number of posts to show on the homepage
function top_posts_setting($query) {
  if ( is_admin() || ! $query->is_main_query() || ! is_home() )
    return;

  $query->set('posts_per_page', 4);
  return;
}
add_action('pre_get_posts', 'top_posts_setting', 1);


// Register the navigation menus
function theme_register_nav_menu() {
    register_nav_menus(
        array(
            'primary-menu' => __( 'Primary Menu', 'theme-text-ipsp-domain' ),
            'footer-menu' => __( 'Footer Menu', 'theme-text-ipsp-domain' )
        )
    );
}
add_action( 'after_setup_theme', 'theme_register_nav_menu' );


// Custom Directory for Medias
function custom_upload_dir( $upload_dir ) {
    $upload_dir['subdir'] = '';
    $upload_dir['path'] = $upload_dir['basedir'];
    $upload_dir['url'] = $upload_dir['baseurl'];
    return $upload_dir;
}
add_filter( 'upload_dir', 'custom_upload_dir' );



// Register Theme Sections
/* to get: <div><?php echo get_theme_mod( 'custom_copywrite_text' ); ?></div> */
function copyright_theme_settings($wp_customize) {
    $wp_customize->add_section('custom_copywrite_section', array(
        'title' => __('Custom Copywrite Section', 'custom_theme'),
        'priority' => 30,
    ));

    $wp_customize->add_setting('custom_copywrite_text', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('custom_copywrite_text', array(
        'label' => __('Copywrite Text', 'custom_theme'),
        'section' => 'custom_copywrite_section',
        'type' => 'text',
    ));
}
add_action('customize_register', 'copyright_theme_settings');