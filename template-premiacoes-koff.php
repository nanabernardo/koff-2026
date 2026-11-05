<?php
/**
 * Template Name: Premiações 2026 KOFF
 *
 * Página "Premiações 2026" (Winners 2026) do festival KOFF. 100% código,
 * sem Elementor. Reaproveita a estética do koff.css (classes .pagehero,
 * .wrap, .crumbs, .eyebrow, .lead, .section, .section-head, .badge,
 * .badge-soft, .tag, .btn.btn-outline.btn-sm) e os tokens de cor do
 * koff.css (--gold, --bg-2, --bg-3, --card, --line, --line-2, --fg,
 * --fg-2, --fg-3, --radius, --radius-lg), sem redefini-los — já são
 * carregados globalmente via koff_enqueue() em functions.php.
 *
 * Fonte dos dados: array estático no bloco "EDITE AQUI" logo abaixo
 * (seções, filmes premiados, prêmio, categoria e lista de imagens).
 * - Diretor e link "Ver filme" vêm do CPT "filmes" (JetEngine), buscando
 *   o filme pelo título exato (campo "direction" + permalink). Se não
 *   encontrar, o filme aparece sem diretor e sem botão — não quebra.
 * - Imagens são referenciadas pelo NOME DO ARQUIVO na Biblioteca de
 *   Mídia (ex.: 'isle-child-01.jpg'), nunca por ID de anexo nem por URL
 *   com domínio. O template procura cada nome no meta _wp_attached_file
 *   do ambiente onde está rodando (uma única consulta para todas as
 *   imagens), aceitando qualquer pasta ano/mês e a versão "-scaled" que
 *   o WordPress cria para imagens grandes. Assim o MESMO arquivo funciona
 *   em local e em produção, desde que as imagens tenham sido enviadas com
 *   o mesmo nome nos dois ambientes.
 * - Imagem não encontrada é pulada (sem <img> quebrada). Se o usuário
 *   logado for administrador, aparece um aviso discreto no topo da
 *   página listando os arquivos/filmes não encontrados.
 *
 * Toda a lógica, o CSS e o JS desta página ficam DENTRO deste arquivo
 * (mesmo padrão do <style> em template-filmes-competitiva-koff.php), para
 * que o deploy em produção seja só este template — sem mexer em
 * functions.php, koff.css ou koff-wp.js. Classes e funções novas usam o
 * prefixo "koff-prem-" / "koff_prem_" para não colidir com nada existente.
 *
 * Layout de cada filme:
 * - Cabeçalho: selo do prêmio (.badge para o vencedor, .badge-soft para
 *   as menções), título, categoria + diretor e botão "Ver filme".
 * - Galeria: no desktop, as 4–5 imagens (proporção 4:5) lado a lado numa
 *   linha, centralizadas quando forem 4; no mobile, carrossel com
 *   scroll-snap mostrando parte da próxima imagem + indicadores de posição.
 * - Clique em qualquer imagem abre um lightbox em tela cheia com setas,
 *   teclado (← → Esc), deslize no celular e fechamento clicando fora.
 */

get_header();

/* =========================================================================
 * >>> EDITE AQUI <<<
 *
 * 1) SEÇÕES DA PÁGINA — na ordem em que aparecem.
 *    A chave (ex.: 'vencedor') é usada no campo 'secao' de cada filme.
 *    Seção sem nenhum filme não é exibida.
 * ====================================================================== */
$koff_prem_secoes = array(
    'vencedor' => 'Vencedor',
    'direcao'  => 'Menção Especial · Direção',
    'longas'   => 'Menção Especial · Longa-metragem',
    'curtas'   => 'Menção Especial · Curta-metragem',
);

/* =========================================================================
 * >>> EDITE AQUI <<<
 *
 * 2) FILMES PREMIADOS
 *
 * Campos de cada filme:
 *  - 'secao'     : chave de $koff_prem_secoes (em qual seção o filme entra)
 *  - 'titulo'    : título EXATAMENTE igual ao cadastrado no CPT Filmes
 *                  (é por ele que o template busca diretor e link)
 *  - 'premio'    : texto do selo dourado (nome oficial, em inglês)
 *  - 'categoria' : 'Longa' ou 'Curta' (aparece ao lado do diretor)
 *  - 'imagens'   : NOME DO ARQUIVO de cada imagem, como foi enviado à
 *                  Biblioteca de Mídia — sem domínio e sem pasta
 *                  (ex.: 'isle-child-01.jpg'). A ordem da lista é a ordem
 *                  em que as imagens aparecem na página.
 *
 * Dentro de uma mesma seção, os filmes aparecem na ordem deste array.
 * ====================================================================== */
