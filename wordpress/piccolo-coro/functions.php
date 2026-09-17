<?php
if (!defined('ABSPATH')) { exit; }

function piccolo_coro_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', ['height' => 500, 'width' => 500, 'flex-height' => true, 'flex-width' => true]);
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);
    register_nav_menus(['primary' => 'Menu principale', 'footer' => 'Menu nel piè di pagina']);
}
add_action('after_setup_theme', 'piccolo_coro_setup');

function piccolo_coro_assets() {
    wp_enqueue_style('piccolo-coro-style', get_stylesheet_uri(), [], wp_get_theme()->get('Version'));
    wp_enqueue_script('piccolo-coro-menu', get_template_directory_uri() . '/menu.js', [], wp_get_theme()->get('Version'), true);
}
add_action('wp_enqueue_scripts', 'piccolo_coro_assets');

function piccolo_coro_content_types() {
    $types = [
        'evento' => ['Eventi', 'Evento', 'calendar-alt', 'eventi'],
        'progetto' => ['Progetti', 'Progetto', 'groups', 'progetti'],
        'galleria' => ['Gallerie', 'Galleria', 'format-gallery', 'gallerie'],
    ];
    foreach ($types as $slug => $labels) {
        register_post_type($slug, [
            'labels' => ['name' => $labels[0], 'singular_name' => $labels[1], 'add_new_item' => 'Aggiungi ' . strtolower($labels[1]), 'edit_item' => 'Modifica ' . strtolower($labels[1])],
            'public' => true,
            'show_in_rest' => true,
            'menu_icon' => 'dashicons-' . $labels[2],
            'supports' => ['title', 'editor', 'excerpt', 'thumbnail', 'author', 'revisions'],
            'has_archive' => true,
            'rewrite' => ['slug' => $labels[3]],
            'map_meta_cap' => true,
            'capability_type' => 'post',
        ]);
    }
}
add_action('init', 'piccolo_coro_content_types');

function piccolo_coro_event_fields() {
    add_meta_box('piccolo_coro_event_data', 'Data e luogo', 'piccolo_coro_event_fields_html', 'evento', 'side', 'high');
}
add_action('add_meta_boxes', 'piccolo_coro_event_fields');

function piccolo_coro_event_fields_html($post) {
    wp_nonce_field('piccolo_coro_event_save', 'piccolo_coro_event_nonce');
    $date = get_post_meta($post->ID, '_evento_data', true);
    $place = get_post_meta($post->ID, '_evento_luogo', true);
    echo '<p><label for="evento_data"><strong>Data</strong></label><br><input type="date" id="evento_data" name="evento_data" value="' . esc_attr($date) . '" style="width:100%"></p>';
    echo '<p><label for="evento_luogo"><strong>Luogo</strong></label><br><input type="text" id="evento_luogo" name="evento_luogo" value="' . esc_attr($place) . '" style="width:100%"></p>';
}

function piccolo_coro_save_event($post_id) {
    if (!isset($_POST['piccolo_coro_event_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['piccolo_coro_event_nonce'])), 'piccolo_coro_event_save')) { return; }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) { return; }
    if (!current_user_can('edit_post', $post_id)) { return; }
    foreach (['evento_data' => '_evento_data', 'evento_luogo' => '_evento_luogo'] as $field => $meta) {
        if (isset($_POST[$field])) { update_post_meta($post_id, $meta, sanitize_text_field(wp_unslash($_POST[$field]))); }
    }
}
add_action('save_post_evento', 'piccolo_coro_save_event');

function piccolo_coro_operator_role() {
    if (!get_role('operatore_coro')) {
        add_role('operatore_coro', 'Operatore del coro', [
            'read' => true, 'edit_posts' => true, 'delete_posts' => true, 'upload_files' => true,
        ]);
    }
}
add_action('after_switch_theme', 'piccolo_coro_operator_role');

function piccolo_coro_dashboard_guide() {
    wp_add_dashboard_widget(
        'piccolo_coro_guida',
        'Pubblicare sul sito del Piccolo Coro',
        function () {
            echo '<p><strong>Scegli cosa vuoi comunicare:</strong></p>';
            echo '<p><a class="button button-primary" href="' . esc_url(admin_url('post-new.php')) . '">Nuova notizia</a> ';
            echo '<a class="button" href="' . esc_url(admin_url('post-new.php?post_type=evento')) . '">Nuovo evento</a> ';
            echo '<a class="button" href="' . esc_url(admin_url('post-new.php?post_type=galleria')) . '">Nuova galleria</a></p>';
            echo '<p>Scrivi il titolo, aggiungi testo e fotografie, quindi usa <strong>Invia per la revisione</strong>. Gianna o l’amministratore potranno controllare e pubblicare.</p>';
        }
    );
}
add_action('wp_dashboard_setup', 'piccolo_coro_dashboard_guide');

function piccolo_coro_event_archive_order($query) {
    if (!is_admin() && $query->is_main_query() && is_post_type_archive('evento')) {
        $query->set('meta_key', '_evento_data');
        $query->set('orderby', 'meta_value');
        $query->set('order', 'ASC');
    }
}
add_action('pre_get_posts', 'piccolo_coro_event_archive_order');

function piccolo_coro_excerpt_length() { return 24; }
add_filter('excerpt_length', 'piccolo_coro_excerpt_length');
