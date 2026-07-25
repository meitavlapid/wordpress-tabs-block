# DealHub WordPress Tabs Section

## Overview

This project implements a responsive WordPress Gutenberg block based on the provided Figma design.

The component includes separate desktop and mobile layouts, dynamic content managed through WordPress, accessible tab navigation, and a responsive mobile slider.

## Features

- Custom WordPress Gutenberg block
- Dynamic tab content
- Responsive desktop, laptop, tablet and mobile layouts
- Dedicated mobile layout based on the Figma design
- Keyboard-accessible tab navigation
- ARIA attributes for improved accessibility
- Infinite mobile tabs slider
- Automatic centering of the active mobile tab
- Responsive images, typography, spacing and data cards
- Video pausing when switching between panels
- No external JavaScript slider library

## Main Files

- `assets/css/main.css` – Desktop, laptop and tablet styles
- `blocks/tabs-section/mobile.css` – Mobile styles
- `assets/js/main.js` – Tabs and mobile slider functionality
- `blocks/tabs-section/render.php` – Desktop block markup
- `blocks/tabs-section/mobile.php` – Mobile block markup
- `blocks/tabs-section/block.json` – Gutenberg block configuration
- `functions.php` – Asset loading and block registration

## Installation

1. Copy the theme folder into:

   `wp-content/themes/`

2. Activate the theme from the WordPress admin panel.

3. Open the page containing the Tabs Section block.

4. Edit the block content through the WordPress editor.

## Responsive Behavior

- Desktop layout: above 1100px
- Small laptop and tablet layout: 768px–1100px
- Dedicated mobile layout: up to 767px

## Notes

The mobile and desktop versions use the same content data while presenting layouts specifically adapted to each screen size.