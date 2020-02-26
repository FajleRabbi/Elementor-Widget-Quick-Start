<?php
/**
 * Plugin Name: Avocado Extensions
 * Description: Elementor extensions for avocado e-commerce template.
 * Plugin URI:  https://fajlerabbi.me/plugins
 * Version:     1.0.0
 * Author:      Fajle Rabbi
 * Author URI:  https://fajlerabbi.me/
 * Text Domain: avocado
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

final class Avocado_Extension {


    const VERSION = '1.0.0';
    const MINIMUM_ELEMENTOR_VERSION = '2.0.0';
    const MINIMUM_PHP_VERSION = '5.6';

    private static $_instance = null;

    public static function instance() {

        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;

    }

    public function __construct() {

        add_action('init', [$this, 'i18n']);
        add_action('plugins_loaded', [$this, 'init']);

    }


    public function i18n() {

        load_plugin_textdomain('avocado');

    }


    public function init() {

        // Check if Elementor installed and activated
        if (!did_action('elementor/loaded')) {
            add_action('admin_notices', [$this, 'admin_notice_missing_main_plugin']);
            return;
        }

        // Check for required Elementor version
        if (!version_compare(ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=')) {
            add_action('admin_notices', [$this, 'admin_notice_minimum_elementor_version']);
            return;
        }

        // Check for required PHP version
        if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
            add_action('admin_notices', [$this, 'admin_notice_minimum_php_version']);
            return;
        }

        // Add Plugin actions
        add_action('elementor/widgets/widgets_registered', [$this, 'init_widgets']);
        // Register Widget Styles
        add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'widget_styles' ] );

    }
    public function widget_styles() {
        wp_enqueue_style( 'avocado-slider', plugins_url( 'widgets/css/slider.css', __FILE__ ) );
        wp_enqueue_style( 'avocado-contentBlock', plugins_url( 'widgets/css/content-block.css', __FILE__ ) );

    }


    public function admin_notice_missing_main_plugin() {

        if (isset($_GET['activate'])) unset($_GET['activate']);

        $message = sprintf(
        /* translators: 1: Plugin name 2: Elementor */
            esc_html__('"%1$s" requires "%2$s" to be installed and activated.', 'avocado'),
            '<strong>' . esc_html__('Elementor Test Extension', 'avocado') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'avocado') . '</strong>'
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);

    }


    public function admin_notice_minimum_elementor_version() {

        if (isset($_GET['activate'])) unset($_GET['activate']);

        $message = sprintf(
        /* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'avocado'),
            '<strong>' . esc_html__('Elementor Test Extension', 'avocado') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'avocado') . '</strong>',
            self::MINIMUM_ELEMENTOR_VERSION
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);

    }


    public function admin_notice_minimum_php_version() {

        if (isset($_GET['activate'])) unset($_GET['activate']);

        $message = sprintf(
        /* translators: 1: Plugin name 2: PHP 3: Required PHP version */
            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'avocado'),
            '<strong>' . esc_html__('Elementor Test Extension', 'avocado') . '</strong>',
            '<strong>' . esc_html__('PHP', 'avocado') . '</strong>',
            self::MINIMUM_PHP_VERSION
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);

    }


    public function init_widgets() {

        // Include Widget files
        require_once(__DIR__ . '/widgets/category-block.php');

        // Register widget
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Avocado_category_block());


    }

}

Avocado_Extension::instance();





function Avocado_Plugin_Scripts() {

    wp_enqueue_style('slick-css', plugins_url('assets/css/slick.css', __FILE__), null, false, 'all');
    wp_enqueue_script('slick-js', plugins_url('assets/js/slick.min.js', __FILE__), array('jquery'), false, true);

}
add_action('wp_enqueue_scripts', 'Avocado_Plugin_Scripts');

