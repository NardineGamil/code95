<?php
/**
 * The template for displaying header.
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}

$header_nav_menu = wp_nav_menu( [
  'theme_location' => 'menu-1',
  'fallback_cb' => false,
  'echo' => false,
] );
?>

<header id="site-header" class="site-header-one" role="banner">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="true" aria-label="<?php esc_attr_e('Toggle navigation', 'hello-elementor'); ?>">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <?php if ($header_nav_menu) : ?>
          <?php echo wp_kses_post($header_nav_menu); // Escape output for security ?>
        <?php endif; ?>

        <!-- Search Bar -->
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

