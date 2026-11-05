<?php
/**
 * KOFF — Child theme functions
 * Herda do Hello Elementor. Não modifique o tema pai.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/* ---------------------------------------------------------------
   1. Enqueue: fontes Google + sistema visual KOFF
--------------------------------------------------------------- */
add_action( 'wp_enqueue_scripts', 'koff_enqueue', 20 );
function koff_enqueue() {

    // Herança do tema pai (hello-elementor)
    wp_enqueue_style(
        'hello-elementor-style',
        get_template_directory_uri() . '/style.css',
        [],
        wp_get_theme( 'hello-elementor' )->get( 'Version' )
    );

    // Fonte mono (JetBrains Mono — usada em elementos de código)
    wp_enqueue_style(
        'koff-fonts',
        'https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500&display=swap',
        [],
        null
    );

    // Sistema visual KOFF (variáveis CSS, componentes, responsivo)
    wp_enqueue_style(
        'koff-style',
        get_stylesheet_directory_uri() . '/assets/koff.css',
        [ 'koff-fonts' ],
        '1.4.0'
    );

    // Interações JS (tabs, filtros, seletor de cidade, mobile nav)
    wp_enqueue_script(
        'koff-js',
        get_stylesheet_directory_uri() . '/assets/koff-wp.js',
        [],
        '1.0.0',
        true // carrega no rodapé
    );
}

/* ---------------------------------------------------------------
   2. Suporte ao tema
--------------------------------------------------------------- */
add_action( 'after_setup_theme', 'koff_theme_support' );
function koff_theme_support() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'custom-logo' );
    add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ] );
}

/* ---------------------------------------------------------------
   3. Preconnect para Google Fonts (performance)
--------------------------------------------------------------- */
add_action( 'wp_head', 'koff_preconnect_fonts', 1 );
function koff_preconnect_fonts() {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
}

/* ---------------------------------------------------------------
   4. Archive de Posts — pula o primeiro post (já exibido no destaque)
      Afeta apenas a query principal (is_main_query).
      O Loop Grid do post em destaque usa query própria e não é afetado.
--------------------------------------------------------------- */
// add_action( 'pre_get_posts', function( $query ) {
//     if ( ! is_admin() && $query->is_home() && $query->is_main_query() ) {
//         $query->set( 'offset', 1 );
//     }
// });

// // Corrige a contagem de posts para a paginação não quebrar após o offset
// add_filter( 'found_posts', function( $found_posts, $query ) {
//     if ( ! is_admin() && $query->is_home() && $query->is_main_query() ) {
//         $found_posts--;
//     }
//     return $found_posts;
// }, 10, 2 );

/* ---------------------------------------------------------------
   5b. Logos institucionais (Apoiadores, Distribuidoras, Parceiros,
       Patrocinadores, Realização)
       Sem CPT dedicado ainda — cada template monta um array PHP
       estático com [ 'src' => ..., 'alt' => ... ] por logo e chama
       koff_render_mural_section() por grupo. Helper compartilhado
       aqui (não no template) porque é usado por 4 templates
       diferentes.

       koff_logo_url() resolve a URL a partir de wp_get_upload_dir(),
       em vez de hardcodar o domínio (diferente do padrão antigo de
       koff_fmc_placeholders() acima) — assim o mesmo código funciona
       em local e produção sem precisar trocar URL na cópia de deploy.
--------------------------------------------------------------- */

/**
 * Monta a URL de um arquivo dentro de wp-content/uploads a partir do
 * caminho relativo (ex.: '2026/08/1Acipi.png').
 */
function koff_logo_url( $relative_path ) {
    $u = wp_get_upload_dir();
    return trailingslashit( $u['baseurl'] ) . ltrim( $relative_path, '/' );
}

/**
 * Renderiza um grupo de logos no padrão "mural" (.mural-section >
 * .mural-label + .logo-grid > .logo-tile), usado em Apoiadores,
 * Distribuidoras, Parceiros e Realização.
 *
 * @param string $label Rótulo do grupo (ex.: "Apoio Cultural").
 * @param array  $logos Lista de ['src' => caminho relativo em uploads, 'alt' => nome da empresa].
 */
