<?php
/**
 * Template Name: Home KOFF
 *
 * Home do festival KOFF. 100% código, sem Elementor. Construída a partir
 * do prompt-pagina-home.md, seguindo o Home.html anexado como referência
 * visual (não editado).
 *
 * Classes reaproveitadas do koff.css já existente: .wrap, .section,
 * .section-head, .prose, .grid.g-3, .btn.btn-gold, .newsletter,
 * .home-hero-banner, .home-about*, .feat-card, .home-highlights-grid,
 * .hi-card*, .hi-title*, .hi-sub*, .hi-badge (as 6 últimas classes foram
 * portadas do Home.html pra este mesmo commit, ver koff.css).
 *
 * Fonte dos dados, por seção:
 * 1. Menu/rodapé — get_header()/get_footer() (Elementor Theme Builder).
 * 2. Banner full-width — imagem estática da Biblioteca de Mídia, via
 *    koff_logo_url() (sem domínio hardcoded).
 * 3. Carrossel de filmes — array PHP estático (9 filmes), com
 *    image/link resolvidos dinamicamente via koff_logo_url()/home_url()
 *    a partir do array original enviado pelo dono do site. CSS/JS do
 *    widget são os enviados na conversa, copiados sem alteração de
 *    lógica (só o array `movies` é gerado via PHP).
 * 4. Sobre o Festival — imagem + texto fixo (fornecidos pelo dono do
 *    site) + link para /the-festival/ via home_url().
 * 5. Grid de 6 seções — array PHP estático, com os ícones SVG reais
 *    copiados da home de produção (koffko.com.br), não os desenhados à
 *    mão do Home.html. 3 dos 6 cards têm link (home_url()), 3 não têm
 *    link ainda (renderizados como <div>, sem <a>).
 * 6. Notícias — WP_Query nos 3 posts nativos mais recentes da categoria
 *    "Notícias" (slug assumido "noticias" — confirmar no wp-admin).
 * 7. Formulário de contato — envia e-mail via wp_mail() nativo
 *    (functions.php, bloco 7: koff_ajax_home_contato), sem plugin nem
 *    Elementor Form, pro endereço contato@koffko.com.br.
 *
 * ATENÇÃO DEPLOY: os slugs de "Mostra Competitiva" e "Mostra Não
 * Competitiva" usados no grid (seção 5) são os de AMBIENTE LOCAL.
 * Em produção, trocar para:
 *   Mostra Competitiva:      /mostra-competitiva1/
 *   Mostra Não Competitiva:  /mostra-nao-competitiva/
 * (Busca de Filmes é igual nos dois ambientes, não precisa trocar.)
 * Ver prompt-pagina-home.md para mais detalhes desse ajuste manual.
 *
 * Seções do Home.html que NÃO entram nesta página (por decisão
 * explícita do dono do site): o bloco .hero-top com título "KOFF
 * Brazil" sobreposto, e a régua de patrocinadores/realização
 * (.sponsors-section).
 */

get_header();

/* -----------------------------------------------------------
   Seção 2 — Banner full-width
----------------------------------------------------------- */
$koff_home_hero_img = koff_logo_url( '2026/08/tela_escolhida_koff-scaled.png' );

