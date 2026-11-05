<?php
/**
 * Template Name: Distribuidoras KOFF
 *
 * Página "Distribuidoras" do festival KOFF. 100% código, sem
 * Elementor. Reaproveita a estrutura do Distribuidoras.html (enviado
 * pelo designer) e a estética já usada nas demais páginas internas:
 * classes .pagehero, .wrap, .crumbs, .eyebrow, .lead, .section
 * (koff.css) e .mural-section, .mural-label, .logo-grid, .logo-tile
 * (bloco portado pro koff.css a partir do .html de referência), sem
 * redefinir nada localmente.
 *
 * Fonte dos dados: array PHP estático abaixo (sem CPT dedicado ainda).
 * Imagens já sobem pela Biblioteca de Mídia do WP, em
 * wp-content/uploads/2026/08/ — resolvidas via koff_logo_url()
 * (functions.php).
 *
 * Renderização dos grupos: koff_render_mural_section() em
 * functions.php (compartilhada com Apoiadores, Parceiros e Realização).
 *
 * Observação: o logo "15logos-17.png" (grupo Coreia do Sul) veio sem
 * nome de empresa identificável no arquivo — mantido com alt genérico
 * "Distribuidora", igual ao que já estava no Distribuidoras.html do
 * designer (dist-kr-15logos-17.png, alt="Distribuidora").
 */

get_header();

$koff_dist_brasil = [
    [ 'src' => '2026/08/1DiamondFilms.png',    'alt' => 'Diamond Films' ],
    [ 'src' => '2026/08/2ParisFilmes.png',     'alt' => 'Paris Filmes' ],
    [ 'src' => '2026/08/3CaliforniaFilmes.png','alt' => 'California Filmes' ],
    [ 'src' => '2026/08/4Sato.png',            'alt' => 'Sato' ],
    [ 'src' => '2026/08/5MaresFilmes.png',     'alt' => 'Mares Filmes' ],
];

$koff_dist_latam = [
    [ 'src' => '2026/08/1Canibal.png',       'alt' => 'Canibal' ],
    [ 'src' => '2026/08/2bfDistribution.png','alt' => 'BF Distribution' ],
    [ 'src' => '2026/08/3C.png',             'alt' => 'C' ],
    [ 'src' => '2026/08/4ImpactoCine.png',   'alt' => 'Impacto Cine' ],
];

$koff_dist_coreia = [
    [ 'src' => '2026/08/1CJ.png',               'alt' => 'CJ' ],
    [ 'src' => '2026/08/2Finecut.png',          'alt' => 'Finecut' ],
    [ 'src' => '2026/08/3Funnycon.png',         'alt' => 'Funnycon' ],
    [ 'src' => '2026/08/4Lotte.png',            'alt' => 'Lotte' ],
    [ 'src' => '2026/08/5Newcontentspanda.png', 'alt' => 'New Contents Panda' ],
    [ 'src' => '2026/08/6Megabox.png',          'alt' => 'Megabox' ],
    [ 'src' => '2026/08/7Aniseed.png',          'alt' => 'Aniseed' ],
    [ 'src' => '2026/08/8Centralpark.png',      'alt' => 'Central Park' ],
    [ 'src' => '2026/08/9Filmdabin.png',        'alt' => 'Filmdabin' ],
    [ 'src' => '2026/08/10PlusM.png',           'alt' => 'Plus M' ],
    [ 'src' => '2026/08/11M-Line.png',          'alt' => 'M-Line' ],
    [ 'src' => '2026/08/12Showbox.png',         'alt' => 'Showbox' ],
    [ 'src' => '2026/08/13Indiestory.png',      'alt' => 'Indiestory' ],
    [ 'src' => '2026/08/14Barunson.png',        'alt' => 'Barunson' ],
    [ 'src' => '2026/08/15logos-17.png',        'alt' => 'Distribuidora' ],
    [ 'src' => '2026/08/16Postfin.png',         'alt' => 'Postfin' ],
    [ 'src' => '2026/08/17ktstudiogenie.png',   'alt' => 'KT Studio Genie' ],
];
?>

<section class="pagehero">
    <div class="wrap">
        <nav class="crumbs">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Início</a><span class="sep">/</span><span>Distribuidoras</span>
        </nav>
        <p class="eyebrow">O Festival</p>
        <h1>Distribuidoras</h1>
        <p class="lead">Distribuidoras parceiras que levam o cinema sul-coreano ao Brasil e ao mundo.</p>
    </div>
</section>

<section class="section">
    <div class="wrap">
        <?php
        echo koff_render_mural_section( 'Brasil', $koff_dist_brasil );
        echo koff_render_mural_section( 'América Latina', $koff_dist_latam );
        echo koff_render_mural_section( 'Coreia do Sul', $koff_dist_coreia );
        ?>
    </div>
</section>

<?php get_footer(); ?>
