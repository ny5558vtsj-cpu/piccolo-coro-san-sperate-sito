<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="site-header">
  <a class="site-brand" href="<?php echo esc_url(home_url('/')); ?>">
    <?php if (has_custom_logo()) { $logo = wp_get_attachment_image_src(get_theme_mod('custom_logo'), 'thumbnail'); echo '<img src="' . esc_url($logo[0]) . '" alt="">'; } ?>
    <span>Piccolo Coro San Sperate</span>
  </a>
  <button class="menu-toggle" aria-expanded="false" aria-controls="site-navigation">☰<span class="screen-reader-text">Apri il menu</span></button>
  <nav id="site-navigation" class="site-nav" aria-label="Menu principale">
    <?php wp_nav_menu(['theme_location' => 'primary', 'container' => false, 'menu_class' => 'main-menu', 'fallback_cb' => 'piccolo_coro_fallback_menu']); ?>
  </nav>
</header>
<?php
function piccolo_coro_fallback_menu() {
    echo '<ul class="main-menu"><li><a href="' . esc_url(home_url('/#chi-siamo')) . '">Chi siamo</a></li><li><a href="' . esc_url(home_url('/#cori')) . '">I cori</a></li><li><a href="' . esc_url(get_post_type_archive_link('evento')) . '">Eventi</a></li><li><a href="' . esc_url(home_url('/gestionale/')) . '">Gestionale</a></li><li><a href="' . esc_url(home_url('/#contatti')) . '">Contatti</a></li></ul>';
}
?>