/* -----------------------------------------------------------
   Seção 3 — Carrossel de filmes (array estático, URLs dinâmicas)
----------------------------------------------------------- */
$koff_home_movies_raw = [
    [ 'id' => 1, 'title' => "The King's Warden (2025)",           'image' => '2026/07/1thekingswarden.jpg',          'link' => '/filmes/the-kings-warden/',        'imagePosition' => 'center 40%' ],
    [ 'id' => 2, 'title' => "Boss (2025)",                        'image' => '2026/07/boss-1-scaled.jpg',                'link' => '/filmes/boss/',        'imagePosition' => 'center 20%' ],
    [ 'id' => 3, 'title' => "Frosted Window (2025)",             'image' => '2026/07/frostedwindows-1.jpg',              'link' => '/filmes/frosted-window/',        'imagePosition' => 'center 20%' ],
    [ 'id' => 4, 'title' => "Funky Freaky Freaks (2025)",        'image' => '2026/07/funkyfreakyfreaks-1.jpg',           'link' => '/filmes/funky-freaky-freaks/',        'imagePosition' => 'center 20%' ],
    [ 'id' => 5, 'title' => "Little Dreamerz (2025)",            'image' => '2026/07/littledreamerz-1.jpg',              'link' => '/filmes/little-dreamerz/',        'imagePosition' => 'center 20%' ],
    [ 'id' => 6, 'title' => "No Other Choice (2025)",            'image' => '2026/07/nootherchoice_brilho-1-scaled.png',  'link' => '/filmes/no-other-choice/',    'imagePosition' => 'center 20%' ],
    [ 'id' => 7, 'title' => "Number One (2025)",                 'image' => '2026/07/numberone-2.png',                    'link' => '/filmes/number-one/',    'imagePosition' => 'center 20%' ],
    [ 'id' => 8, 'title' => 'Once We Were Us (2025)',             'image' => '2026/07/oncewewereus-1-1.png',               'link' => '/filmes/once-we-were-us/' ],
    [ 'id' => 9, 'title' => 'Tango at Dawn (2024)',              'image' => '2026/07/tangoatdawn-2.png',                  'link' => '/filmes/tango-at-dawn/' ],
    [ 'id' => 10, 'title' => 'Tell Me That You Love Me (2025)',    'image' => '2026/07/tellmethatyouloveme-1.jpg',       'link' => '/filmes/tell-me-that-you-love-me/' ],
    [ 'id' => 11, 'title' => 'The Ghost Game (2025)',             'image' => '2026/07/theghostgame-1.jpg',               'link' => '/filmes/the-ghost-game/' ],
    [ 'id' => 12, 'title' => 'The First Ride (2025)',                  'image' => '2026/07/thefirstride-1.jpg',              'link' => '/filmes/first-ride/' ],
    [ 'id' => 13, 'title' => 'The Mutation (2025)',                'image' => '2026/07/The-Mutation.jpg',                 'link' => '/filmes/the-mutation/',            'imagePosition' => 'center 30%' ],
    [ 'id' => 14, 'title' => 'The Only Child in the Butchery (2025)',  'image' => '2026/07/theonlychild-1.png',               'link' => '/filmes/the-only-child-in-the-butchery/',         'imagePosition' => 'center 30%' ],
    [ 'id' => 15, 'title' => 'The Square (2025)',                 'image' => '2026/07/The-Square.jpg',                       'link' => '/filmes/the-square/' ],
    [ 'id' => 16, 'title' => 'The Ugly (2025)',                 'image' => '2026/07/theugly-1.jpg',                       'link' => '/filmes/the-ugly/' ],
    [ 'id' => 17, 'title' => 'The World of Love',                  'image' => '2026/07/theworldoflove-1.jpg',              'link' => '/filmes/the-world-of-love/' ],    
    [ 'id' => 18, 'title' => 'Winter Light (2025)',                'image' => '2026/07/Winter-Light.jpg',                   'link' => '/filmes/winter-light/' ],    
];

$koff_home_movies_js = array_map( function ( $koff_movie ) {
    $koff_js_movie = [
        'id'    => $koff_movie['id'],
        'title' => $koff_movie['title'],
        'image' => koff_logo_url( $koff_movie['image'] ),
        'link'  => home_url( $koff_movie['link'] ),
    ];
    if ( ! empty( $koff_movie['imagePosition'] ) ) {
        $koff_js_movie['imagePosition'] = $koff_movie['imagePosition'];
    }
    return $koff_js_movie;
}, $koff_home_movies_raw );

/* -----------------------------------------------------------
   Seção 4 — Sobre o Festival
----------------------------------------------------------- */
$koff_home_about_img = koff_logo_url( '2026/07/Home.jpeg' );

