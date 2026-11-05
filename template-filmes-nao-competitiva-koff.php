<?php
/**
 * Template Name: Filmes - Mostra Não-Competitiva KOFF
 *
 * Página "Filmes - Mostra Não-Competitiva" do festival KOFF. 100%
 * código, sem Elementor. Cópia estrutural de
 * template-filmes-competitiva-koff.php (mudando só a query e os
 * textos do hero). Reaproveita a estética do koff.css / Filmes.html
 * (classes .pagehero, .wrap, .crumbs, .eyebrow, .lead, .section,
 * .filters, .pill, .grid.g-5, .card, .ph.ph-2x3, .tag, .btn.btn-ghost)
 * e os tokens de cor do koff.css (--gold, --card, --line, --line-2,
 * --fg-3, --bg-3), sem redefini-los — já são carregados globalmente
 * via koff_enqueue() em functions.php.
 *
 * Fonte dos dados: CPT "filmes" (JetEngine). A Mostra Não-Competitiva
 * é definida por exclusão: mostra filmes publicados com post_date
 * depois de 2026-07-02 00:00:00 e cujos 4 switches (status,
 * competitive, koffa, archived) estão todos "não marcados" (ausentes
 * OU 'false'), ordenados alfabeticamente pelo título.
 *
 * A query (koff_fmnc_query_args), o mapeamento do campo "type"
 * (koff_fmc_tipo_info) e a renderização do card do filme
 * (koff_fmc_render_card) vivem em functions.php — as duas últimas são
 * genéricas e reaproveitadas sem alteração da página de Mostra
 * Competitiva / busca.
 *
 * Todos os filmes são carregados numa query só (sem paginação nem
 * AJAX) e renderizados de uma vez no grid. O filtro
 * Todos/Longas/Curtas/Animação (koff-wp.js, wireFilters()) roda no
 * client-side sobre a lista completa — assim ele sempre enxerga todos
 * os filmes do tipo selecionado, não só os primeiros carregados.
 */

get_header();

$koff_fmnc_query      = new WP_Query( koff_fmnc_query_args() );
$koff_fmnc_ph_counter = 0;
?>

<section class="pagehero">
    <div class="wrap">
        <nav class="crumbs">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Início</a><span class="sep">/</span><span>Filmes Mostra Não-Competitiva</span>
        </nav>
        <p class="eyebrow">Edição 2026</p>
        <h1>Filmes - Mostra Não-Competitiva</h1>
        <p class="lead">Todos os filmes da mostra não-competitiva da 4ª edição do Koff</p>
    </div>
</section>

<section class="section">
    <div class="wrap">
        <div class="filters" data-filter-group data-filter-list="#koff-fmnc-grid">
            <button class="pill" data-filter="all" aria-pressed="true">Todos</button>
            <button class="pill" data-filter="longa" aria-pressed="false">Longas</button>
            <button class="pill" data-filter="curta" aria-pressed="false">Curtas</button>
            <button class="pill" data-filter="animacao" aria-pressed="false">Animação</button>
        </div>

        <div class="grid g-5" id="koff-fmnc-grid" style="margin-top:32px">
            <?php
            if ( $koff_fmnc_query->have_posts() ) {
                foreach ( $koff_fmnc_query->posts as $koff_fmnc_post ) {
                    echo koff_fmc_render_card( $koff_fmnc_post->ID, $koff_fmnc_ph_counter );
                }
            }
            wp_reset_postdata();
            ?>
        </div>
    </div>
</section>

<style>
/* Card do filme: dentro de .ph.ph-2x3 (aspect-ratio 2:3) vai o poster
   real via <img>, então neutraliza o padrão/rótulo do placeholder
   estático (.ph::after) só dentro desta grid. */
#koff-fmnc-grid .card .ph{display:block;background:var(--bg-3)}
#koff-fmnc-grid .card .ph::after{content:none}
#koff-fmnc-grid .card .ph img{width:100%;height:100%;object-fit:cover;display:block}

.koff-fmc-body{padding:14px}
.koff-fmc-body .tag{font-size:10px;padding:3px 8px}
.koff-fmc-title{
    font-family:var(--head);font-weight:500;text-transform:uppercase;
    font-size:15px;margin-top:9px;color:var(--fg);
}
.koff-fmc-direction{color:var(--fg-3);font-size:12.5px;margin-top:2px}
</style>

<?php get_footer(); ?>
