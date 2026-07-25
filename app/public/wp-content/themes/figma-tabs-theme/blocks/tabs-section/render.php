<?php

if (!defined('ABSPATH')) {
    exit;
}

$section_title = get_field('section_title');
$highlighted_title = get_field('highlighted_title');
$section_description = get_field('section_description');
$tabs = get_field('tabs');
$block_id = 'tabs-section-' . ($block['id'] ?? uniqid());
if (!empty($block['anchor'])) {
    $block_id = sanitize_title($block['anchor']);
}
$class_name = 'tabs-section';
if (!empty($block['className'])) {
    $class_name .= ' ' . sanitize_html_class($block['className']);
}
if (empty($tabs)) {
    if (is_admin()) {
        echo '<p>Please add at least one tab.</p>';
    }
    return;
}
?>
<section
    id="<?php echo esc_attr($block_id); ?>"
    class="<?php echo esc_attr($class_name); ?>"
>
    <div class="tabs-section__container">
        <?php if ($section_title || $section_description) : ?>
            <header class="tabs-section__header">
               <?php if ($section_title || $highlighted_title) : ?>
    <h2 class="tabs-section__title">
        <?php if ($section_title) : ?>
            <span class="tabs-section__title-main">
                <?php echo esc_html($section_title); ?>
            </span>
        <?php endif; ?>
        <?php if ($highlighted_title) : ?>
            <span class="tabs-section__title-highlight">
                <?php echo esc_html($highlighted_title); ?>
            </span>
        <?php endif; ?>
    </h2>
<?php endif; ?>
                <?php if ($section_description) : ?>
                    <div class="tabs-section__description">
                        <?php echo wp_kses_post(wpautop($section_description)); ?>
                    </div>
                <?php endif; ?>
            </header>
        <?php endif; ?>
        <div class="tabs-section__navigation-wrapper">
            <div
                class="tabs-section__navigation"
                role="tablist"
                aria-label="<?php echo esc_attr($section_title ?: 'Content tabs'); ?>"
            >
                <?php foreach ($tabs as $index => $tab) : ?>
                    <?php
                    $tab_number = $index + 1;
                    $tab_id = $block_id . '-tab-' . $tab_number;
                    $panel_id = $block_id . '-panel-' . $tab_number;
                    $is_active = $index === 0;
                    $tab_logo = $tab['tab_logo'] ?? null;
                    ?>
                    <button
                        id="<?php echo esc_attr($tab_id); ?>"
                        class="tabs-section__tab<?php echo $is_active ? ' is-active' : ''; ?>"
                        type="button"
                        role="tab"
                        aria-selected="<?php echo $is_active ? 'true' : 'false'; ?>"
                        aria-controls="<?php echo esc_attr($panel_id); ?>"
                        tabindex="<?php echo $is_active ? '0' : '-1'; ?>"
                    >
                        <?php if (!empty($tab_logo['url'])) : ?>
                            <img
                                class="tabs-section__tab-logo"
                                src="<?php echo esc_url($tab_logo['url']); ?>"
                                alt="<?php echo esc_attr(
                                    !empty($tab_logo['alt'])
                                        ? $tab_logo['alt']
                                        : ($tab['tab_title'] ?? '')
                                ); ?>"
                            >
                        <?php endif; ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="tabs-section__panels">
            <?php foreach ($tabs as $index => $tab) : ?>
                <?php
                $tab_number = $index + 1;
                $tab_id = $block_id . '-tab-' . $tab_number;
                $panel_id = $block_id . '-panel-' . $tab_number;
                $is_active = $index === 0;
                $quote_text = $tab['quote_text'] ?? '';
                $customer_logo = $tab['customer_logo'] ?? null;
                $customer_name = $tab['customer_name'] ?? '';
                $customer_role = $tab['customer_role'] ?? '';
                $usage_groups = $tab['usage_groups'] ?? [];
                $metrics = $tab['metrics'] ?? [];
                $media_image = $tab['media_image'] ?? null;
                ?>
                <div
                    id="<?php echo esc_attr($panel_id); ?>"
                    class="tabs-section__panel<?php echo $is_active ? ' is-active' : ''; ?>"
                    role="tabpanel"
                    aria-labelledby="<?php echo esc_attr($tab_id); ?>"
                    <?php echo $is_active ? '' : 'hidden'; ?>
                >
                    <div class="tabs-section__content">
                        <div class="tabs-section__copy">
                            <?php if ($quote_text) : ?>
                                <blockquote class="tabs-section__quote">
    <img
        class="tabs-section__quote-icon"
        src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/quote.svg"
        alt=""
        aria-hidden="true"
    >
    <?php echo wp_kses_post(wpautop($quote_text)); ?>
