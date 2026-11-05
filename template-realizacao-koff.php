<?php
/**
 * Template Name: Realização KOFF
 *
 * Página nova "Realização" do festival KOFF — não existia .html do
 * designer pra essa categoria. Criada porque as pastas de logos
 * "11Produção", "12Realização" e "1Fomento" não se encaixavam nas 4
 * categorias existentes no submenu (Apoiadores, Distribuidoras,
 * Parceiros, Patrocinadores): Realização/Produção são as entidades
 * que organizam/produzem o festival (diferente de quem patrocina ou
 * apoia), e Fomento são os mecanismos de incentivo fiscal (Lei
 * Rouanet, PROAC), com crédito geralmente obrigatório.
 *
 * 100% código, sem Elementor. Reaproveita a mesma estética das outras
 * 4 páginas de logos novas: classes .pagehero, .wrap, .crumbs,
 * .eyebrow, .lead, .section (koff.css) e .mural-section, .mural-label,
 * .logo-grid, .logo-tile (bloco portado pro koff.css).
 *
 * Fonte dos dados: array PHP estático abaixo (sem CPT dedicado ainda).
 * Imagens já sobem pela Biblioteca de Mídia do WP, em
 * wp-content/uploads/2026/08/ — resolvidas via koff_logo_url()
 * (functions.php).
 *
 * Renderização dos grupos: koff_render_mural_section() em
 * functions.php (compartilhada com Apoiadores, Distribuidoras e
 * Parceiros).
 *
 * IMPORTANTE: esta página ainda não tem link no submenu "O Festival"
 * (que é montado no Elementor Theme Builder do header, fora do
 * escopo de código) — o usuário adiciona manualmente depois de
 * revisar a página.
 */

get_header();

$koff_realizacao = [
    [ 'src' => '2026/08/1alexafilmes.png',    'alt' => 'Alexa Filmes' ],
    [ 'src' => '2026/08/2tm.png',             'alt' => 'TM Comunicação e Cultura' ],
    [ 'src' => '2026/08/3five.png',           'alt' => '5 Five Comunicação e Cultura' ],
    [ 'src' => '2026/08/4governoSP.png',      'alt' => 'Governo do Estado de São Paulo' ],
    [ 'src' => '2026/08/5ministerioCultura.png','alt' => 'Ministério da Cultura' ],
];

$koff_producao = [
    [ 'src' => '2026/08/1Image.png', 'alt' => 'Image' ],
    [ 'src' => '2026/08/2adda.png',  'alt' => 'Adda' ],
    [ 'src' => '2026/08/3bada.png',  'alt' => 'BaDa' ],
];

$koff_incentivo = [
    [ 'src' => '2026/08/LeiRouanet.png', 'alt' => 'Lei Rouanet' ],
    [ 'src' => '2026/08/PROAC.png',      'alt' => 'PROAC' ],
];
?>

<section class="pagehero">
    <div class="wrap">
        <nav class="crumbs">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Início</a><span class="sep">/</span><span>Realização</span>
        </nav>
        <p class="eyebrow">O Festival</p>
        <h1>Realização</h1>
        <p class="lead">Entidades que produzem e viabilizam o KOFF a cada edição.</p>
    </div>
</section>

<section class="section">
    <div class="wrap">
        <?php
        echo koff_render_mural_section( 'Realização', $koff_realizacao );
        echo koff_render_mural_section( 'Produção', $koff_producao );
        echo koff_render_mural_section( 'Incentivo', $koff_incentivo );
        ?>
    </div>
</section>

<?php get_footer(); ?>