/* -----------------------------------------------------------
   Seção 5 — Grid de 6 seções (ícones reais da home de produção)
----------------------------------------------------------- */
$koff_home_cards = [
    [
        'label' => 'Mostra Competitiva',
        'desc'  => 'Acesso total às exibições e eventos exclusivos.',
        'svg'   => '<svg aria-hidden="true" class="e-font-icon-svg e-fas-ticket-alt" viewBox="0 0 576 512" xmlns="http://www.w3.org/2000/svg" width="30" height="30"><path fill="currentColor" d="M128 160h320v192H128V160zm400 96c0 26.51 21.49 48 48 48v96c0 26.51-21.49 48-48 48H48c-26.51 0-48-21.49-48-48v-96c26.51 0 48-21.49 48-48s-21.49-48-48-48v-96c0-26.51 21.49-48 48-48h480c26.51 0 48 21.49 48 48v96c-26.51 0-48 21.49-48 48zm-48-104c0-13.255-10.745-24-24-24H120c-13.255 0-24 10.745-24 24v208c0 13.255 10.745 24 24 24h336c13.255 0 24-10.745 24-24V152z"></path></svg>',
     
        'url'   => home_url( '/mostra-competitiva1/' ),
    ],
    [
        'label' => 'Mostra Não Competitiva',
        'desc'  => 'Explore nossas mostras competitivas e retrospectivas.',
        'svg'   => '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none"><path d="M15 30C14.175 30 13.4688 29.7062 12.8813 29.1187C12.2938 28.5312 12 27.825 12 27V15C12 14.175 12.2938 13.4688 12.8813 12.8813C13.4688 12.2938 14.175 12 15 12H27C27.825 12 28.5312 12.2938 29.1187 12.8813C29.7062 13.4688 30 14.175 30 15V27C30 27.825 29.7062 28.5312 29.1187 29.1187C28.5312 29.7062 27.825 30 27 30H15ZM15 27H27V15H15V27ZM6 24V9C6 8.175 6.29375 7.46875 6.88125 6.88125C7.46875 6.29375 8.175 6 9 6H24V9H9V24H6ZM0 18V3C0 2.175 0.29375 1.46875 0.88125 0.88125C1.46875 0.29375 2.175 0 3 0H18V3H3V18H0ZM15 27V15V27Z" fill="currentColor"></path></svg>',
       
        'url'   => home_url( '/mostra-nao-competitiva/' ),
    ],
    [
        'label' => 'Busca de Filmes',
        'desc'  => 'Encontre o seu próximo filme favorito por gênero ou diretor.',
        'svg'   => '<svg aria-hidden="true" class="e-font-icon-svg e-fas-search" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" width="30" height="30"><path fill="currentColor" d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"></path></svg>',
        'url'   => home_url( '/busca-filmes/' ),
    ],
    [
        'label' => 'Premiação',
        'desc'  => 'As joias escondidas selecionadas pelos nossos especialistas.',
        'svg'   => '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none"><path d="M9 24L15 19.425L21 24L18.75 16.575L24.75 12.3H17.4L15 4.5L12.6 12.3H5.25L11.25 16.575L9 24ZM15 30C12.925 30 10.975 29.6063 9.15 28.8188C7.325 28.0312 5.7375 26.9625 4.3875 25.6125C3.0375 24.2625 1.96875 22.675 1.18125 20.85C0.39375 19.025 0 17.075 0 15C0 12.925 0.39375 10.975 1.18125 9.15C1.96875 7.325 3.0375 5.7375 4.3875 4.3875C5.7375 3.0375 7.325 1.96875 9.15 1.18125C10.975 0.39375 12.925 0 15 0C17.075 0 19.025 0.39375 20.85 1.18125C22.675 1.96875 24.2625 3.0375 25.6125 4.3875C26.9625 5.7375 28.0312 7.325 28.8188 9.15C29.6063 10.975 30 12.925 30 15C30 17.075 29.6063 19.025 28.8188 20.85C28.0312 22.675 26.9625 24.2625 25.6125 25.6125C24.2625 26.9625 22.675 28.0312 20.85 28.8188C19.025 29.6063 17.075 30 15 30ZM15 27C18.35 27 21.1875 25.8375 23.5125 23.5125C25.8375 21.1875 27 18.35 27 15C27 11.65 25.8375 8.8125 23.5125 6.4875C21.1875 4.1625 18.35 3 15 3C11.65 3 8.8125 4.1625 6.4875 6.4875C4.1625 8.8125 3 11.65 3 15C3 18.35 4.1625 21.1875 6.4875 23.5125C8.8125 25.8375 11.65 27 15 27Z" fill="#BAB8B7"></path></svg>',
        'url'   => '',
    ],
    [
        'label' => 'Eventos',
        'desc'  => 'Festas, painéis e sessões de perguntas e respostas.',
        'svg'   => '<svg aria-hidden="true" class="e-font-icon-svg e-fas-calendar-day" viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg" width="30" height="30"><path fill="currentColor" d="M0 464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V192H0v272zm64-192c0-8.8 7.2-16 16-16h96c8.8 0 16 7.2 16 16v96c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16v-96zM400 64h-48V16c0-8.8-7.2-16-16-16h-32c-8.8 0-16 7.2-16 16v48H160V16c0-8.8-7.2-16-16-16h-32c-8.8 0-16 7.2-16 16v48H48C21.5 64 0 85.5 0 112v48h448v-48c0-26.5-21.5-48-48-48z"></path></svg>',
        'url'   => '',
    ],
    [
        'label' => 'Como Festejar',
        'desc'  => 'Dicas essenciais para aproveitar o festival ao máximo.',
        'svg'   => '<svg xmlns="http://www.w3.org/2000/svg" width="33" height="31" viewBox="0 0 33 31" fill="none"><path d="M0 30.75L7.5 9.75L21 23.25L0 30.75ZM4.95 25.8L15.525 22.05L8.7 15.225L4.95 25.8ZM18.825 16.575L17.25 15L25.65 6.6C26.45 5.8 27.4125 5.4 28.5375 5.4C29.6625 5.4 30.625 5.8 31.425 6.6L32.325 7.5L30.75 9.075L29.85 8.175C29.5 7.825 29.0625 7.65 28.5375 7.65C28.0125 7.65 27.575 7.825 27.225 8.175L18.825 16.575ZM12.825 10.575L11.25 9L12.15 8.1C12.5 7.75 12.675 7.325 12.675 6.825C12.675 6.325 12.5 5.9 12.15 5.55L11.175 4.575L12.75 3L13.725 3.975C14.525 4.775 14.925 5.725 14.925 6.825C14.925 7.925 14.525 8.875 13.725 9.675L12.825 10.575ZM15.825 13.575L14.25 12L19.65 6.6C20 6.25 20.175 5.8125 20.175 5.2875C20.175 4.7625 20 4.325 19.65 3.975L17.25 1.575L18.825 0L21.225 2.4C22.025 3.2 22.425 4.1625 22.425 5.2875C22.425 6.4125 22.025 7.375 21.225 8.175L15.825 13.575ZM21.825 19.575L20.25 18L22.65 15.6C23.45 14.8 24.4125 14.4 25.5375 14.4C26.6625 14.4 27.625 14.8 28.425 15.6L30.825 18L29.25 19.575L26.85 17.175C26.5 16.825 26.0625 16.65 25.5375 16.65C25.0125 16.65 24.575 16.825 24.225 17.175L21.825 19.575Z" fill="currentColor"></path></svg>',
        'url'   => '',
    ],
];

