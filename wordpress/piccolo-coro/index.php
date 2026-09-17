<?php get_header(); ?>
<main class="article">
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <article <?php post_class(); ?>><h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1><p class="meta"><?php echo esc_html(get_the_date()); ?></p><?php the_excerpt(); ?></article>
  <?php endwhile; the_posts_pagination(); else: ?><p>Nessun contenuto disponibile.</p><?php endif; ?>
</main>
<?php get_footer(); ?>
