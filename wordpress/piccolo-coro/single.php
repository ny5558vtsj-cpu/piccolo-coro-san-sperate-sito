<?php get_header(); ?>
<main class="article">
  <?php while (have_posts()) : the_post(); ?><article <?php post_class(); ?>><p class="eyebrow"><?php echo esc_html(get_post_type_object(get_post_type())->labels->singular_name); ?></p><h1><?php the_title(); ?></h1><?php if (get_post_type() === 'evento') : ?><p class="meta"><?php echo esc_html(get_post_meta(get_the_ID(), '_evento_data', true)); ?> · <?php echo esc_html(get_post_meta(get_the_ID(), '_evento_luogo', true)); ?></p><?php endif; ?><?php if (has_post_thumbnail()) { the_post_thumbnail('large'); } ?><?php the_content(); ?></article><?php endwhile; ?>
</main>
<?php get_footer(); ?>