$koff_premiados = array(

    /* ---------------- Vencedor ---------------- */
    array(
        'secao'     => 'vencedor',
        'titulo'    => 'Isle Child',
        'premio'    => 'Winner · Best Feature Film',
        'categoria' => 'Longa',
        'imagens'   => array(
            '2026-koffpremiacao_isleChild3.jpeg',
            '2026-koffpremiacao_isleChild2.jpeg',
            '2026-koffpremiacao_isleChild1.jpeg',
            '2026-koffpremiacao_isleChild.jpeg',
        ),
    ),

    /* ---------------- Menção Especial · Direção ---------------- */
    array(
        'secao'     => 'direcao',
        'titulo'    => 'Halo',
        'premio'    => 'Special Mention · Best Director',
        'categoria' => 'Longa',
        'imagens'   => array(
            '2026-koffpremiacao_halo.png',
            '2026-koffpremiacao_halo1.png',
            '2026-koffpremiacao_halo2.png',
            '2026-koffpremiacao_halo3.png',
            '2026-koffpremiacao_halo4.png',
        ),
    ),

    /* ---------------- Menção Especial · Longa-metragem ---------------- */
    array(
        'secao'     => 'longas',
        'titulo'    => 'The Price of Goodbye',
        'premio'    => 'Special Mention · Feature Film',
        'categoria' => 'Longa',
        'imagens'   => array(
            '2026-koffpremiacao_ThePriceOfGoodby.png',
            '2026-koffpremiacao_ThePriceOfGoodby1.png',
            '2026-koffpremiacao_ThePriceOfGoodby2.png',
            '2026-koffpremiacao_ThePriceOfGoodby3.png',
        ),
    ),
    array(
        'secao'     => 'longas',
        'titulo'    => 'My Missing Aunt',
        'premio'    => 'Special Mention · Feature Film',
        'categoria' => 'Longa',
        'imagens'   => array(
            '2026-koffpremiacao_MyMissingAunt.png',
            '2026-koffpremiacao_MyMissingAunt1.png',
            '2026-koffpremiacao_MyMissingAunt2.png',
            '2026-koffpremiacao_MyMissingAunt3.png',
        ),
    ),

    /* ---------------- Menção Especial · Curta-metragem ---------------- */
    array(
        'secao'     => 'curtas',
        'titulo'    => 'Chicken Run',
        'premio'    => 'Special Mention · Short Film',
        'categoria' => 'Curta',
        'imagens'   => array(
            '2026-koffpremiacao_chickenrun-45.png',
            '2026-koffpremiacao_chickenrun-46.png',
            '2026-koffpremiacao_chickenrun-47.png',
            '2026-koffpremiacao_chickenrun-48.png',
            '2026-koffpremiacao_chickenrun-49.png',
        ),
    ),
    array(
        'secao'     => 'curtas',
        'titulo'    => 'Sexy Fly',
        'premio'    => 'Special Mention · Short Film',
        'categoria' => 'Curta',
        'imagens'   => array(
            '2026-koffpremiacao_sexyfly-35.png',
            '2026-koffpremiacao_sexyfly-36.png',
            '2026-koffpremiacao_sexyfly-37-2.png',
            '2026-koffpremiacao_sexyfly-38.png',
            '2026-koffpremiacao_sexyfly-39-1.png',
        ),
    ),

    /* ---------------- MODELO: 3º curta ----------------
     * Para ativar: apague a linha "INÍCIO DO MODELO" e a linha
     * "FIM DO MODELO" abaixo, preencha os campos e confira que as imagens
     * já estão na Biblioteca de Mídia (local e produção) com exatamente
     * esses nomes.
     */
    /* <- INÍCIO DO MODELO (apague esta linha)
    array(
        'secao'     => 'curtas',
        'titulo'    => 'Título do Curta',
        'premio'    => 'Special Mention · Short Film',
        'categoria' => 'Curta',
        'imagens'   => array(
            'titulo-do-curta-01.jpg',
            'titulo-do-curta-02.jpg',
            'titulo-do-curta-03.jpg',
            'titulo-do-curta-04.jpg',
            'titulo-do-curta-05.jpg',
        ),
    ),
    */ // <- FIM DO MODELO (apague esta linha)
);

/* =========================================================================
 * FIM DO BLOCO "EDITE AQUI" — daqui pra baixo é lógica, não precisa mexer.
 * ====================================================================== */


/* =========================================================================
 * 3) HELPERS
 *    Definidos aqui (e não em functions.php) para o deploy ser só este
 *    arquivo. O function_exists() evita erro caso algum dia uma função
 *    com o mesmo nome passe a existir em functions.php.
 * ====================================================================== */

