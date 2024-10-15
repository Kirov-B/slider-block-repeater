<?php

/**
 * Plugin Name:       Slider Block Repeater
 * Description:       A custom block for creating sliders custom fields.
 * Version:           1.0.0
 * Author:            Bone Kirov
 *
 * @package           slider-repeater
 */


/**
 * Register blocks
 *
 * @return void
 */
function digicube_slider_register_blocks()
{
	/**
	 * We register our block's with WordPress's handy
	 * register_block_type();
	 *
	 * @link https://developer.wordpress.org/reference/functions/register_block_type/
	 */
	register_block_type(__DIR__ . '/slider/');
}
add_action('init', 'digicube_slider_register_blocks', 5);

/**
 * Check for JavaScript modules and set
 * type="module" based on the registered handle.
 *
 * @param string $tag The <script> tag for the enqueued script.
 * @param string $handle The script's registered handle.
 * @return string $tag The <script> tag for the enqueued script.
 */
function digicube_script_attrs($tag, $handle)
{
	if (str_contains($handle, 'module')) {
		$tag = str_replace('<script ', '<script type="module" ', $tag);
	}

	return $tag;
}
add_filter('script_loader_tag', 'digicube_script_attrs', 10, 2);



/**
 * Register Slick scripts.
 *
 * @return void
 */
function digicube_slider_register_scripts()
{
	wp_register_script(
		'slick',
		plugins_url('assets/slick/slick.min.js', __FILE__),
		['jquery'],
		'1.0.0',
		true
	);

	wp_register_style(
		'slick',
		plugins_url('assets/slick/slick.css', __FILE__),
		[],
		'1.0.0'
	);


	wp_register_style(
		'slick-theme',
		plugins_url('assets/slick/slick-theme.css', __FILE__),
		[],
		'1.0.0'
	);


}
add_action('enqueue_block_assets', 'digicube_slider_register_scripts');



/**
 * Modify the save path for ACF JSON files.
 *
 * This function changes the default save location for ACF JSON files to a custom directory
 * within the plugin's folder. This is useful for version control and portability of ACF field groups.
 *
 * @param string $path The original save path.
 * @return string The modified save path.
 */
function digicube_json_save_point($path)
{
	return plugin_dir_path(__FILE__) . '/fields/';
}

/**
 * Modify the load paths for ACF JSON files.
 *
 * This function changes the default load location for ACF JSON files to a custom directory
 * within the plugin's folder. It also removes the original load path if needed.
 *
 * @param array $paths The original load paths.
 * @return array The modified load paths.
 */
function digicube_json_load_point($paths)
{
	// Append your custom path
	$paths[] = plugin_dir_path(__FILE__) . '/fields/';

	return $paths;
}
add_filter('acf/settings/load_json', 'digicube_json_load_point');