/* -----------------------------------------------------------
   Seção 6 — Notícias (3 posts mais recentes da categoria "Notícias")
   Slug assumido "noticias" (acentos removidos, padrão WordPress) —
   confirmar no wp-admin (Posts → Categorias) antes de considerar
   pronto. Se a query voltar vazia, é o primeiro lugar a checar.
----------------------------------------------------------- */
$koff_home_noticias_query = new WP_Query( [
    'post_type'              => 'post',
    'post_status'             => 'publish',
    'category_name'           => 'noticias',
    'posts_per_page'          => 3,
    'orderby'                 => 'date',
    'order'                   => 'DESC',
    'update_post_term_cache'  => false,
] );
$koff_home_noticias_posts = $koff_home_noticias_query->posts;

/**
 * Resumo curto pra card de notícia: usa o excerpt manual se existir,
 * senão gera a partir do conteúdo (evita depender de get_the_excerpt()
 * fora do Loop principal).
 */
function koff_home_resumo_post( $koff_post, $koff_num_palavras ) {
    if ( has_excerpt( $koff_post ) ) {
        return wp_trim_words( get_the_excerpt( $koff_post ), $koff_num_palavras );
    }
    return wp_trim_words( wp_strip_all_tags( $koff_post->post_content ), $koff_num_palavras );
}

