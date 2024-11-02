<?php
/**
 * The template for displaying header.
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! hello_get_header_display() ) {
    return;
}

$is_editor = isset( $_GET['elementor-preview'] );
$site_name = get_bloginfo( 'name' );
$tagline   = get_bloginfo( 'description', 'display' );
$header_nav_menu = wp_nav_menu( [
    'theme_location' => 'menu-1',
    'fallback_cb' => false,
    'echo' => false,
] );
?>
<header id="site-header" class="site-header dynamic-header <?php echo esc_attr( hello_get_header_layout_class() ); ?>" role="banner">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <?php if ( has_custom_logo() ) : ?>
                <div class="site-logo">
                    <?php the_custom_logo(); ?>
                </div>
            <?php endif; ?>

            <?php if ( $site_name ) : ?>
                <h1 class="site-title">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr__( 'Home', 'hello-elementor' ); ?>" rel="home">
                        <?php echo esc_html( $site_name ); ?>
                    </a>
                </h1>
            <?php endif; ?>

            <?php if ( $tagline ) : ?>
                <p class="site-description">
                    <?php echo esc_html( $tagline ); ?>
                </p>
            <?php endif; ?>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle navigation', 'hello-elementor'); ?>">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <?php if ( $header_nav_menu ) : ?>
                    <div class="site-navigation">
                        <?php
                        // PHPCS - escaped by WordPress with "wp_nav_menu"
                        echo $header_nav_menu; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                        ?>
                    </div>
                <?php endif; ?>

                <form class="d-flex ms-auto" action="<?php echo esc_url(home_url('/')); ?>" method="get">
                    <label for="search-input" class="visually-hidden"><?php esc_html_e('Search', 'hello-elementor'); ?></label>
                    <input id="search-input" class="form-control me-2" type="search" name="s" placeholder="<?php esc_attr_e('Search...', 'hello-elementor'); ?>" aria-label="<?php esc_attr_e('Search', 'hello-elementor'); ?>">
                    <button class="btn btn-outline-success" type="submit">
                        <i class="eicon-search" aria-hidden="true"></i>
                        <span class="visually-hidden"><?php esc_html_e('Search', 'hello-elementor'); ?></span>
                    </button>
                </form>
            </div>
        </div>
    </nav>
</header>
