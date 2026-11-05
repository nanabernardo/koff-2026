<?php
/**
 * Template Name: Parceiros KOFF
 *
 * Página "Parceiros" do festival KOFF. 100% código, sem Elementor.
 * Reaproveita a estrutura do Parceiros.html (enviado pelo designer) e
 * a estética já usada nas demais páginas internas: classes .pagehero,
 * .wrap, .crumbs, .eyebrow, .lead, .section (koff.css) e
 * .mural-section, .mural-label, .logo-grid, .logo-tile (bloco portado
 * pro koff.css a partir do .html de referência), sem redefinir nada
 * localmente.
 *
 * Fonte dos dados: array PHP estático abaixo (sem CPT dedicado ainda).
 * Imagens já sobem pela Biblioteca de Mídia do WP, em
 * wp-content/uploads/2026/08/ — resolvidas via koff_logo_url()
 * (functions.php).
 *
 * Renderização dos grupos: koff_render_mural_section() em
 * functions.php (compartilhada com Apoiadores, Distribuidoras e
 * Realização).
 *
 * Observação: grupo "Assessoria de Imprensa" não existia no
 * Parceiros.html do designer — adicionado por decisão do usuário
 * (pasta de logos "10Assessoria de Imprensa", que não tinha página
 * própria nem se encaixava nas outras 4 categorias do submenu).
 */

get_header();

$koff_parceria_educacional = [
    [ 'src' => '2026/08/1thedaveschool.png', 'alt' => 'The Dave School' ],
    [ 'src' => '2026/08/2fumep.png',         'alt' => 'Fumep' ],
    [ 'src' => '2026/08/3pecege.png',        'alt' => 'Pecege' ],
];

$koff_parceria_midia = [
    [ 'src' => '2026/08/1engenhodanoticia.png',  'alt' => 'Engenho da Notícia' ],
    [ 'src' => '2026/08/2gazetapiracicabana.png','alt' => 'Gazeta Piracicabana' ],
    [ 'src' => '2026/08/3canaldepiracicaba.png', 'alt' => 'Canal de Piracicaba' ],
    [ 'src' => '2026/08/4jpjornal.png',          'alt' => 'JP Jornal' ],
    [ 'src' => '2026/08/5tribunapiracicabana.png','alt' => 'Tribuna Piracicabana' ],
    [ 'src' => '2026/08/6tvregiaopiracicaba.png','alt' => 'TV Região Piracicaba' ],
];

$koff_assessoria_imprensa = [
    [ 'src' => '2026/08/logo-sinny-10anos.png', 'alt' => 'Sinny — 10 anos' ],
];
?>

<section class="pagehero">
    <div class="wrap">
        <nav class="crumbs">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Início</a><span class="sep">/</span><span>Parceiros</span>
        </nav>
        <p class="eyebrow">O Festival</p>
        <h1>Parceiros</h1>
        <p class="lead">Organizações e instituições que fazem parte da rede do KOFF.</p>
    </div>
</section>

<section class="section">
    <div class="wrap">
        <?php
        echo koff_render_mural_section( 'Parceria Educacional', $koff_parceria_educacional );
        echo koff_render_mural_section( 'Parceria de Mídia', $koff_parceria_midia );
        echo koff_render_mural_section( 'Assessoria de Imprensa', $koff_assessoria_imprensa );
        ?>
    </div>
</section>

<?php get_footer(); ?>