</blockquote>
                            <?php endif; ?>
                            <?php if (
                                !empty($customer_logo['url'])
                                || $customer_name
                                || $customer_role
                            ) : ?>
                                <div class="tabs-section__customer">
                                    <?php if (!empty($customer_logo['url'])) : ?>
                                        <img
                                            class="tabs-section__customer-logo"
                                            src="<?php echo esc_url($customer_logo['url']); ?>"
                                            alt="<?php echo esc_attr(
                                                !empty($customer_logo['alt'])
                                                    ? $customer_logo['alt']
                                                    : $customer_name
                                            ); ?>"
                                        >
                                    <?php endif; ?>
                                    <?php if ($customer_name || $customer_role) : ?>
                                        <div class="tabs-section__customer-info">
                                            <?php if ($customer_name) : ?>
                                                <p class="tabs-section__customer-name">
                                                    <?php echo esc_html($customer_name); ?>
                                                </p>
                                            <?php endif; ?>
                                            <?php if ($customer_role) : ?>
                                                <p class="tabs-section__customer-role">
                                                    <?php echo esc_html($customer_role); ?>
                                                </p>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="tabs-section__data">
                                <?php if (!empty($usage_groups)) : ?>
                                    <div class="tabs-section__usage-groups">
                                        <?php foreach ($usage_groups as $group) : ?>
                                            <?php
                                            $group_label = $group['group_label'] ?? '';
                                            $usage_items = $group['usage_items'] ?? [];
                                            ?>
                                            <?php if ($group_label || !empty($usage_items)) : ?>
                                                <div class="tabs-section__usage-group">
                                                    <?php if ($group_label) : ?>
                                                        <p class="tabs-section__usage-label">
                                                            <?php echo esc_html($group_label); ?>
                                                        </p>
                                                    <?php endif; ?>
                                                    <?php if (!empty($usage_items)) : ?>
                                                        <div class="tabs-section__usage-items">
                                                            <?php foreach ($usage_items as $item) : ?>
                                                                <?php
                                                                $item_icon = $item['item_icon'] ?? null;
                                                                $item_name = $item['item_name'] ?? '';
                                                                ?>
                                                                <div class="tabs-section__usage-item">
                                                                    <?php if (!empty($item_icon['url'])) : ?>
                                                                        <img
                                                                            class="tabs-section__usage-icon"
                                                                            src="<?php echo esc_url($item_icon['url']); ?>"
                                                                            alt="<?php echo esc_attr(
                                                                                !empty($item_icon['alt'])
                                                                                    ? $item_icon['alt']
                                                                                    : $item_name
                                                                            ); ?>"
                                                                        >
                                                                    <?php endif; ?>
                                                                    <?php if ($item_name) : ?>
                                                                        <span class="tabs-section__usage-name">
                                                                            <?php echo esc_html($item_name); ?>
                                                                        </span>
                                                                    <?php endif; ?>
                                                                </div>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($media_image['url'])) : ?>
                                    <div class="tabs-section__media">
                                        <img
                                            class="tabs-section__media-image"
                                            src="<?php echo esc_url($media_image['url']); ?>"
                                            alt="<?php echo esc_attr($media_image['alt'] ?? ''); ?>"
                                        >
                                    </div>
                                <?php endif; ?>
                            <?php if (!empty($metrics)) : ?>
                                <div class="tabs-section__metrics">
                                    <?php foreach ($metrics as $metric) : ?>
                                        <?php
                                        $metric_value = $metric['metric_value'] ?? '';
                                        $metric_label = $metric['metric_label'] ?? '';
                                        ?>
                                        <?php if ($metric_value || $metric_label) : ?>
                                            <div class="tabs-section__metric">
                                                <?php if ($metric_value) : ?>
                                                    <p class="tabs-section__metric-value">
                                                        <?php echo esc_html($metric_value); ?>
                                                    </p>
                                                <?php endif; ?>
                                                <?php if ($metric_label) : ?>
                                                    <p class="tabs-section__metric-label">
                                                        <?php echo esc_html($metric_label); ?>
                                                    </p>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="tabs-section__mobile">
    <?php include __DIR__ . '/mobile.php'; ?>
</div>
</section>