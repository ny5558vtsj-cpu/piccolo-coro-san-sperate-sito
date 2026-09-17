<?php get_header(); ?>
<main>
  <section class="hero">
    <div>
      <?php if (has_custom_logo()) { echo wp_get_attachment_image(get_theme_mod('custom_logo'), 'large', false, ['class' => 'hero-logo', 'alt' => 'Logo APS Piccolo Coro San Sperate']); } ?>
    </div>
    <div>
      <span class="eyebrow">APS · San Sperate · Sardegna</span>
      <h1><span>Canta, cresci,</span><br>condividi.</h1>
      <p>Dal 2011 la musica unisce bambini, ragazzi e famiglie.</p>
      <a class="button" href="#cori">Scopri i nostri cori</a>
    </div>
  </section>

  <div class="wrap">
    <section id="chi-siamo" class="section intro">
      <p class="eyebrow">Il nostro coro</p>
      <h2 class="section-title">Crescere insieme attraverso la musica</h2>
      <p>Il Piccolo Coro San Sperate nasce nel 2011 e diventa associazione nel 2015. Oggi è un’Associazione di Promozione Sociale iscritta al RUNTS. Promuoviamo formazione musicale, canto corale, amicizia e condivisione attraverso prove, concerti, progetti e viaggi.</p>
    </section>

    <section id="cori" class="section">
      <p class="eyebrow">Tre percorsi, una sola passione</p>
      <h2 class="section-title">I nostri cori</h2>
      <div class="cards">
        <article class="card"><h3>PiccoleGemme</h3><strong>Propedeutica · 4–6 anni</strong><p>Musica, ritmo, movimento e gioco per scoprire insieme la propria voce.</p></article>
        <article class="card"><h3>Piccolo Coro</h3><strong>Voci bianche · 6–13 anni</strong><p>Canto corale, formazione, concerti e nuove esperienze da vivere insieme.</p></article>
        <article class="card"><h3>Coro InCanto</h3><strong>Coro giovanile · 13–30 anni</strong><p>Un percorso dedicato ai ragazzi e ai giovani, dove la voce incontra nuove armonie.</p></article>
      </div>
    </section>

    <section class="section">
      <p class="eyebrow">Dal coro</p>
      <h2 class="section-title">Ultime notizie</h2>
      <div class="news-grid">
      <?php $news = new WP_Query(['post_type' => 'post', 'posts_per_page' => 3]); if ($news->have_posts()) : while ($news->have_posts()) : $news->the_post(); ?>
        <article class="news-card"><?php if (has_post_thumbnail()) { the_post_thumbnail('medium_large'); } ?><p class="meta"><?php echo esc_html(get_the_date()); ?></p><h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3><?php the_excerpt(); ?></article>
      <?php endwhile; wp_reset_postdata(); else: ?><div class="empty-state">Le prossime notizie dell’associazione saranno pubblicate qui.</div><?php endif; ?>
      </div>
    </section>

    <section class="section events-section">
      <p class="eyebrow">Prossimi appuntamenti</p>
      <h2 class="section-title">Eventi</h2>
      <div class="event-list">
      <?php
      $events = new WP_Query([
          'post_type' => 'evento',
          'posts_per_page' => 3,
          'meta_key' => '_evento_data',
          'orderby' => 'meta_value',
          'order' => 'ASC',
          'meta_query' => [['key' => '_evento_data', 'value' => wp_date('Y-m-d'), 'compare' => '>=', 'type' => 'DATE']],
      ]);
      if ($events->have_posts()) : while ($events->have_posts()) : $events->the_post();
          $event_date = get_post_meta(get_the_ID(), '_evento_data', true);
          $event_place = get_post_meta(get_the_ID(), '_evento_luogo', true);
      ?>
        <article class="event-row"><div class="event-date"><?php echo esc_html($event_date ? wp_date('d M', strtotime($event_date)) : 'Data da definire'); ?></div><div><h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3><?php if ($event_place) : ?><p><?php echo esc_html($event_place); ?></p><?php endif; ?></div></article>
      <?php endwhile; wp_reset_postdata(); else: ?><div class="empty-state">I prossimi appuntamenti saranno pubblicati qui.</div><?php endif; ?>
      </div>
    </section>

    <section class="section highlight">
      <div><p class="eyebrow">Dal 2011</p><h2 class="section-title">Una storia fatta di voci e incontri</h2><p>Negli anni il coro ha portato la propria musica in Sardegna e nel resto d’Italia, partecipando a rassegne, collaborazioni e grandi progetti.</p></div>
      <aside><strong>La musica è il nostro modo di stare insieme.</strong><br>Ogni prova, concerto e viaggio diventa un’occasione di crescita.</aside>
    </section>

    <section id="contatti" class="section">
      <p class="eyebrow">Contatti</p><h2 class="section-title">Vieni a cantare con noi</h2>
      <div class="contacts"><div><strong>APS Piccolo Coro San Sperate</strong><br>San Sperate · Sardegna</div><div><strong>Email istituzionale</strong><br><a href="mailto:presidente@piccolocorossansperate.it">presidente@piccolocorossansperate.it</a></div><div><strong>Telefono</strong><br>PiccoleGemme e Piccolo Coro: <a href="tel:+393284678735">328 467 8735</a><br>Coro InCanto: <a href="tel:+393465985980">346 598 5980</a></div></div>
    </section>
  </div>
</main>
<?php get_footer(); ?>
