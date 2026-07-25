<?php

if (!defined('ABSPATH')) {
    exit;
}

$section_title = $section_title ?? get_field('section_title');
$highlighted_title = $highlighted_title ?? get_field('highlighted_title');
$tabs = $tabs ?? get_field('tabs');

$mobile_prefix = ($block_id ?? 'tabs-section') . '-mobile';

if (empty($tabs)) {
    return;
}
?>

<div class="tabs-section-mobile">
    <div class="tabs-section-mobile__container">

        <?php if ($section_title || $highlighted_title) : ?>
            <header class="tabs-section-mobile__header">
                <h2 class="tabs-section-mobile__title">

                    <?php if ($section_title) : ?>
                        <span class="tabs-section-mobile__title-light">
                            <?php echo esc_html($section_title); ?>
                        </span>
                    <?php endif; ?>

                    <?php if ($highlighted_title) : ?>
                        <span class="tabs-section-mobile__title-bold">
                            <?php echo esc_html($highlighted_title); ?>
                        </span>
                    <?php endif; ?>

                </h2>
            </header>
        <?php endif; ?>

        <div class="tabs-section-mobile__slider">
            <div
                class="tabs-section-mobile__slider-track"
                role="tablist"
                aria-label="<?php echo esc_attr(
                    $section_title ?: 'Customer stories'
                ); ?>"
            >
                <?php foreach ($tabs as $index => $tab) : ?>
                    <?php
                    $is_active = $index === 0;
                    $tab_logo = $tab['tab_logo'] ?? null;
                    $tab_title = $tab['tab_title'] ?? '';

                    $mobile_tab_id =
                        $mobile_prefix . '-tab-' . ($index + 1);

                    $mobile_panel_id =
                        $mobile_prefix . '-panel-' . ($index + 1);
                    ?>

                    <button
                        id="<?php echo esc_attr($mobile_tab_id); ?>"
                        class="tabs-section-mobile__tab<?php echo $is_active ? ' is-active' : ''; ?>"
                        type="button"
                        role="tab"
                        aria-selected="<?php echo $is_active ? 'true' : 'false'; ?>"
                        aria-controls="<?php echo esc_attr($mobile_panel_id); ?>"
                        tabindex="<?php echo $is_active ? '0' : '-1'; ?>"
                    >
                        <?php if (!empty($tab_logo['url'])) : ?>
                            <img
                                class="tabs-section-mobile__tab-logo"
                                src="<?php echo esc_url($tab_logo['url']); ?>"
                                alt="<?php echo esc_attr(
                                    !empty($tab_logo['alt'])
                                        ? $tab_logo['alt']
                                        : $tab_title
                                ); ?>"
                            >
                        <?php elseif ($tab_title) : ?>
                            <span class="tabs-section-mobile__tab-title">
                                <?php echo esc_html($tab_title); ?>
                            </span>
                        <?php endif; ?>
                    </button>

                <?php endforeach; ?>
            </div>
        </div>

        <div class="tabs-section-mobile__panels">

            <?php foreach ($tabs as $index => $tab) : ?>
                <?php
                $is_active = $index === 0;

                $mobile_tab_id =
                    $mobile_prefix . '-tab-' . ($index + 1);

                $mobile_panel_id =
                    $mobile_prefix . '-panel-' . ($index + 1);

               $quote_text = 'DealHub gave reps full quoting autonomy, enabling them to generate accurate, on-brand proposals in minutes, cutting deal cycles from 7 days to 48 hours.';

                $customer_name = 'Lucy Anne Link lorem ipsum';

                $customer_role = 'Manager of Deal Desk lorem ipsum, Intuit';
                $media_image = $tab['media_image'] ?? null;
                $usage_groups = $tab['usage_groups'] ?? [];
                $metrics = is_array($tab['metrics'] ?? null)
                    ? $tab['metrics']
                    : [];

                $solutions_group = $usage_groups[0] ?? [];
                $crm_group = $usage_groups[1] ?? [];

                $solutions_label =
                $solutions_group['group_label'] ?? 'Solutions used';

                $mobile_solutions =
                $tab['mobile_solutions'] ?? [];

                $solution_items =
                !empty($mobile_solutions)
                    ? $mobile_solutions
                    : ($solutions_group['usage_items'] ?? []);
                            $crm_items =
                    $crm_group['usage_items'] ?? [];

                $crm_item = $crm_items[0] ?? null;
                ?>

                <div
                    id="<?php echo esc_attr($mobile_panel_id); ?>"
                    class="tabs-section-mobile__panel<?php echo $is_active ? ' is-active' : ''; ?>"
                    role="tabpanel"
                    aria-labelledby="<?php echo esc_attr($mobile_tab_id); ?>"
                    <?php echo $is_active ? '' : 'hidden'; ?>
                >
                    <div class="tabs-section-mobile__story">

                        <article class="tabs-section-mobile__quote-card">

                            <?php if ($quote_text) : ?>
                                <blockquote class="tabs-section-mobile__quote">

                                    <img
                                        class="tabs-section-mobile__quote-icon"
                                        src="<?php echo esc_url(
                                            get_template_directory_uri()
                                            . '/assets/images/quote.svg'
                                        ); ?>"
                                        alt=""
                                        aria-hidden="true"
                                    >

                                    <div class="tabs-section-mobile__quote-text">
                                        <?php echo wp_kses_post(
                                            wpautop($quote_text)
                                        ); ?>
                                    </div>

                                </blockquote>
                            <?php endif; ?>

                            <?php if (
                                $customer_name
                                || $customer_role
                            ) : ?>
                                <div class="tabs-section-mobile__signature">

                                    <?php if ($customer_name) : ?>
                                        <p class="tabs-section-mobile__customer-name">
                                            <?php echo esc_html(
                                                $customer_name
                                            ); ?>
                                        </p>
                                    <?php endif; ?>

                                    <?php if ($customer_role) : ?>
                                        <p class="tabs-section-mobile__customer-role">
                                            <?php echo esc_html(
                                                $customer_role
                                            ); ?>
                                        </p>
                                    <?php endif; ?>

                                </div>
                            <?php endif; ?>

                            <button
                                class="tabs-section-mobile__case-study-button"
                                type="button"
                            >
                                <span>Case Study</span>

                                <span class="tabs-section-mobile__case-study-arrow">
                                    <img
                                        src="<?php echo esc_url(
                                            get_template_directory_uri() . '/assets/images/arrow 1.svg'
                                        ); ?>"
                                        alt=""
                                        aria-hidden="true"
                                    >
                                </span>
                            </button>

                        </article>

                        <?php if (!empty($media_image['url'])) : ?>
                            <div class="tabs-section-mobile__media">
                                <img
                                    class="tabs-section-mobile__media-image"
                                    src="<?php echo esc_url(
                                        $media_image['url']
                                    ); ?>"
                                    alt="<?php echo esc_attr(
                                        $media_image['alt'] ?? ''
                                    ); ?>"
                                >

                                <span
                                    class="tabs-section-mobile__play"
                                    aria-hidden="true"
                                ></span>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($solution_items)) : ?>
                            <div class="tabs-section-mobile__solutions-card">

                                <p class="tabs-section-mobile__solutions-title">
                                    <?php echo esc_html($solutions_label); ?>
                                </p>

                                <div class="tabs-section-mobile__solutions-items">

                                    <?php foreach ($solution_items as $item) : ?>
                                        <?php
                                        $item_icon =
                                            $item['item_icon'] ?? null;

                                        $item_name =
                                            $item['item_name'] ?? '';
                                        ?>

                                        <div class="tabs-section-mobile__solution-item">

                                            <?php if (!empty($item_icon['url'])) : ?>
                                                <img
                                                    class="tabs-section-mobile__solution-icon"
                                                    src="<?php echo esc_url(
                                                        $item_icon['url']
                                                    ); ?>"
                                                    alt="<?php echo esc_attr(
                                                        !empty($item_icon['alt'])
                                                            ? $item_icon['alt']
                                                            : $item_name
                                                    ); ?>"
                                                >
                                            <?php endif; ?>

                                            <?php if ($item_name) : ?>
                                                <span class="tabs-section-mobile__solution-name">
                                                    <?php echo esc_html(
                                                        $item_name
                                                    ); ?>
                                                </span>
                                            <?php endif; ?>

                                        </div>
                                    <?php endforeach; ?>

                                </div>

                            </div>
                        <?php endif; ?>

                       <div class="tabs-section-mobile__data-grid">

                            <?php if (!empty($crm_item)) : ?>
                                <?php
                                $crm_name = $crm_item['item_name'] ?? '';
                                ?>

                                <div class="tabs-section-mobile__data-card tabs-section-mobile__crm-card">

                                    <img
                                        class="tabs-section-mobile__crm-icon"
                                        src="<?php echo esc_url(
                                            get_template_directory_uri()
                                            . '/assets/images/Salesforce.png'
                                        ); ?>"
                                        alt="Salesforce"
                                    >

                                    <?php if ($crm_name) : ?>
                                        <p class="tabs-section-mobile__crm-name">
                                            <?php echo esc_html($crm_name); ?>
                                        </p>
                                    <?php endif; ?>

                                    <p class="tabs-section-mobile__crm-label">
                                        CRM used
                                    </p>

                                </div>
                            <?php endif; ?>

                           <?php if (!empty($metrics) && is_array($metrics)) : ?>

                            <?php foreach ($metrics as $metric) : ?>
                                <?php
                                $metric_value = $metric['metric_value'] ?? '';
                                $metric_label = $metric['metric_label'] ?? '';
                                ?>

                                <?php if ($metric_value || $metric_label) : ?>
                                    <div class="tabs-section-mobile__data-card tabs-section-mobile__metric">

                                        <?php if ($metric_value) : ?>
                                            <p class="tabs-section-mobile__metric-value">
                                                <?php echo esc_html($metric_value); ?>
                                            </p>
                                        <?php endif; ?>

                                        <?php if ($metric_label) : ?>
                                            <p class="tabs-section-mobile__metric-label">
                                                <?php echo esc_html($metric_label); ?>
                                            </p>
                                        <?php endif; ?>

                                    </div>
                                <?php endif; ?>

                            <?php endforeach; ?>

                        <?php endif; ?>

                        </div>
                    </div>
                </div>

            <?php endforeach; ?>

        </div>

    </div>
</div>