/* -----------------------------------------------------------
   Seção 7 — Formulário de contato (nonce pro AJAX no rodapé do arquivo)
----------------------------------------------------------- */
$koff_home_contato_ajax_url = admin_url( 'admin-ajax.php' );
$koff_home_contato_nonce    = wp_create_nonce( KOFF_HOME_CONTATO_NONCE_ACTION );
?>

<!-- ===== Seção 2 — Banner full-width ===== -->
<img class="home-hero-banner" src="<?php echo esc_url( $koff_home_hero_img ); ?>" alt="">

<!-- ===== Seção 3 — Carrossel de filmes ===== -->
<style>
  /* Variáveis de Configuração */
  :root {
    --carousel-transition-speed: 0.8s;
    --carousel-interval: 5000;
    --brand-color: #252525;      /* Borda */
    --hover-color: #e3c426;      /* Overlay do hover */
    --border-width: 1pt;
  }
  /* Reset para WordPress/Elementor */
  .elementor-widget-html .carousel-container {
    line-height: normal;
  }
  .carousel-container {
    position: relative;
    width: 100vw;
    left: 50%;
    right: 50%;
    margin-left: -50vw;
    margin-right: -50vw;
    overflow: hidden;
    padding: 0;
    font-family: "Helvetica Neue LT Pro", Helvetica, Arial, sans-serif;
    box-sizing: border-box;
    background-color: #000;
  }
  .carousel-track-container {
    overflow: hidden;
    width: 100%;
  }
  .carousel-track {
    display: flex;
    transition: transform var(--carousel-transition-speed) ease-in-out;
    gap: 0;
    margin: 0;
    padding: 0;
  }
  .carousel-slide {
    flex: 0 0 calc(100% / 3);
    box-sizing: border-box;
    list-style: none;
  }
  .image-wrapper {
    position: relative;
    width: 100%;
    padding-top: 75%;
    background-color: #111;
    overflow: hidden;
    border: var(--border-width) solid var(--brand-color);
    box-sizing: border-box;
  }
  .image-wrapper img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    border: none;
  }
  /* Overlay de Título */
  .overlay {
    position: absolute;
    top: -100%;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: var(--hover-color);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: top 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 2;
  }
  .image-wrapper:hover .overlay {
    top: 0;
  }
  .movie-title {
    color: #000;
    font-family: "Helvetica Neue LT Pro", Helvetica, Arial, sans-serif;
    font-stretch: condensed;
    font-weight: 700;
    text-transform: uppercase;
    font-size: clamp(0.85rem, 1.6vw, 1.5rem);
    text-align: center;
    padding: 0 15px;
    opacity: 0;
    transition: opacity 0.3s ease 0.2s;
    margin: 0;
    line-height: 1.1;
  }
  .image-wrapper:hover .movie-title {
    opacity: 1;
  }
  /* Botões de Navegação */
  .nav-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: #ffffff;
    border: none;
    width: 50px;
    height: 120px;
    cursor: pointer;
    z-index: 10;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0;
    transition: background 0.3s ease;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
  }
  .nav-btn:hover {
    background: var(--brand-color);
  }
  .nav-btn::before {
    content: "";
    display: inline-block;
    border-top: 5px solid #000;
    border-right: 5px solid #000;
    width: 15px;
    height: 15px;
  }
  .prev {
    left: 0;
  }
  .prev::before {
    transform: rotate(-135deg);
    margin-left: 8px;
  }
  .next {
    right: 0;
  }
  .next::before {
    transform: rotate(45deg);
    margin-right: 8px;
  }
  /* Responsividade Mobile */
  @media (max-width: 768px) {
    .carousel-slide {
      flex: 0 0 100%;
    }
    .nav-btn {
      height: 80px;
      width: 35px;
    }
    .carousel-container {
      width: 100%;
      left: 0;
      right: 0;
      margin-left: 0;
      margin-right: 0;
    }
    .movie-title {
      font-size: 1.2rem;
    }
  }
