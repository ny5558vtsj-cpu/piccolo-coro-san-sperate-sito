<footer class="site-footer">
  <p>© <?php echo esc_html(wp_date('Y')); ?> APS Piccolo Coro San Sperate · Associazione di Promozione Sociale</p>
  <?php wp_nav_menu(['theme_location' => 'footer', 'container' => false, 'fallback_cb' => false]); ?>
</footer>
<?php wp_footer(); ?>
</body></html>
