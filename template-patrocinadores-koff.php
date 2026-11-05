<?php
/**
 * Template Name: Patrocinadores KOFF
 *
 * Página "Patrocinadores" do festival KOFF. Substitui a versão atual
 * feita no Elementor (export lido em
 * elementor-9563-2026-08-03-patrocinadores.json) por código 100% PHP,
 * seguindo o mesmo padrão das outras páginas do tema.
 *
 * Decisões tomadas com o usuário:
 * - Breadcrumb/eyebrow/h1/lead mantêm o texto que já está publicado
 *   no Elementor ("Início / Patrocinadores", eyebrow "Quem patrocina
 *   o festival"), e NÃO o texto do Patrocinadores.html do designer
 *   (que tinha um nível a mais de crumb, "O Festival"). Só a
 *   estrutura/classes vêm do .html (.pagehero, .wrap, .crumbs,
 *   .eyebrow, .lead).
 * - Os textos institucionais de cada patrocinador são os textos reais
 *   já publicados (bem mais longos que o placeholder do .html) — por
 *   isso .sponsor-card foi ajustado no koff.css pra crescer em altura
 *   livremente, sem cortar texto.
 * - Logos já existentes na Biblioteca de Mídia (não precisou reupload):
 *   CJ_BIO_Horizontal_White.png, hyundai-logo.png, glovis-logo.png,
 *   atomy-seeklogo.png — URLs resolvidas via koff_logo_url()
 *   (functions.php).
 *
 * Reaproveita classes .pagehero, .wrap, .crumbs, .eyebrow, .lead,
 * .section (koff.css) e .sponsor-grid, .sponsor-card, .sponsor-logo,
 * .sponsor-divider, .sponsor-name, .sponsor-desc (bloco portado pro
 * koff.css a partir do Patrocinadores.html), sem redefinir nada
 * localmente.
 *
 * Fonte dos dados: array PHP estático abaixo (sem CPT dedicado ainda).
 * Texto institucional é rich text fixo — escapado com wp_kses_post()
 * (permite <p>, <strong> etc.), não esc_html().
 */

get_header();

