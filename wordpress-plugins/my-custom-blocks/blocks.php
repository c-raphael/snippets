<?php
/**
 * Plugin Name: My Custom Blocks
 * Plugin URI: https://example.com
 * Description: This plugin adds custom blocks to the Gutenberg editor.
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: https://example.com
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: my-custom-blocks
 */

// Add your plugin code below this line


// Enqueue all 
function blocks_enqueue_assets() {
    // JQuery Enqueue
    wp_enqueue_script( 'jquery' ); 
    wp_enqueue_script('jquery-effects-core', 'https://code.jquery.com/ui/1.12.1/jquery-ui.min.js', array('jquery'), false, true);
    wp_enqueue_script('jquery-ui-core', 'https://code.jquery.com/ui/1.12.1/jquery-ui.min.js', array('jquery'), false, true);    
    

    // Declaration
    $blocks_dir = plugin_dir_path(__FILE__) . 'blocks/';
    $blocks_js = glob($blocks_dir . '**/*.js');
    $blocks_css = glob($blocks_dir . '**/*.css');    

    // Javascript Enqueue in blocks directory
    foreach ($blocks_js as $js) {
        wp_enqueue_script(
            'my-custom-block-' . basename(dirname($js)) . '-' . basename($js, '.js'),
            plugin_dir_url(__FILE__) . 'blocks/' . basename(dirname($js)) . '/' . basename($js),
            array('wp-blocks', 'wp-editor'),
            filemtime($js)
        );
    }

    // CSS Enqueue in blocks directory
    foreach ($blocks_css as $css) {
        wp_enqueue_style(
            'my-custom-block-' . basename(dirname($css)) . '-' . basename($css, '.css'),
            plugin_dir_url(__FILE__) . 'blocks/' . basename(dirname($css)) . '/' . basename($css),
            array('wp-edit-blocks'),
            filemtime($css)
        );
    }
}
add_action('enqueue_block_assets', 'blocks_enqueue_assets');


// Create catergory in Block Editor
function blocks_register_block_category( $categories, $post ) {
    return array_merge(
        $categories,
        array(
            array(
                'slug' => 'custom-blocks',
                'title' => __( 'Custom Blocks', 'custom-blocks' ),
                'icon' => 'smiley',
            ),
        )
    );
}
add_filter( 'block_categories', 'blocks_register_block_category', 10, 2 );


// Register all blocks into Block Editor
function blocks_register_block() {
    $blocks_dir = plugin_dir_path(__FILE__) . 'blocks/';
    $blocks = glob($blocks_dir . '**/*.js');

    foreach ($blocks as $block) {
        $block_name = str_replace($blocks_dir, '', $block);
        $block_name = str_replace('.js', '', $block_name);

        $css_file = str_replace('.js', '.css', $block);
        $css_file = str_replace($blocks_dir, '', $css_file);

        register_block_type(
            'my-custom-blocks/' . $block_name,
            array(
                'editor_script' => 'my-custom-block-' . $block_name,
                'editor_style' => 'my-custom-block-' . $block_name . '-css',
                'style' => 'my-custom-block-' . $block_name . '-css',
                'category' => 'custom-blocks', // Use the new category name
                'icon' => 'smiley',
            )
        );
    }
}

add_action('init', 'blocks_register_block');