function koff_render_mural_section( $label, $logos ) {
    ob_start();
    ?>
    <div class="mural-section">
        <p class="mural-label"><?php echo esc_html( $label ); ?></p>
        <div class="logo-grid">
            <?php foreach ( $logos as $koff_logo ) : ?>
                <div class="logo-tile">
                    <img src="<?php echo esc_url( koff_logo_url( $koff_logo['src'] ) ); ?>" alt="<?php echo esc_attr( $koff_logo['alt'] ); ?>" loading="lazy">
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

/* ---------------------------------------------------------------
   5. Filmes — Mostra Competitiva / Mostra Não-Competitiva
      CPT "filmes" (JetEngine). Usado por
      template-filmes-competitiva-koff.php e
      template-filmes-nao-competitiva-koff.php, que carregam TODOS os
      filmes da respectiva mostra numa query só (sem paginação/AJAX) e
      renderizam todos os cards de uma vez. O filtro
      Todos/Longas/Curtas/Animação (koff-wp.js) roda inteiramente no
      client-side sobre a lista completa — antes, com "Carregar mais"
      buscando 12 em 12, o filtro só enxergava os cards já carregados
      e um tipo raro no início do alfabeto (ex.: Longas) parecia sumir.

      Campos confirmados no wp_postmeta (dump do banco):
      - status      (switcher)  -> string 'true' / 'false'
      - competitive (switcher)  -> string 'true' / 'false'
      - koffa       (switcher)  -> string 'true' / 'false' (frequentemente
        SEM linha em wp_postmeta quando nunca foi tocado no admin —
        tratado como 'false' via NOT EXISTS nas queries abaixo)
      - archived    (switcher)  -> string 'true' / 'false'
      - type        (select)    -> 'Feature' | 'Short' | 'Animation'
      - direction   (texto)     -> nome do diretor
      Pôster = Featured Image do post (get_the_post_thumbnail_url).

      koff_fmc_query_args() = Mostra Competitiva (competitive=true).
      koff_fmnc_query_args() = Mostra Não-Competitiva, definida por
      exclusão: status/competitive/koffa/archived todos "não
      marcados" (ausentes OU 'false'). As duas usam o mesmo corte de
      data (KOFF_FMC_CUTOFF) e são mutuamente exclusivas (confirmado
      contra dump do banco em 2026-08-06: 0 filmes em comum entre as
      duas listas).
--------------------------------------------------------------- */

define( 'KOFF_FMC_CUTOFF', '2026-07-02 00:00:00' ); // post_date depois desta data

/**
 * Rodízio de placeholders — mesmo conjunto de imagens usado em
 * template-programacao-koff.php (função koff_next_placeholder).
 *
 * URLs resolvidas dinamicamente via koff_logo_url() / wp_get_upload_dir()
 * (em vez de hardcodar "http://koff-teste.local"): assim funciona sem
 * ajuste manual em produção E evita o aviso de "acessar dispositivos/
 * serviços na rede local" que aparecia ao testar pelo celular (a URL
 * fixa apontava direto pro host .local, que não passa pelo mesmo
 * mapeamento de domínio que as imagens dinâmicas já usam).
 */
function koff_fmc_placeholders() {
    return array_map( 'koff_logo_url', [
        '2026/07/placeholders-09-210x300.png',
        '2026/07/placeholders-08-210x300.png',
        '2026/07/placeholders-07-210x300.png',
        '2026/07/placeholders-06-210x300.png',
        '2026/07/placeholders-05-210x300.png',
        '2026/07/placeholders-04-210x300.png',
        '2026/07/placeholders-03-210x300.png',
        '2026/07/placeholders-02-210x300.png',
        '2026/07/placeholders-01-210x300.png',
    ] );
}

/**
 * Próxima imagem placeholder em rodízio sequencial (1..9..1..).
 * $counter é passado por referência e incrementado a cada chamada.
 */
function koff_fmc_next_placeholder( &$counter ) {
    $placeholders = koff_fmc_placeholders();
    $img = $placeholders[ $counter % count( $placeholders ) ];
    $counter++;
    return $img;
}

/**
 * Args da WP_Query para a listagem da Mostra Competitiva:
 * competitive=true (meta) + post_date depois do corte + publish,
 * ordenado alfabeticamente pelo título. Traz todos de uma vez
 * (posts_per_page => -1) — a página renderiza a lista inteira e o
 * filtro por tipo roda no client-side.
 */
function koff_fmc_query_args() {
    return [
        'post_type'              => 'filmes',
        'post_status'             => 'publish',
        'posts_per_page'          => -1,
        'orderby'                 => 'title',
        'order'                   => 'ASC',
        'update_post_term_cache'  => false,
        'meta_query'              => [
            [
                'key'     => 'competitive',
                'value'   => 'true',
                'compare' => '=',
            ],
        ],
        'date_query'              => [
            [
                'column'    => 'post_date',
                'after'     => KOFF_FMC_CUTOFF,
                'inclusive' => false,
            ],
        ],
    ];
}

/**
 * Args da WP_Query para a listagem da Mostra Não-Competitiva:
 * post_date depois do corte + publish, e os 4 switches (status,
 * competitive, koffa, archived) todos "não marcados" — ou seja, a
 * mostra não-competitiva é definida por exclusão, não por um campo
 * próprio. Ordenado alfabeticamente pelo título. Traz todos de uma
 * vez (posts_per_page => -1) — mesmo padrão de koff_fmc_query_args().
 *
 * Cada condição usa OR (meta ausente) / (meta != 'true') em vez de
 * só '= false', porque o campo "koffa" frequentemente nunca foi
 * salvo no admin (sem linha em wp_postmeta) em vez de ter o valor
 * 'false' explícito — confirmado contra dump do banco (ex.: filme
 * "The World of Love", ID 8162, sem nenhuma linha de meta "koffa").
 * Um meta_query com só 'compare' => '=' e 'value' => 'false' excluiria
 * esse filme por engano, já que '=' não casa contra uma meta_key
 * inexistente.
 */
function koff_fmnc_query_args() {
    return [
        'post_type'              => 'filmes',
        'post_status'             => 'publish',
        'posts_per_page'          => -1,
        'orderby'                 => 'title',
        'order'                   => 'ASC',
        'update_post_term_cache'  => false,
        'meta_query'              => [
            'relation' => 'AND',
            [
                'relation' => 'OR',
                [ 'key' => 'status', 'compare' => 'NOT EXISTS' ],
                [ 'key' => 'status', 'value' => 'true', 'compare' => '!=' ],
            ],
            [
                'relation' => 'OR',
                [ 'key' => 'competitive', 'compare' => 'NOT EXISTS' ],
                [ 'key' => 'competitive', 'value' => 'true', 'compare' => '!=' ],
            ],
            [
                'relation' => 'OR',
                [ 'key' => 'koffa', 'compare' => 'NOT EXISTS' ],
                [ 'key' => 'koffa', 'value' => 'true', 'compare' => '!=' ],
            ],
            [
                'relation' => 'OR',
                [ 'key' => 'archived', 'compare' => 'NOT EXISTS' ],
                [ 'key' => 'archived', 'value' => 'true', 'compare' => '!=' ],
            ],
        ],
        'date_query'              => [
            [
                'column'    => 'post_date',
                'after'     => KOFF_FMC_CUTOFF,
                'inclusive' => false,
            ],
        ],
    ];
}

/**
 * Mapeia o valor salvo do campo "type" para o label exibido na tag
 * e o valor usado em data-cat (filtro client-side via koff-wp.js).
 */
function koff_fmc_tipo_info( $type_value ) {
    switch ( $type_value ) {
        case 'Feature':
            return [ 'label' => 'Longa', 'cat' => 'longa' ];
        case 'Short':
            return [ 'label' => 'Curta', 'cat' => 'curta' ];
        case 'Animation':
            return [ 'label' => 'Animação', 'cat' => 'animacao' ];
        default:
            return [ 'label' => $type_value ? $type_value : '', 'cat' => '' ];
    }
}

/**
 * Renderiza um card <a class="card"> de filme (poster + tag + título +
 * diretor), no mesmo formato do Filmes.html (classes .card, .ph.ph-2x3,
 * .tag do koff.css). O card inteiro é um link para o permalink do filme.
 */
function koff_fmc_render_card( $post_id, &$ph_counter ) {
    $type_value = get_post_meta( $post_id, 'type', true );
    $tipo       = koff_fmc_tipo_info( $type_value );
    $direction  = get_post_meta( $post_id, 'direction', true );

    $poster = get_the_post_thumbnail_url( $post_id, 'medium' );
    if ( ! $poster ) {
        $poster = koff_fmc_next_placeholder( $ph_counter );
    }

    $link  = get_permalink( $post_id );
    $title = get_the_title( $post_id );

    ob_start();
    ?>
    <a class="card" data-cat="<?php echo esc_attr( $tipo['cat'] ); ?>" href="<?php echo esc_url( $link ); ?>" style="overflow:hidden">
        <div class="ph ph-2x3">
            <img src="<?php echo esc_url( $poster ); ?>" alt="<?php echo esc_attr( $title ); ?>" loading="lazy">
        </div>
        <div class="koff-fmc-body">
            <?php if ( $tipo['label'] ) : ?>
                <span class="tag"><?php echo esc_html( $tipo['label'] ); ?></span>
            <?php endif; ?>
            <div class="koff-fmc-title"><?php echo esc_html( $title ); ?></div>
            <?php if ( $direction ) : ?>
                <div class="koff-fmc-direction"><?php echo esc_html( $direction ); ?></div>
            <?php endif; ?>
        </div>
    </a>
    <?php
    return ob_get_clean();
}

/* ---------------------------------------------------------------
   6. Busca de Filmes
      Página template-busca-filmes-koff.php. Busca por título
      (post_title) OU pelo nome do diretor (meta "direction"), em
      TODO o CPT "filmes" publicado, POSTADO DEPOIS do corte de data
      desta edição (post_date depois de KOFF_FMC_CUTOFF, o mesmo
      "02/07/2026" já usado na Mostra Competitiva acima — reaproveita
      a mesma constante em vez de duplicar o valor) — sem filtrar por
      "competitive" nem por "archived" (escopo confirmado com o
      usuário: mostra também filmes arquivados/não competitivos,
      desde que sejam desta edição).

      Combinação título OU diretor: o WP_Query nativo trata `s`
      (busca por título) e `meta_query` como AND, não OR. Decisão
      tomada aqui — Abordagem "duas queries + merge" (mais simples
      de manter e consistente com o resto deste arquivo, que não usa
      hooks de posts_join/posts_where em nenhum outro lugar), em vez
      de reescrever o WHERE via posts_join/posts_where:
      1) busca IDs que batem no título via `s`;
      2) busca IDs que batem no meta "direction" via `meta_query`;
      3) une os dois sem duplicar e ordena alfabeticamente pelo
         título ANTES de paginar, pra o "Carregar mais" não repetir
         nem pular filme entre uma leva e outra.

      Reaproveita koff_fmc_render_card() / koff_fmc_tipo_info() /
      koff_fmc_placeholders() (bloco 5 acima) pra renderizar cada
      card — essas funções não filtram por "competitive", servem
      pra qualquer post do CPT "filmes".

      Campo do formulário é "termo" (não "s"): "s" é reservado pelo
      WordPress como parâmetro nativo de busca e, se usado numa URL
      de Página customizada, pode fazer o WordPress carregar
      search.php em vez do Page Template atribuído à página.
--------------------------------------------------------------- */

define( 'KOFF_BUSCA_PER_PAGE', 12 );
define( 'KOFF_BUSCA_MIN_CHARS', 2 );
define( 'KOFF_BUSCA_NONCE_ACTION', 'koff_busca_filmes' );

/**
 * Retorna os IDs de posts do CPT "filmes" (publicados) cujo título OU
 * cujo meta "direction" (diretor) contém $termo — sem duplicar, já
 * ordenados alfabeticamente pelo título.
 */
function koff_busca_encontrar_ids( $termo ) {
    // Corte de data desta edição — mesma constante/valor usados na
    // Mostra Competitiva (bloco 5), pra não duplicar a data "na mão".
    $koff_busca_date_query = [
        [
            'column'    => 'post_date',
            'after'     => KOFF_FMC_CUTOFF,
            'inclusive' => false,
        ],
    ];

    $por_titulo = new WP_Query( [
        'post_type'              => 'filmes',
        'post_status'            => 'publish',
        's'                      => $termo,
        'posts_per_page'         => -1,
        'fields'                 => 'ids',
        'update_post_term_cache' => false,
        'update_post_meta_cache' => false,
        'date_query'             => $koff_busca_date_query,
    ] );

    $por_diretor = new WP_Query( [
        'post_type'              => 'filmes',
        'post_status'            => 'publish',
        'posts_per_page'         => -1,
        'fields'                 => 'ids',
        'update_post_term_cache' => false,
        'update_post_meta_cache' => false,
        'date_query'             => $koff_busca_date_query,
        'meta_query'             => [
            [
                'key'     => 'direction',
                'value'   => $termo,
                'compare' => 'LIKE',
            ],
        ],
    ] );

    $ids = array_unique( array_merge( $por_titulo->posts, $por_diretor->posts ) );

    if ( empty( $ids ) ) {
        return [];
    }

    // Reordena alfabeticamente pelo título o conjunto unido (a ordem
    // de $por_titulo/$por_diretor sozinhas não garante isso combinado).
    $ordenado = new WP_Query( [
        'post_type'              => 'filmes',
        'post__in'               => $ids,
        'post_status'            => 'publish',
        'posts_per_page'         => -1,
        'orderby'                => 'title',
        'order'                  => 'ASC',
        'fields'                 => 'ids',
        'update_post_term_cache' => false,
        'update_post_meta_cache' => false,
    ] );

    return $ordenado->posts;
}

/**
 * AJAX de busca — usado tanto pelo submit inicial do formulário quanto
 * pelo "Carregar mais" (só muda o offset enviado). Recebe "termo" e
 * "offset" via POST.
 */
add_action( 'wp_ajax_koff_busca_filmes', 'koff_ajax_busca_filmes' );
add_action( 'wp_ajax_nopriv_koff_busca_filmes', 'koff_ajax_busca_filmes' );
function koff_ajax_busca_filmes() {
    check_ajax_referer( KOFF_BUSCA_NONCE_ACTION, 'nonce' );

    $termo  = isset( $_POST['termo'] ) ? sanitize_text_field( wp_unslash( $_POST['termo'] ) ) : '';
    $termo  = trim( $termo );
    $offset = isset( $_POST['offset'] ) ? max( 0, (int) $_POST['offset'] ) : 0;

    if ( mb_strlen( $termo ) < KOFF_BUSCA_MIN_CHARS ) {
        wp_send_json_success( [
            'html'     => '',
            'has_more' => false,
            'found'    => 0,
        ] );
    }

    $ids        = koff_busca_encontrar_ids( $termo );
    $found      = count( $ids );
    $pagina_ids = array_slice( $ids, $offset, KOFF_BUSCA_PER_PAGE );

    $html       = '';
    $ph_counter = 0;
    foreach ( $pagina_ids as $koff_busca_post_id ) {
        $html .= koff_fmc_render_card( $koff_busca_post_id, $ph_counter );
    }

    $has_more = ( $offset + KOFF_BUSCA_PER_PAGE ) < $found;

    wp_send_json_success( [
        'html'     => $html,
        'has_more' => $has_more,
        'found'    => $found,
    ] );
}

/* ---------------------------------------------------------------
   7. Home — formulário de contato (envia e-mail via wp_mail)
      Usado por template-home-koff.php (seção "Fique por dentro do
      KOFF"). Sem plugin de formulário, sem Elementor Form — envia
      direto pro e-mail da organização via wp_mail() nativo do PHP.
      Mesmo padrão de handler AJAX do bloco 6 acima (nonce +
      wp_send_json_success/wp_send_json_error).
--------------------------------------------------------------- */

define( 'KOFF_HOME_CONTATO_NONCE_ACTION', 'koff_home_contato' );
define( 'KOFF_HOME_CONTATO_EMAIL_DESTINO', 'contato@koffko.com.br' );

add_action( 'wp_ajax_koff_home_contato', 'koff_ajax_home_contato' );
add_action( 'wp_ajax_nopriv_koff_home_contato', 'koff_ajax_home_contato' );
function koff_ajax_home_contato() {
    check_ajax_referer( KOFF_HOME_CONTATO_NONCE_ACTION, 'nonce' );

    $email_bruto = isset( $_POST['email'] ) ? wp_unslash( $_POST['email'] ) : '';
    $email       = sanitize_email( $email_bruto );

    if ( ! $email || ! is_email( $email ) ) {
        wp_send_json_error( [ 'message' => 'Digite um e-mail válido.' ] );
    }

    $enviado = wp_mail(
        KOFF_HOME_CONTATO_EMAIL_DESTINO,
        'Novo contato via site — Home KOFF',
        "Um visitante deixou o e-mail abaixo pelo formulário da home do site:\n\n" . $email,
        [ 'Content-Type: text/plain; charset=UTF-8' ]
    );

    if ( ! $enviado ) {
        wp_send_json_error( [ 'message' => 'Não foi possível enviar agora. Tente novamente em instantes.' ] );
    }

    wp_send_json_success( [ 'message' => 'Recebemos seu contato!' ] );
}