if ( ! function_exists( 'koff_prem_resolver_imagens' ) ) {
    /**
     * Recebe uma lista de nomes de arquivo (ex.: 'halo-01.jpg') e devolve
     * um mapa nome => ID do anexo, para o ambiente atual.
     *
     * Faz UMA consulta só no meta _wp_attached_file, que guarda o caminho
     * relativo do arquivo dentro de /uploads (ex.: '2026/11/halo-01.jpg'
     * ou '2026/11/halo-01-scaled.jpg'). Para cada nome, aceita:
     *  - o arquivo sem pasta ('halo-01.jpg'), se o site não organiza
     *    uploads por ano/mês;
     *  - o arquivo em qualquer pasta ('.../halo-01.jpg');
     *  - a versão grande redimensionada pelo WP ('.../halo-01-scaled.jpg').
     *
     * Se o mesmo nome aparecer mais de uma vez na biblioteca, usa o anexo
     * enviado por último (maior ID).
     */
    function koff_prem_resolver_imagens( $nomes ) {
        global $wpdb;

        $nomes = array_values( array_unique( array_filter( array_map( 'trim', $nomes ) ) ) );
        if ( empty( $nomes ) ) {
            return array();
        }

        // Monta as condições de busca (uma por variante de cada nome).
        $condicoes = array();
        $valores   = array();
        foreach ( $nomes as $nome ) {
            $info   = pathinfo( $nome );
            $scaled = $info['filename'] . '-scaled.' . ( isset( $info['extension'] ) ? $info['extension'] : '' );

            $condicoes[] = 'pm.meta_value = %s';
            $valores[]   = $nome;
            $condicoes[] = 'pm.meta_value LIKE %s';
            $valores[]   = '%/' . $wpdb->esc_like( $nome );
            $condicoes[] = 'pm.meta_value = %s';
            $valores[]   = $scaled;
            $condicoes[] = 'pm.meta_value LIKE %s';
            $valores[]   = '%/' . $wpdb->esc_like( $scaled );
        }

        $sql = "SELECT pm.post_id, pm.meta_value
                FROM {$wpdb->postmeta} pm
                INNER JOIN {$wpdb->posts} p ON p.ID = pm.post_id
                WHERE pm.meta_key = '_wp_attached_file'
                  AND p.post_type = 'attachment'
                  AND ( " . implode( ' OR ', $condicoes ) . ' )
                ORDER BY pm.post_id ASC';

        // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared -- placeholders montados acima.
        $linhas = $wpdb->get_results( $wpdb->prepare( $sql, $valores ) );

        // Converte cada caminho encontrado de volta para o nome "limpo"
        // (sem pasta e sem "-scaled") e associa ao ID. Como a ordem é por
        // ID crescente, o último anexo com o mesmo nome sobrescreve.
        $mapa = array();
        foreach ( (array) $linhas as $linha ) {
            $base = wp_basename( $linha->meta_value );
            $base = preg_replace( '/-scaled(\.[^.]+)$/', '$1', $base );
            if ( in_array( $base, $nomes, true ) ) {
                $mapa[ $base ] = (int) $linha->post_id;
            }
        }

        return $mapa;
    }
}

if ( ! function_exists( 'koff_prem_find_filme' ) ) {
    /**
     * Busca um filme do CPT "filmes" pelo título exato (mesma lógica de
     * koff_find_filme() em template-programacao-koff.php).
     * Retorna array( 'link' => ..., 'direcao' => ... ) ou null.
     */
    function koff_prem_find_filme( $titulo ) {
        $q = new WP_Query( array(
            'post_type'              => 'filmes',
            'title'                  => trim( $titulo ),
            'posts_per_page'         => 1,
            'post_status'            => 'publish',
            'no_found_rows'          => true,
            'update_post_term_cache' => false,
        ) );

        $result = null;
        if ( $q->have_posts() ) {
            $post_id = $q->posts[0]->ID;
            $result  = array(
                'link'    => get_permalink( $post_id ),
                'direcao' => get_post_meta( $post_id, 'direction', true ),
            );
        }
        wp_reset_postdata();

        return $result;
    }
}

/* =========================================================================
 * 4) PREPARA OS DADOS ANTES DO HTML
 *    - resolve todas as imagens numa consulta só;
 *    - busca diretor/link de cada filme no CPT;
 *    - agrupa os filmes por seção;
 *    - junta o que não foi encontrado para o aviso do admin.
 * ====================================================================== */
$koff_prem_todos_nomes = array();
foreach ( $koff_premiados as $koff_prem_f ) {
    $koff_prem_todos_nomes = array_merge( $koff_prem_todos_nomes, (array) $koff_prem_f['imagens'] );
}
$koff_prem_ids = koff_prem_resolver_imagens( $koff_prem_todos_nomes );

$koff_prem_por_secao       = array(); // chave da seção => lista de filmes prontos
$koff_prem_img_faltando    = array(); // nomes de arquivo não encontrados
$koff_prem_filme_faltando  = array(); // títulos não encontrados no CPT

foreach ( $koff_premiados as $koff_prem_f ) {
    $koff_prem_cpt = koff_prem_find_filme( $koff_prem_f['titulo'] );
    if ( ! $koff_prem_cpt ) {
        $koff_prem_filme_faltando[] = $koff_prem_f['titulo'];
    }

    // Monta a lista de imagens encontradas (pulando as que faltam).
    $koff_prem_imgs = array();
    foreach ( (array) $koff_prem_f['imagens'] as $koff_prem_nome ) {
        $koff_prem_nome = trim( $koff_prem_nome );
        if ( empty( $koff_prem_ids[ $koff_prem_nome ] ) ) {
            $koff_prem_img_faltando[] = $koff_prem_nome;
            continue;
        }
        $koff_prem_id   = $koff_prem_ids[ $koff_prem_nome ];
        $koff_prem_src  = wp_get_attachment_image_url( $koff_prem_id, 'medium_large' ); // grade
        $koff_prem_full = wp_get_attachment_image_url( $koff_prem_id, 'full' );         // lightbox
        if ( ! $koff_prem_src || ! $koff_prem_full ) {
            $koff_prem_img_faltando[] = $koff_prem_nome;
            continue;
        }
        $koff_prem_imgs[] = array(
            'src'    => $koff_prem_src,
            'srcset' => wp_get_attachment_image_srcset( $koff_prem_id, 'medium_large' ),
            'full'   => $koff_prem_full,
            'alt'    => trim( (string) get_post_meta( $koff_prem_id, '_wp_attachment_image_alt', true ) ),
        );
    }

    // Alt de fallback: "Título — imagem N de M" quando o anexo não tem alt.
    $koff_prem_total = count( $koff_prem_imgs );
    foreach ( $koff_prem_imgs as $koff_prem_i => $koff_prem_img ) {
        if ( '' === $koff_prem_img['alt'] ) {
            $koff_prem_imgs[ $koff_prem_i ]['alt'] = sprintf( '%s — imagem %d de %d', $koff_prem_f['titulo'], $koff_prem_i + 1, $koff_prem_total );
        }
    }

    $koff_prem_por_secao[ $koff_prem_f['secao'] ][] = array(
        'titulo'    => $koff_prem_f['titulo'],
        'premio'    => $koff_prem_f['premio'],
        'categoria' => $koff_prem_f['categoria'],
        'link'      => $koff_prem_cpt ? $koff_prem_cpt['link'] : '',
        'direcao'   => $koff_prem_cpt ? $koff_prem_cpt['direcao'] : '',
        'imagens'   => $koff_prem_imgs,
    );
}

$koff_prem_mostrar_aviso = current_user_can( 'manage_options' )
    && ( $koff_prem_img_faltando || $koff_prem_filme_faltando );
?>

<!-- ======================================================================
     HERO
     ====================================================================== -->
<section class="pagehero">
    <div class="wrap">
        <nav class="crumbs">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Início</a><span class="sep">/</span><span>Premiações 2026</span>
        </nav>
        <p class="eyebrow">Edição 2026</p>
        <h1>Premiados KOFF 2026</h1>
        <p class="lead">Conheça os filmes reconhecidos pelo júri da 4ª edição do Korean Film Festival.</p>
    </div>
</section>

<?php if ( $koff_prem_mostrar_aviso ) : ?>
<!-- ======================================================================
     AVISO PARA ADMIN (só aparece para administradores logados)
     Lista imagens não encontradas na Biblioteca de Mídia deste ambiente e
     filmes cujo título não bate com o CPT Filmes.
     ====================================================================== -->
<div class="wrap">
    <div class="koff-prem-aviso" role="note">
        <strong>Aviso (visível só para administradores):</strong>
        <?php if ( $koff_prem_img_faltando ) : ?>
            <p>Imagens não encontradas na Biblioteca de Mídia:
                <?php echo esc_html( implode( ', ', array_unique( $koff_prem_img_faltando ) ) ); ?></p>
        <?php endif; ?>
        <?php if ( $koff_prem_filme_faltando ) : ?>
            <p>Filmes não encontrados no CPT Filmes (sem diretor e sem link):
                <?php echo esc_html( implode( ', ', $koff_prem_filme_faltando ) ); ?></p>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>

<!-- ======================================================================
     SEÇÕES DE PREMIADOS
     Uma <section> por seção configurada; dentro, um <article> por filme
     (cabeçalho + galeria).
     ====================================================================== -->
<?php foreach ( $koff_prem_secoes as $koff_prem_secao_key => $koff_prem_secao_label ) :
    if ( empty( $koff_prem_por_secao[ $koff_prem_secao_key ] ) ) {
        continue; // seção sem filmes não aparece
    }
    $koff_prem_destaque = ( 'vencedor' === $koff_prem_secao_key );
    ?>
<section class="section koff-prem-secao<?php echo $koff_prem_destaque ? ' koff-prem-secao--destaque' : ''; ?>">
    <div class="wrap">
        <h2 class="section-head koff-prem-secao-titulo"><?php echo esc_html( $koff_prem_secao_label ); ?></h2>

        <?php foreach ( $koff_prem_por_secao[ $koff_prem_secao_key ] as $koff_prem_filme ) :
            $koff_prem_qtd = count( $koff_prem_filme['imagens'] );
            ?>
        <article class="koff-prem-filme<?php echo $koff_prem_destaque ? ' koff-prem-filme--destaque' : ''; ?>"
                 id="<?php echo esc_attr( sanitize_title( $koff_prem_filme['titulo'] ) ); ?>">

            <!-- Cabeçalho do filme: selo + título + categoria/diretor + botão -->
            <header class="koff-prem-head">
                <div class="koff-prem-info">
                    <span class="badge<?php echo $koff_prem_destaque ? '' : ' badge-soft'; ?>"><?php echo esc_html( $koff_prem_filme['premio'] ); ?></span>
                    <h3 class="koff-prem-titulo"><?php echo esc_html( $koff_prem_filme['titulo'] ); ?></h3>
                    <p class="koff-prem-meta">
                        <?php if ( $koff_prem_filme['categoria'] ) : ?>
                            <span class="tag"><?php echo esc_html( $koff_prem_filme['categoria'] ); ?></span>
                        <?php endif; ?>
                        <?php if ( $koff_prem_filme['direcao'] ) : ?>
                            <span>Direção: <?php echo esc_html( $koff_prem_filme['direcao'] ); ?></span>
                        <?php endif; ?>
                    </p>
                </div>
                <?php if ( $koff_prem_filme['link'] ) : ?>
                    <a class="btn btn-outline btn-sm koff-prem-ver" href="<?php echo esc_url( $koff_prem_filme['link'] ); ?>">Ver filme</a>
                <?php endif; ?>
            </header>

            <?php if ( $koff_prem_qtd ) : ?>
            <!-- Galeria: grade no desktop, carrossel (scroll-snap) no mobile.
                 Cada imagem é um <button> que abre o lightbox; data-full é a
                 imagem em tamanho original usada no lightbox. -->
            <div class="koff-prem-galeria-wrap">
                <ul class="koff-prem-galeria" data-koff-prem-galeria data-titulo="<?php echo esc_attr( $koff_prem_filme['titulo'] ); ?>">
                    <?php foreach ( $koff_prem_filme['imagens'] as $koff_prem_i => $koff_prem_img ) : ?>
                    <li class="koff-prem-item">
                        <button type="button" class="koff-prem-thumb"
                                data-full="<?php echo esc_url( $koff_prem_img['full'] ); ?>"
                                data-alt="<?php echo esc_attr( $koff_prem_img['alt'] ); ?>"
                                aria-label="<?php echo esc_attr( sprintf( 'Ampliar imagem %d de %d de %s', $koff_prem_i + 1, $koff_prem_qtd, $koff_prem_filme['titulo'] ) ); ?>">
                            <img src="<?php echo esc_url( $koff_prem_img['src'] ); ?>"
                                <?php if ( $koff_prem_img['srcset'] ) : ?>
                                 srcset="<?php echo esc_attr( $koff_prem_img['srcset'] ); ?>"
                                 sizes="(max-width: 760px) 80vw, 260px"
                                <?php endif; ?>
                                 alt="<?php echo esc_attr( $koff_prem_img['alt'] ); ?>"
                                 loading="lazy" decoding="async">
                        </button>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <!-- Indicadores de posição do carrossel (preenchidos via JS,
                     visíveis só no mobile). -->
                <div class="koff-prem-dots" data-koff-prem-dots></div>
            </div>
            <?php endif; ?>
        </article>
        <?php endforeach; ?>
    </div>
</section>
<?php endforeach; ?>

<!-- ======================================================================
     LIGHTBOX (único na página, reaproveitado por todas as galerias)
     ====================================================================== -->
<div class="koff-prem-lb" id="koff-prem-lb" role="dialog" aria-modal="true" aria-label="Imagem ampliada" hidden>
    <button type="button" class="koff-prem-lb-btn koff-prem-lb-close" data-koff-prem-close aria-label="Fechar">&times;</button>
    <button type="button" class="koff-prem-lb-btn koff-prem-lb-prev" data-koff-prem-prev aria-label="Imagem anterior">&#8249;</button>
    <figure class="koff-prem-lb-fig">
        <img class="koff-prem-lb-img" src="" alt="">
        <figcaption class="koff-prem-lb-cap" aria-live="polite"></figcaption>
    </figure>
    <button type="button" class="koff-prem-lb-btn koff-prem-lb-next" data-koff-prem-next aria-label="Próxima imagem">&#8250;</button>
</div>

<style>
/* =========================================================================
 * CSS DA PÁGINA DE PREMIAÇÕES
 * Só classes com prefixo .koff-prem- (novas). Tokens e classes globais do
 * koff.css (.badge, .tag, .btn, .section-head...) são apenas reutilizados.
 * ====================================================================== */

/* ---------- Aviso para admin ---------- */
.koff-prem-aviso{
    margin-top:24px;padding:14px 18px;font-size:13.5px;line-height:1.5;
    color:var(--fg-2);background:var(--bg-3);
    border:1px dashed var(--gold);border-radius:var(--radius);
}
.koff-prem-aviso p{margin:6px 0 0}

/* ---------- Seções ---------- */
.koff-prem-secao + .koff-prem-secao{border-top:1px solid var(--line)}
.koff-prem-secao-titulo{font-size:clamp(22px,3vw,32px);margin-bottom:32px}
.koff-prem-secao--destaque{background:var(--bg-2)}

/* ---------- Filme ---------- */
.koff-prem-filme + .koff-prem-filme{margin-top:56px}
.koff-prem-head{
    display:flex;align-items:flex-end;justify-content:space-between;
    gap:20px;flex-wrap:wrap;margin-bottom:22px;
}
.koff-prem-titulo{
    font-family:var(--head);font-weight:800;text-transform:uppercase;
    font-size:clamp(24px,3.4vw,36px);line-height:1.05;letter-spacing:.01em;
    margin:14px 0 10px;color:var(--fg);
}
.koff-prem-meta{
    display:flex;align-items:center;gap:12px;flex-wrap:wrap;
    margin:0;color:var(--fg-2);font-size:14px;
}
.koff-prem-ver{flex-shrink:0}

/* Vencedor: título maior e moldura dourada sutil */
.koff-prem-filme--destaque{
    padding:clamp(20px,3vw,36px);background:var(--card);
    border:1px solid rgba(255,220,66,.35);border-radius:var(--radius-lg);
}
.koff-prem-filme--destaque .koff-prem-titulo{font-size:clamp(30px,5vw,56px)}

/* ---------- Galeria (desktop) ----------
 * Cada item ocupa 1/5 da largura (5 colunas, gap 16px). Com 4 imagens a
 * linha fica centralizada (justify-content:center). No vencedor, 1/4 da
 * largura — imagens maiores. */
.koff-prem-galeria{
    --koff-prem-gap:16px;
    list-style:none;margin:0;padding:0;
    display:flex;justify-content:center;gap:var(--koff-prem-gap);
}
.koff-prem-item{flex:0 0 calc((100% - 4 * var(--koff-prem-gap)) / 5);margin:0}
.koff-prem-filme--destaque .koff-prem-item{flex-basis:calc((100% - 3 * var(--koff-prem-gap)) / 4)}

.koff-prem-thumb{
    display:block;width:100%;padding:0;margin:0;cursor:zoom-in;
    aspect-ratio:4/5;overflow:hidden;
    background:var(--bg-3);border:1px solid var(--line);border-radius:var(--radius);
    transition:transform .2s ease,border-color .2s ease;
}
.koff-prem-thumb:hover{transform:translateY(-4px);border-color:var(--gold)}
.koff-prem-thumb:focus-visible{outline:2px solid var(--gold);outline-offset:3px}
/* contain (e não cover) para nunca cortar o texto das imagens caso alguma
   não esteja exatamente em 4:5 */
.koff-prem-thumb img{width:100%;height:100%;object-fit:contain;display:block}

.koff-prem-dots{display:none}

/* ---------- Galeria (mobile): carrossel com scroll-snap ---------- */
@media (max-width:760px){
    .koff-prem-head{align-items:flex-start}
    .koff-prem-galeria{
        justify-content:flex-start;overflow-x:auto;
        scroll-snap-type:x mandatory;-webkit-overflow-scrolling:touch;
        scrollbar-width:none;
        /* sangra até a borda da tela e deixa "espiar" a próxima imagem */
        margin-inline:calc(var(--pad) * -1);padding-inline:var(--pad);
        scroll-padding-inline:var(--pad);
    }
    .koff-prem-galeria::-webkit-scrollbar{display:none}
    .koff-prem-item,
    .koff-prem-filme--destaque .koff-prem-item{flex-basis:78%;scroll-snap-align:start}
    .koff-prem-filme--destaque{padding:20px}
    .koff-prem-filme--destaque .koff-prem-galeria{margin-inline:-20px;padding-inline:20px;scroll-padding-inline:20px}
    .koff-prem-thumb:hover{transform:none}

    .koff-prem-dots{display:flex;justify-content:center;gap:8px;margin-top:16px}
    .koff-prem-dot{
        width:8px;height:8px;padding:0;border:0;border-radius:50%;
        background:var(--line-2);cursor:pointer;transition:background .2s,width .2s;
    }
    .koff-prem-dot[aria-current="true"]{background:var(--gold);width:22px;border-radius:4px}

    
}

/* ---------- Lightbox ---------- */
.koff-prem-lb{
    position:fixed;inset:0;z-index:99999;
    display:flex;align-items:center;justify-content:center;
    background:rgba(0,0,0,.92);padding:56px 72px;
}
.koff-prem-lb[hidden]{display:none}
.koff-prem-lb-fig{margin:0;display:flex;flex-direction:column;align-items:center;max-width:100%;max-height:100%}
.koff-prem-lb-img{
    max-width:100%;max-height:calc(100vh - 140px);
    object-fit:contain;display:block;border-radius:var(--radius);
}
.koff-prem-lb-cap{
    margin-top:14px;color:var(--fg-2);font-size:13px;
    letter-spacing:.08em;text-transform:uppercase;text-align:center;
}
.koff-prem-lb-btn{
    position:absolute;display:flex;align-items:center;justify-content:center;
    width:48px;height:48px;padding:0;border-radius:50%;
    background:rgba(30,30,30,.85);color:var(--fg);
    border:1px solid var(--line-2);font-size:30px;line-height:1;cursor:pointer;
    transition:border-color .2s,color .2s;
}
.koff-prem-lb-btn:hover,
.koff-prem-lb-btn:focus-visible{border-color:var(--gold);color:var(--gold);outline:none}
.koff-prem-lb-close{top:16px;right:16px}
.koff-prem-lb-prev{left:16px;top:50%;transform:translateY(-50%)}
.koff-prem-lb-next{right:16px;top:50%;transform:translateY(-50%)}
.koff-prem-lb-btn[hidden]{display:none}
@media (max-width:760px){
    .koff-prem-lb{padding:64px 8px 24px}
    .koff-prem-lb-prev,.koff-prem-lb-next{top:auto;bottom:16px;transform:none}
    .koff-prem-lb-img{max-height:calc(100vh - 170px)}
}
/* trava a rolagem da página enquanto o lightbox está aberto */
body.koff-prem-lb-aberto{overflow:hidden}



</style>

<script>
/* =========================================================================
 * JS DA PÁGINA DE PREMIAÇÕES
 * 1) Indicadores (bolinhas) do carrossel mobile
 * 2) Lightbox: abre ao clicar numa imagem, navega só entre as imagens do
 *    mesmo filme (setas, teclado ← → e deslize), fecha com Esc, botão ×
 *    ou clique fora da imagem. Devolve o foco para a miniatura ao fechar.
 * Sem dependências; não usa alert/confirm.
 * ====================================================================== */
(function () {
    var galerias = document.querySelectorAll('[data-koff-prem-galeria]');
    if (!galerias.length) return;

    /* ---------------------------------------------------------------
     * 1) Indicadores de posição do carrossel
     * ------------------------------------------------------------- */
    galerias.forEach(function (lista) {
        var itens = lista.querySelectorAll('.koff-prem-item');
        var dotsBox = lista.parentNode.querySelector('[data-koff-prem-dots]');
        if (!dotsBox || itens.length < 2) return;

        var titulo = lista.getAttribute('data-titulo') || '';
        var dots = [];

        // Distância entre o início de uma imagem e o da seguinte
        // (largura do item + espaço entre itens).
        function passo() {
            return itens[0].offsetWidth + (parseFloat(getComputedStyle(lista).columnGap) || 16);
        }

        itens.forEach(function (item, i) {
            var d = document.createElement('button');
            d.type = 'button';
            d.className = 'koff-prem-dot';
            d.setAttribute('aria-label', 'Ir para a imagem ' + (i + 1) + ' de ' + itens.length + ' de ' + titulo);
            d.addEventListener('click', function () {
                lista.scrollTo({ left: i * passo(), behavior: 'smooth' });
            });
            dotsBox.appendChild(d);
            dots.push(d);
        });

        // Marca a bolinha ativa conforme a rolagem horizontal.
        var ticking = false;
        function atualizar() {
            ticking = false;
            var idx = Math.round(lista.scrollLeft / passo());
            idx = Math.max(0, Math.min(itens.length - 1, idx));
            // Se chegou ao fim da rolagem, a última fica ativa.
            if (lista.scrollLeft + lista.clientWidth >= lista.scrollWidth - 2) idx = itens.length - 1;
            dots.forEach(function (d, i) { d.setAttribute('aria-current', i === idx ? 'true' : 'false'); });
        }
        lista.addEventListener('scroll', function () {
            if (!ticking) { ticking = true; requestAnimationFrame(atualizar); }
        }, { passive: true });
        atualizar();
    });

    /* ---------------------------------------------------------------
     * 2) Lightbox
     * ------------------------------------------------------------- */
    var lb = document.getElementById('koff-prem-lb');
    if (!lb) return;
    var lbImg = lb.querySelector('.koff-prem-lb-img');
    var lbCap = lb.querySelector('.koff-prem-lb-cap');
    var btnPrev = lb.querySelector('[data-koff-prem-prev]');
    var btnNext = lb.querySelector('[data-koff-prem-next]');
    var btnClose = lb.querySelector('[data-koff-prem-close]');

    var atual = [];       // botões (miniaturas) do filme aberto
    var idx = 0;          // índice da imagem exibida
    var tituloAtual = '';
    var origemFoco = null;

    function mostrar(i) {
        idx = (i + atual.length) % atual.length; // navegação circular
        var b = atual[idx];
        lbImg.src = b.getAttribute('data-full');
        lbImg.alt = b.getAttribute('data-alt') || '';
        lbCap.textContent = tituloAtual + ' · ' + (idx + 1) + ' / ' + atual.length;
        var unica = atual.length < 2;
        btnPrev.hidden = unica;
        btnNext.hidden = unica;
    }

    function abrir(lista, i, botao) {
        atual = Array.prototype.slice.call(lista.querySelectorAll('.koff-prem-thumb'));
        tituloAtual = lista.getAttribute('data-titulo') || '';
        origemFoco = botao;
        mostrar(i);
        lb.hidden = false;
        document.body.classList.add('koff-prem-lb-aberto');
        btnClose.focus();
    }

    function fechar() {
        lb.hidden = true;
        lbImg.src = '';
        document.body.classList.remove('koff-prem-lb-aberto');
        if (origemFoco) origemFoco.focus();
    }

    // Clique nas miniaturas
    galerias.forEach(function (lista) {
        lista.querySelectorAll('.koff-prem-thumb').forEach(function (b, i) {
            b.addEventListener('click', function () { abrir(lista, i, b); });
        });
    });

    btnPrev.addEventListener('click', function () { mostrar(idx - 1); });
    btnNext.addEventListener('click', function () { mostrar(idx + 1); });
    btnClose.addEventListener('click', fechar);

    // Clique fora da imagem (no fundo escuro) fecha
    lb.addEventListener('click', function (e) {
        if (e.target === lb || e.target.classList.contains('koff-prem-lb-fig')) fechar();
    });

    // Teclado: Esc fecha, setas navegam, Tab fica preso dentro do lightbox
    document.addEventListener('keydown', function (e) {
        if (lb.hidden) return;
        if (e.key === 'Escape') { fechar(); }
        else if (e.key === 'ArrowLeft') { mostrar(idx - 1); }
        else if (e.key === 'ArrowRight') { mostrar(idx + 1); }
        else if (e.key === 'Tab') {
            var focaveis = [btnClose, btnPrev, btnNext].filter(function (b) { return !b.hidden; });
            var pos = focaveis.indexOf(document.activeElement);
            e.preventDefault();
            var prox = e.shiftKey ? pos - 1 : pos + 1;
            focaveis[(prox + focaveis.length) % focaveis.length].focus();
        }
    });

    // Deslize no celular (swipe horizontal > 50px troca de imagem)
    var toqueX = null;
    lb.addEventListener('touchstart', function (e) { toqueX = e.touches[0].clientX; }, { passive: true });
    lb.addEventListener('touchend', function (e) {
        if (toqueX === null) return;
        var dx = e.changedTouches[0].clientX - toqueX;
        toqueX = null;
        if (Math.abs(dx) > 50 && atual.length > 1) mostrar(dx < 0 ? idx + 1 : idx - 1);
    }, { passive: true });
})();
</script>

<?php get_footer(); ?>