</style>
<div class="carousel-container">
  <button class="nav-btn prev" id="prevBtn" aria-label="Anterior"></button>
  <div class="carousel-track-container">
    <div class="carousel-track" id="track"></div>
  </div>
  <button class="nav-btn next" id="nextBtn" aria-label="Próximo"></button>
</div>
<script>
  (function () {
    // Array gerado em PHP a partir dos filmes cadastrados (ver
    // $koff_home_movies_raw acima) — image/link já resolvidos
    // dinamicamente via koff_logo_url()/home_url(), sem domínio fixo.
    const movies = <?php echo wp_json_encode( array_values( $koff_home_movies_js ) ); ?>;

    const track = document.getElementById("track");
    const prevBtn = document.getElementById("prevBtn");
    const nextBtn = document.getElementById("nextBtn");
    let currentIndex = 0;
    let autoPlay;
    // Se a imagem falhar ao carregar, esconde o <img> (mantém o fundo escuro do card)
    // em vez de mostrar o ícone de imagem quebrada.
    window.handleImageError = function (img) {
      img.style.display = "none";
    };
    function initSlides() {
      track.innerHTML = "";
      movies.forEach((movie) => {
        const slide = document.createElement("div");
        slide.className = "carousel-slide";
        const imgTag = movie.image
          ? `<img src="${movie.image}" alt="${movie.title}" loading="lazy" style="object-position: ${movie.imagePosition || "center"};" onerror="handleImageError(this)">`
          : "";
        slide.innerHTML = `
                <a href="${movie.link}" style="text-decoration: none;">
                    <div class="image-wrapper">
                        ${imgTag}
                        <div class="overlay">
                            <p class="movie-title">${movie.title}</p>
                        </div>
                    </div>
                </a>
            `;
        track.appendChild(slide);
      });
    }
    function getItemsToShow() {
      return window.innerWidth > 768 ? 3 : 1;
    }
    function updateCarousel() {
      const slides = track.querySelectorAll(".carousel-slide");
      if (slides.length === 0) return;
      const slideWidth = slides[0].offsetWidth;
      track.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
    }
    function nextSlide() {
      const itemsToShow = getItemsToShow();
      if (currentIndex < movies.length - itemsToShow) {
        currentIndex++;
      } else {
        currentIndex = 0;
      }
      updateCarousel();
    }
    function prevSlide() {
      const itemsToShow = getItemsToShow();
      if (currentIndex > 0) {
        currentIndex--;
      } else {
        currentIndex = movies.length - itemsToShow;
      }
      updateCarousel();
    }
    function startAutoPlay() {
      stopAutoPlay();
      autoPlay = setInterval(nextSlide, 5000);
    }
    function stopAutoPlay() {
      clearInterval(autoPlay);
    }
    nextBtn.addEventListener("click", () => {
      stopAutoPlay();
      nextSlide();
      startAutoPlay();
    });
    prevBtn.addEventListener("click", () => {
      stopAutoPlay();
      prevSlide();
      startAutoPlay();
    });
    const init = () => {
      initSlides();
      setTimeout(() => {
        updateCarousel();
        startAutoPlay();
      }, 300);
    };
    if (document.readyState === "complete") {
      init();
    } else {
      window.addEventListener("load", init);
    }
    window.addEventListener("resize", () => {
      const itemsToShow = getItemsToShow();
      if (currentIndex > movies.length - itemsToShow) {
        currentIndex = Math.max(0, movies.length - itemsToShow);
      }
      updateCarousel();
    });
  })();
