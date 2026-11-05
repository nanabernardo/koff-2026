<?php
/**
 * Template Name: Apoiadores KOFF
 *
 * Página "Apoiadores" do festival KOFF. 100% código, sem Elementor.
 * Reaproveita a estrutura do Apoiadores.html (enviado pelo designer)
 * e a estética já usada nas demais páginas internas: classes
 * .pagehero, .wrap, .crumbs, .eyebrow, .lead, .section (koff.css) e
 * .mural-section, .mural-label, .logo-grid, .logo-tile (bloco novo
 * portado pro koff.css a partir do .html de referência), sem
 * redefinir nada localmente.
 *
 * Fonte dos dados: array PHP estático abaixo (sem CPT dedicado ainda).
 * Imagens já sobem pela Biblioteca de Mídia do WP, em
 * wp-content/uploads/2026/08/ — resolvidas via koff_logo_url()
 * (functions.php), que usa wp_get_upload_dir() em vez de hardcodar
 * o domínio.
 *
 * Renderização dos grupos: koff_render_mural_section() em
 * functions.php (compartilhada com Distribuidoras, Parceiros e
 * Realização).
 */

get_header();

$koff_apoio = [
    [ 'src' => '2026/08/1Acipi.png',   'alt' => 'Acipi' ],
    [ 'src' => '2026/08/2Simespi.png', 'alt' => 'Simespi' ],
    [ 'src' => '2026/08/3Sicoob.png',  'alt' => 'Sicoob' ],
];

$koff_apoio_cultural = [
    [ 'src' => '2026/08/1Ispac.png',               'alt' => 'Ispac' ],
    [ 'src' => '2026/08/2CentroCulturalCoreano.png','alt' => 'Centro Cultural Coreano' ],
    [ 'src' => '2026/08/3KoreanFilmArchive.png',    'alt' => 'Korean Film Archive' ],
    [ 'src' => '2026/08/4KAFA.png',                 'alt' => 'KAFA' ],
];

$koff_apoio_institucional = [
    [ 'src' => '2026/08/Piracicaba_regua.png', 'alt' => 'Prefeitura de Piracicaba' ],
];
?>

<section class="pagehero">
    <div class="wrap">
        <nav class="crumbs">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Início</a><span class="sep">/</span><span>Apoiadores</span>
        </nav>
        <p class="eyebrow">Quem apoia O Festival</p>
        <h1>Apoiadores</h1>
        <p class="lead">Instituições e organizações que tornam o KOFF possível a cada edição.</p>
    </div>
</section>

<section class="section">
    <div class="wrap">
        <?php
        echo koff_render_mural_section( 'Apoio', $koff_apoio );
        echo koff_render_mural_section( 'Apoio Cultural', $koff_apoio_cultural );
        echo koff_render_mural_section( 'Apoio Institucional', $koff_apoio_institucional );
        ?>
    </div>
</section>

<?php get_footer(); ?>