$koff_patrocinadores = [
    [
        'logo_src' => '2026/07/CJ_BIO_Horizontal_White.png',
        'nome'     => 'CJ BIO',
        'texto'    => '<p>A CJ BIO, empresa do Grupo CJ, leva ao mundo o melhor da cultura coreana e de suas inovações por meio de negócios em Biotecnologia, Alimentos, Logística, Infraestrutura, Entretenimento e Mídia.</p>
<p>Como uma das protagonistas da Korean Wave (Hallyu), o Grupo CJ está por trás de grandes produções do cinema coreano, como Parasita (KOFF 2023), Past Lives (KOFF 2024) e Harbin (KOFF 2025).</p>
<p>Na América do Sul, somos a CJ do Brasil, referência em biotecnologia sustentável e líderes na produção de aminoácidos e soluções para nutrição animal e vegetal.</p>
<p>Temos orgulho de apoiar o Festival de Cinema Coreano - KOFF, fortalecendo os laços entre Brasil e Coreia do Sul por meio da cultura e da conexão entre pessoas.</p>
<p>KOFF - Korean Film Festival agradece o importante patrocínio da CJ BIO para a realização do Circuito Nacional 2026, que exibirá o melhor da recente cinematografia sul-coreana para diferentes regiões do Brasil.</p>',
    ],
    [
        'logo_src' => '2024/10/hyundai-logo.png',
        'nome'     => 'Hyundai Motor Brasil',
        'texto'    => '<p>A Hyundai Motor Brasil apresenta a 4ª edição do Festival de Cinema Coreano - KOFF, o maior evento dedicado ao cinema sul-coreano na América Latina!</p>
<p>Celebrando a cultura da Coreia do Sul por meio de suas produções cinematográficas internacionalmente reconhecidas e apresentando uma programação que percorre sete cidades brasileiras e reúne mais de 100 títulos, o festival reafirma o compromisso da marca com o intercâmbio cultural entre o Brasil e seu país de origem, uma parceria que vai além da indústria e se expressa também pela arte.</p>
<p>De Piracicaba para o Brasil, assim como o início da produção do Novo Hyundai i20, que chegou para mudar o jogo, o KOFF parte da nossa cidade e percorre o país levando cultura, emoção e as melhores histórias da Coreia do Sul para cada tela.</p>
<p>Mais de 100 filmes. Sete cidades. Uma só paixão pelo cinema!</p>
<p>Cultura, inovação e conexão entre países. Agradecemos à Hyundai Motor Brasil por acompanhar e apoiar a trajetória do Korean Film Festival – KOFF desde a sua primeira edição, apresentando o melhor da produção cinematográfica sul-coreana!</p>',
    ],
    [
        'logo_src' => '2024/10/glovis-logo.png',
        'nome'     => 'Glovis',
        'texto'    => '<p>A Cultura conecta mundos e a GLOVIS acredita nisso.</p>
<p>Com origem na Coreia do Sul, a GLOVIS é líder global em logística e atua no Brasil com soluções completas que vão muito além do transporte: conectamos pessoas, negócios e oportunidades.</p>
<p>É por isso que temos orgulho de apoiar o Festival de Cinema Coreano - KOFF, uma iniciativa que aproxima culturas, compartilha histórias e inspira novas perspectivas.</p>
<p>Porque acreditamos que o Cinema tem o poder de criar pontes.</p>
<p>Vem viver essa experiência com a gente!</p>
<p>Agradecemos à GLOVIS pela confiança e parceria contínua com o Korean Film Festival - KOFF. Presente desde a primeira edição do Festival, a empresa segue ao nosso lado em 2026, contribuindo para que o cinema sul-coreano alcance públicos de diferentes regiões do Brasil.</p>',
    ],
    [
        'logo_src' => '2024/10/4atomy_branco.png',
        'nome'     => 'Atomy',
        'texto'    => '<p>Fundada em 2009, a Atomy é uma empresa de marketing de rede que realiza vendas diretas em 20 regiões diferentes, incluindo a Coreia do Sul (dezembro de 2022 até o presente).</p>
<p>Estamos crescendo a um ritmo acelerado, implementando uma estratégia orientada ao consumidor que adere aos princípios de Qualidade Absoluta, Preço Absoluto estabelecidos pelo nosso Presidente Fundador Han-Gill Park.</p>
<p>Estamos também solidificando a base para o crescimento sustentável, concentrando-nos em nossa meta visionária de sucesso do cliente e promovendo três culturas corporativas fundamentais: observar os princípios, crescer juntos e compartilhar.</p>
<p>Atomy do Brasil patrocina o Festival de Cinema Coreano - KOFF!</p>
<p>Nosso agradecimento à Atomy do Brasil pelo importante apoio na realização do KOFF 2026!</p>',
    ],
];
?>

<section class="pagehero">
    <div class="wrap">
        <nav class="crumbs">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Início</a><span class="sep">/</span><span>Patrocinadores</span>
        </nav>
        <p class="eyebrow">Quem patrocina o festival</p>
        <h1>Patrocinadores</h1>
        <p class="lead">O KOFF é realizado com o patrocínio de instituições e marcas que acreditam no poder do cinema como ponte entre culturas.</p>
    </div>
</section>

<section class="section">
    <div class="wrap">
        <div class="sponsor-grid">
            <?php foreach ( $koff_patrocinadores as $koff_sponsor ) : ?>
                <div class="sponsor-card">
                    <div class="sponsor-logo">
                        <img src="<?php echo esc_url( koff_logo_url( $koff_sponsor['logo_src'] ) ); ?>" alt="<?php echo esc_attr( $koff_sponsor['nome'] ); ?>" loading="lazy">
                    </div>
                    <hr class="sponsor-divider">
                    <div class="sponsor-name"><?php echo esc_html( $koff_sponsor['nome'] ); ?></div>
                    <div class="sponsor-desc"><?php echo wp_kses_post( $koff_sponsor['texto'] ); ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