</script>

<!-- ===== Seção 4 — Sobre o Festival ===== -->
<section class="section">
  <div class="wrap home-about">
    <div class="home-about-img">
      <img src="<?php echo esc_url( $koff_home_about_img ); ?>" alt="Sobre o Festival KOFF" loading="lazy">
    </div>
    <div class="home-about-text">
      <h2 class="section-head">Sobre o Festival</h2>
      <div class="prose">
        <?php
        echo wp_kses_post(
            '<p>Festival de Cinema Coreano – KOFF traz ao Brasil os filmes sul-coreanos mais aclamados, além de produções independentes, exibindo longas e curtas-metragens em diversas cidades brasileiras. As exibições ocorrem em espaços públicos e salas de cinema sob a curadoria do cineasta, produtor e professor da ECA/USP, Prof. Dr. Rubens Rewald.</p>
            <p>O programa do festival inclui uma Mostra Não Competitiva e uma Mostra Competitiva com inscrições abertas para filmes da Coreia do Sul e do Brasil, em duas categorias.</p>'
        );
        ?>
      </div>
      <a class="link-gold" href="<?php echo esc_url( home_url( '/the-festival/' ) ); ?>">
        Descubra nossa história
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </a>
    </div>
  </div>
</section>

<!-- ===== Seção 5 — Grid de 6 seções ===== -->
<section class="section">
  <div class="wrap">
    <div class="grid g-3">
      <?php foreach ( $koff_home_cards as $koff_card ) : ?>
        <?php if ( $koff_card['url'] ) : ?>
          <a class="feat-card" href="<?php echo esc_url( $koff_card['url'] ); ?>">
            <div class="feat-icon"><?php echo $koff_card['svg']; /* markup SVG fixo, definido no array acima — não vem de input de usuário */ ?></div>
            <div>
              <h3><?php echo esc_html( $koff_card['label'] ); ?></h3>
              <p><?php echo esc_html( $koff_card['desc'] ); ?></p>
            </div>
          </a>
        <?php else : ?>
          <div class="feat-card">
            <div class="feat-icon"><?php echo $koff_card['svg']; ?></div>
            <div>
              <h3><?php echo esc_html( $koff_card['label'] ); ?></h3>
              <p><?php echo esc_html( $koff_card['desc'] ); ?></p>
            </div>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ===== Seção 6 — Notícias ===== -->
