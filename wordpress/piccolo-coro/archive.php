<?php get_header(); ?>
<main class="wrap section"><p class="eyebrow">Archivio</p><h1 class="section-title"><?php post_type_archive_title(); ?></h1><div class="news-grid">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?><article class="news-card"><?php if (has_post_thumbnail()) { the_post_thumbnail('medium_large'); } ?><h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3><?php the_excerpt(); ?></article><?php endwhile; else: ?><div class="empty-state">Nessun contenuto disponibile.</div><?php endif; ?>
</div><?php the_posts_pagination(); ?></main>
<?php get_footer(); ?>
