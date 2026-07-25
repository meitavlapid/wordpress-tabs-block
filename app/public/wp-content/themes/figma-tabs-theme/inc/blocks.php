<?php

if (!defined('ABSPATH')) {
    exit;
}

function figma_tabs_register_blocks()
{
    $block_path = get_template_directory() . '/blocks/tabs-section';
    if (!file_exists($block_path . '/block.json')) {
        return;
    }
    register_block_type($block_path);
}

add_action('init', 'figma_tabs_register_blocks');