<?php if ( ! empty( $koff_home_noticias_posts ) ) : ?>
<section class="section">
  <div class="wrap">
    <h2 class="section-head" style="margin-bottom:24px">Notícias</h2>
    <div class="home-highlights-grid">
      <?php
      $koff_noticia_principal    = $koff_home_noticias_posts[0];
      $koff_noticias_secundarias = array_slice( $koff_home_noticias_posts, 1, 2 );
      $koff_thumb_principal      = get_the_post_thumbnail_url( $koff_noticia_principal, 'large' );
      ?>
      <a class="hi-card hi-card-main" href="<?php echo esc_url( get_permalink( $koff_noticia_principal ) ); ?>">
        <?php if ( $koff_thumb_principal ) : ?>
          <img src="<?php echo esc_url( $koff_thumb_principal ); ?>" alt="<?php echo esc_attr( get_the_title( $koff_noticia_principal ) ); ?>" loading="lazy">
        <?php endif; ?>
        <div class="hi-overlay">
          <!-- Etiqueta "Notícias" no lugar do "Próximo evento" fixo do Home.html
               (não fazia sentido pra post dinâmico) — confirmar com o dono do
               site se prefere outro texto ou remover a etiqueta. -->
          <span class="hi-badge">Notícias</span>
          <h3 class="hi-title"><?php echo esc_html( get_the_title( $koff_noticia_principal ) ); ?></h3>
          <p class="hi-sub"><?php echo esc_html( koff_home_resumo_post( $koff_noticia_principal, 24 ) ); ?></p>
        </div>
      </a>
      <div class="hi-right">
        <?php foreach ( $koff_noticias_secundarias as $koff_noticia ) :
            $koff_thumb = get_the_post_thumbnail_url( $koff_noticia, 'medium_large' );
        ?>
          <a class="hi-card hi-card-sm" href="<?php echo esc_url( get_permalink( $koff_noticia ) ); ?>">
            <?php if ( $koff_thumb ) : ?>
              <img src="<?php echo esc_url( $koff_thumb ); ?>" alt="<?php echo esc_attr( get_the_title( $koff_noticia ) ); ?>" loading="lazy">
            <?php endif; ?>
            <div class="hi-overlay">
              <h3 class="hi-title-sm"><?php echo esc_html( get_the_title( $koff_noticia ) ); ?></h3>
              <p class="hi-sub-sm"><?php echo esc_html( koff_home_resumo_post( $koff_noticia, 16 ) ); ?></p>
            </div>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ===== Seção 7 — Formulário de contato ===== -->
<section class="newsletter section" id="home-contato">
  <div class="wrap">
    <h2 class="section-head">Fique por dentro do KOFF</h2>
    <p>Receba novidades exclusivas sobre a programação, vendas antecipadas e convites para eventos VIP diretamente no seu e-mail.</p>
    <form id="koff-home-contato-form" autocomplete="off">
      <input type="email" name="email" id="koff-home-contato-email" placeholder="Seu melhor e-mail" required>
      <button type="submit" class="btn btn-gold">Inscrever-se</button>
    </form>
    <p class="ty" id="koff-home-contato-status" hidden></p>
  </div>
</section>
<script>
(function () {
  var form   = document.getElementById('koff-home-contato-form');
  var input  = document.getElementById('koff-home-contato-email');
  var status = document.getElementById('koff-home-contato-status');
  if (!form || !input || !status) return;

  var ajaxUrl = <?php echo wp_json_encode( $koff_home_contato_ajax_url ); ?>;
  var nonce   = <?php echo wp_json_encode( $koff_home_contato_nonce ); ?>;

  form.addEventListener('submit', function (e) {
    e.preventDefault();

    var body = new URLSearchParams();
    body.set('action', 'koff_home_contato');
    body.set('nonce', nonce);
    body.set('email', input.value.trim());

    status.hidden = true;
    status.textContent = '';

    fetch(ajaxUrl, {
      method: 'POST',
      credentials: 'same-origin',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: body.toString()
    })
      .then(function (r) { return r.json(); })
      .then(function (res) {
        status.hidden = false;
        if (res && res.success) {
          status.textContent = '✓ ' + (res.data && res.data.message ? res.data.message : 'Recebemos seu contato!');
          form.reset();
        } else {
          status.textContent = (res && res.data && res.data.message) ? res.data.message : 'Não foi possível enviar agora. Tente novamente.';
        }
      })
      .catch(function () {
        status.hidden = false;
        status.textContent = 'Não foi possível enviar agora. Tente novamente.';
      });
  });
})();
</script>

<?php get_footer(); ?>
