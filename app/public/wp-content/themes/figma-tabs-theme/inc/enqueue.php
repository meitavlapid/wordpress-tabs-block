<?php

if (!defined('ABSPATH')) {
    exit;
}

function figma_tabs_enqueue_assets()
{
    $css_path = get_template_directory() . '/assets/css/main.css';
    $mobile_css_path = get_template_directory() . '/blocks/tabs-section/mobile.css';
    $js_path = get_template_directory() . '/assets/js/main.js';

    wp_enqueue_style(
        'figma-tabs-dm-sans',
        'https://fonts.googleapis.com/css2?family=Caveat:wght@700&family=DM+Sans:wght@300;400;600;700&display=swap',
        [],
        null
    );

    wp_enqueue_style(
        'figma-tabs-main',
        get_template_directory_uri() . '/assets/css/main.css',
        ['figma-tabs-dm-sans'],
        file_exists($css_path)
            ? filemtime($css_path)
            : '1.0.0'
    );

    wp_enqueue_style(
        'figma-tabs-mobile',
        get_template_directory_uri() . '/blocks/tabs-section/mobile.css',
        ['figma-tabs-main'],
        file_exists($mobile_css_path)
            ? filemtime($mobile_css_path)
            : '1.0.0'
    );

    wp_enqueue_script(
        'figma-tabs-main',
        get_template_directory_uri() . '/assets/js/main.js',
        [],
        file_exists($js_path)
            ? filemtime($js_path)
            : '1.0.0',
        true
    );
}

add_action('wp_enqueue_scripts', 'figma_tabs_enqueue_assets');