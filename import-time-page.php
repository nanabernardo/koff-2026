<?php
/**
 * KOFF — Importa Time.html → página Team (ID 469)
 * Todos os elementos são widgets NATIVOS do Elementor Pro.
 *
 * Rodar no terminal do Local WP:
 *   wp eval-file wp-content/themes/koff/import-time-page.php
 */

$PAGE_ID = 469;

// ─────────────────────────────────────────────────────────────────────────────
// Tokens visuais (mesmo que o koff.css)
// ─────────────────────────────────────────────────────────────────────────────
$GOLD  = '#FFDC42';
$WHITE = '#FFFFFF';
$GREY  = '#999999';
$GREY3 = '#666666';
$BG    = '#131313';
$BG2   = '#0E0E0E';
$CARD  = '#1E1E1E';
$CARD_BG = '#1b1b1b';
$BEV   = 'Be Vietnam Pro';
$MAN   = 'Manrope';

// ─────────────────────────────────────────────────────────────────────────────
// Helpers
// ─────────────────────────────────────────────────────────────────────────────
function eid() {
    return substr( md5( uniqid( mt_rand(), true ) ), 0, 7 );
}

function el_container( array $settings, array $elements ) {
    return [
        'id'       => eid(),
        'elType'   => 'container',
        'settings' => $settings,
        'elements' => $elements,
    ];
}

function el_widget( $type, array $settings ) {
    return [
        'id'         => eid(),
        'elType'     => 'widget',
        'widgetType' => $type,
        'settings'   => $settings,
        'elements'   => [],
    ];
}

function pad( $t, $r, $b, $l ) {
    return [ 'unit'=>'px', 'top'=>"$t", 'right'=>"$r", 'bottom'=>"$b", 'left'=>"$l", 'isLinked'=>false ];
}

function no_pad() {
    return pad( 0, 0, 0, 0 );
}

function margin( $t, $r, $b, $l ) {
    return [ 'unit'=>'px', 'top'=>"$t", 'right'=>"$r", 'bottom'=>"$b", 'left'=>"$l", 'isLinked'=>false ];
}

function px( $n ) {
    return [ 'unit'=>'px', 'size'=> $n ];
}

function em( $n ) {
    return [ 'unit'=>'em', 'size'=> $n ];
}

// Container externo (full-width, fundo, padding de seção)
function outer( $bg_color, $padding_v, array $elements ) {
    return el_container( [
        'content_width'         => 'full',
        'flex_direction'        => 'column',
        'align_items'           => 'center',
        'background_background' => 'classic',
        'background_color'      => $bg_color,
        'padding'               => pad( $padding_v, 40, $padding_v, 40 ),
        'gap'                   => [ 'unit'=>'px', 'isLinked'=>true, 'size'=>0 ],
    ], $elements );
}

// Container interno (max-width 1280px, centralizado, coluna)
function inner( array $elements, $gap = 0 ) {
    return el_container( [
        'content_width'  => 'full',
        'flex_direction' => 'column',
        'width'          => px( 1280 ),
        'align_self'     => 'center',
        'padding'        => no_pad(),
        'gap'            => [ 'unit'=>'px', 'isLinked'=>true, 'size'=> $gap ],
    ], $elements );
}

// Widget: eyebrow (texto dourado, caixa alta, pequeno)
function w_eyebrow( $text ) {
    global $BEV, $GOLD;
    return el_widget( 'heading', [
        'title'                     => $text,
        'header_size'               => 'p',
        'title_color'               => $GOLD,
        'typography_typography'     => 'custom',
        'typography_font_family'    => $BEV,
        'typography_font_weight'    => '700',
        'typography_font_size'      => px( 13 ),
        'typography_letter_spacing' => px( 2 ),
        'typography_text_transform' => 'uppercase',
        'typography_line_height'    => em( 1 ),
        '_margin'                   => margin( 0, 0, 14, 0 ),
    ] );
}

// Widget: título de seção (H2, branco, caixa alta, grande)
function w_section_head( $text, $mb = 36 ) {
    global $BEV, $WHITE;
    return el_widget( 'heading', [
        'title'                     => $text,
        'header_size'               => 'h2',
        'title_color'               => $WHITE,
        'typography_typography'     => 'custom',
        'typography_font_family'    => $BEV,
        'typography_font_weight'    => '800',
        'typography_font_size'      => px( 46 ),
        'typography_font_size_tablet' => px( 36 ),
        'typography_font_size_mobile' => px( 28 ),
        'typography_text_transform' => 'uppercase',
        'typography_line_height'    => em( 1.02 ),
        '_margin'                   => margin( 0, 0, $mb, 0 ),
    ] );
}

// Widget: imagem (placeholder editável)
function w_image() {
    return el_widget( 'image', [
        'image'      => [ 'url' => '', 'id' => '' ],
        'image_size' => 'full',
        'width'      => [ 'unit'=>'%', 'size'=> 100 ],
    ] );
}

// Container-foto: quadrado escuro com borda, recebe widget de imagem dentro
function photo_box( array $extra_settings = [] ) {
    global $CARD_BG;
    $base = [
        'content_width'         => 'full',
        'flex_direction'        => 'column',
        'justify_content'       => 'center',
        'align_items'           => 'center',
        'background_background' => 'classic',
        'background_color'      => $CARD_BG,
        'border_border'         => 'solid',
        'border_width'          => [ 'unit'=>'px','top'=>'1','right'=>'1','bottom'=>'1','left'=>'1','isLinked'=>true ],
        'border_color'          => 'rgba(255,255,255,0.09)',
        'border_radius'         => [ 'unit'=>'px','top'=>'8','right'=>'8','bottom'=>'8','left'=>'8','isLinked'=>true ],
        'padding'               => no_pad(),
        'min_height'            => px( 260 ),
    ];
    return el_container( array_merge( $base, $extra_settings ), [ w_image() ] );
}

// ─────────────────────────────────────────────────────────────────────────────
// SEÇÃO 1 — Hero
// ─────────────────────────────────────────────────────────────────────────────
$section_hero = outer( $BG2, 72, [
    inner( [
        w_eyebrow( 'Quem faz o festival' ),

        el_widget( 'heading', [
            'title'                       => 'Time',
            'header_size'                 => 'h1',
            'title_color'                 => $WHITE,
            'typography_typography'       => 'custom',
            'typography_font_family'      => $BEV,
            'typography_font_weight'      => '900',
            'typography_font_style'       => 'italic',
            'typography_text_transform'   => 'uppercase',
            'typography_font_size'        => px( 72 ),
            'typography_font_size_tablet' => px( 56 ),
            'typography_font_size_mobile' => px( 40 ),
            'typography_line_height'      => em( 0.98 ),
            '_margin'                     => margin( 0, 0, 22, 0 ),
        ] ),

        el_widget( 'text-editor', [
            'editor'                    => '<p>Curadores, produtores e a equipe que dá vida ao KOFF a cada edição.</p>',
            'text_color'                => $GREY,
            'typography_typography'     => 'custom',
            'typography_font_family'    => $MAN,
            'typography_font_size'      => px( 20 ),
            'typography_font_size_mobile' => px( 17 ),
            'typography_line_height'    => em( 1.65 ),
        ] ),
    ] ),
] );

// ─────────────────────────────────────────────────────────────────────────────
// SEÇÃO 2 — Curador em destaque
// ─────────────────────────────────────────────────────────────────────────────

// Lado direito do card: badge + nome + afiliação + bio
$curador_right = el_container( [
    'content_width'         => 'full',
    'flex_direction'        => 'column',
    'justify_content'       => 'center',
    'flex_size'             => 'grow',
    'background_background' => 'classic',
    'background_color'      => $CARD,
    'padding'               => pad( 40, 40, 40, 40 ),
    'gap'                   => [ 'unit'=>'px', 'isLinked'=>true, 'size'=>0 ],
], [

    // Badge "Curador-chefe"
    el_widget( 'heading', [
        'title'                     => 'Curador-chefe',
        'header_size'               => 'p',
        'title_color'               => $GOLD,
        'typography_typography'     => 'custom',
        'typography_font_family'    => $BEV,
        'typography_font_weight'    => '700',
        'typography_font_size'      => px( 12 ),
        'typography_text_transform' => 'uppercase',
        'typography_letter_spacing' => px( 2 ),
        'typography_line_height'    => em( 1 ),
        'background_background'     => 'classic',
        'background_color'          => 'rgba(255,220,66,0.12)',
        'border_border'             => 'solid',
        'border_width'              => [ 'unit'=>'px','top'=>'1','right'=>'1','bottom'=>'1','left'=>'1','isLinked'=>true ],
        'border_color'              => 'rgba(255,220,66,0.3)',
        'border_radius'             => px( 3 ),
        'padding'                   => pad( 6, 12, 6, 12 ),
        '_margin'                   => margin( 0, 0, 16, 0 ),
        'width'                     => [ 'unit'=>'%', 'size'=>'' ], // auto
    ] ),

    // Nome do curador
    el_widget( 'heading', [
        'title'                       => 'Prof. Dr. Rubens Rewald',
        'header_size'                 => 'h2',
        'title_color'                 => $WHITE,
        'typography_typography'       => 'custom',
        'typography_font_family'      => $BEV,
        'typography_font_weight'      => '900',
        'typography_font_size'        => px( 38 ),
        'typography_font_size_tablet' => px( 30 ),
        'typography_font_size_mobile' => px( 26 ),
        'typography_text_transform'   => 'uppercase',
        'typography_line_height'      => em( 1.05 ),
        '_margin'                     => margin( 0, 0, 6, 0 ),
    ] ),

    // Afiliação
    el_widget( 'heading', [
        'title'                     => 'Cineasta · Produtor · ECA/USP',
        'header_size'               => 'p',
        'title_color'               => $GOLD,
        'typography_typography'     => 'custom',
        'typography_font_family'    => $BEV,
        'typography_font_weight'    => '700',
        'typography_font_size'      => px( 14 ),
        'typography_text_transform' => 'uppercase',
        'typography_letter_spacing' => px( 1 ),
        'typography_line_height'    => em( 1 ),
        '_margin'                   => margin( 0, 0, 20, 0 ),
    ] ),

    // Bio
    el_widget( 'text-editor', [
        'editor'                    => '<p>Cineasta, produtor e professor da Escola de Comunicações e Artes da USP, responsável pela curadoria do festival. Conduz a seleção das mostras competitiva e não-competitiva, equilibrando consagrados e novos talentos do cinema sul-coreano e brasileiro.</p>',
        'text_color'                => $GREY,
        'typography_typography'     => 'custom',
        'typography_font_family'    => $MAN,
        'typography_font_size'      => px( 16 ),
        'typography_line_height'    => em( 1.7 ),
    ] ),
] );

// Lado esquerdo do card: foto (280px fixo)
$curador_left = el_container( [
    'content_width'         => 'full',
    'flex_direction'        => 'column',
    'justify_content'       => 'center',
    'align_items'           => 'center',
    'background_background' => 'classic',
    'background_color'      => $CARD_BG,
    'border_border'         => 'solid',
    'border_width'          => [ 'unit'=>'px','top'=>'0','right'=>'1','bottom'=>'0','left'=>'0','isLinked'=>false ],
    'border_color'          => 'rgba(255,255,255,0.09)',
    'width'                 => px( 280 ),
    'min_height'            => px( 280 ),
    'padding'               => no_pad(),
], [ w_image() ] );

// Card completo: linha com foto + conteúdo
$curador_card = el_container( [
    'content_width'         => 'full',
    'flex_direction'        => 'row',
    'flex_wrap'             => 'wrap',
    'background_background' => 'classic',
    'background_color'      => $CARD,
    'border_border'         => 'solid',
    'border_width'          => [ 'unit'=>'px','top'=>'1','right'=>'1','bottom'=>'1','left'=>'1','isLinked'=>true ],
    'border_color'          => 'rgba(255,255,255,0.09)',
    'border_radius'         => px( 8 ),
    'overflow'              => 'hidden',
    'padding'               => no_pad(),
    'gap'                   => [ 'unit'=>'px', 'isLinked'=>true, 'size'=>0 ],
], [ $curador_left, $curador_right ] );

$section_curadoria = outer( $BG, 48, [
    inner( [
        w_eyebrow( 'Curadoria' ),
        $curador_card,
    ], 0 ),
] );

// ─────────────────────────────────────────────────────────────────────────────
// SEÇÃO 3 — Grid da equipe (4 colunas × 2 linhas)
// ─────────────────────────────────────────────────────────────────────────────
$membros = [
    [ 'Ana Caldas',    'Direção-geral' ],
    [ 'Marco Yun',     'Produção executiva' ],
    [ 'Júlia Tavares', 'Curadoria assistente' ],
    [ 'Daniel Sato',   'Programação' ],
    [ 'Sofia Mendes',  'Comunicação' ],
    [ 'Pedro Lima',    'Imprensa' ],
    [ 'Hana Park',     'Relações internacionais' ],
    [ 'Rafael Brito',  'Audiovisual' ],
];

$person_cards = [];
foreach ( $membros as $m ) {
    $person_cards[] = el_container( [
        'content_width'  => 'full',
        'flex_direction' => 'column',
        'width'          => [ 'unit'=>'%', 'size'=> 23 ],
        'padding'        => no_pad(),
        'gap'            => [ 'unit'=>'px', 'isLinked'=>true, 'size'=>0 ],
    ], [
        // Foto
        photo_box( [ '_margin' => margin( 0, 0, 16, 0 ) ] ),

        // Nome
        el_widget( 'heading', [
            'title'                     => $m[0],
            'header_size'               => 'h3',
            'title_color'               => $WHITE,
            'typography_typography'     => 'custom',
            'typography_font_family'    => $BEV,
            'typography_font_weight'    => '800',
            'typography_font_size'      => px( 18 ),
            'typography_text_transform' => 'uppercase',
            'typography_line_height'    => em( 1.2 ),
            '_margin'                   => margin( 0, 0, 2, 0 ),
        ] ),

        // Cargo
        el_widget( 'heading', [
            'title'                  => $m[1],
            'header_size'            => 'p',
            'title_color'            => $GREY3,
            'typography_typography'  => 'custom',
            'typography_font_family' => $MAN,
            'typography_font_size'   => px( 14 ),
            'typography_line_height' => em( 1.4 ),
            '_margin'                => margin( 0, 0, 0, 0 ),
        ] ),
    ] );
}

// Grade: flex-wrap com 4 por linha, gap 22px
$grid = el_container( [
    'content_width'  => 'full',
    'flex_direction' => 'row',
    'flex_wrap'      => 'wrap',
    'gap'            => [ 'unit'=>'px', 'isLinked'=>false, 'row'=>'28', 'column'=>'22' ],
    'padding'        => no_pad(),
], $person_cards );

$section_equipe = outer( $BG2, 48, [
    inner( [
        w_eyebrow( 'Equipe' ),
        w_section_head( 'A equipe KOFF', 36 ),
        $grid,
    ], 0 ),
] );

// ─────────────────────────────────────────────────────────────────────────────
// Montar e salvar
// ─────────────────────────────────────────────────────────────────────────────
$elementor_data = wp_json_encode( [
    $section_hero,
    $section_curadoria,
    $section_equipe,
] );

// ── 1. Deletar autosaves e revisões do Elementor para esta página ────────────
// O Elementor salva rascunhos como posts de revisão. Sem isso, o editor
// carrega o conteúdo antigo em vez do novo.
$autosave = wp_get_post_autosave( $PAGE_ID );
if ( $autosave ) {
    wp_delete_post_revision( $autosave->ID );
    WP_CLI::log( "Autosave deletado (ID {$autosave->ID})." );
}

// Deletar também meta de draft do Elementor, se existir
delete_post_meta( $PAGE_ID, '_elementor_draft' );

// ── 2. Salvar o novo JSON como dado publicado ────────────────────────────────
// Apaga primeiro para evitar duplicatas, depois insere limpo.
delete_post_meta( $PAGE_ID, '_elementor_data' );
add_post_meta( $PAGE_ID, '_elementor_data', $elementor_data );

update_post_meta( $PAGE_ID, '_elementor_edit_mode', 'builder' );

// Garante que NÃO usa canvas (mantém header/footer do Elementor)
delete_post_meta( $PAGE_ID, '_elementor_template' );

// ── 3. Limpar todos os caches do Elementor ───────────────────────────────────
if ( class_exists( '\Elementor\Plugin' ) ) {
    \Elementor\Plugin::$instance->files_manager->clear_cache();
    WP_CLI::log( "Cache do Elementor limpo." );
}

// Limpar cache do LiteSpeed se ativo
if ( function_exists( 'do_action' ) ) {
    do_action( 'litespeed_purge_post', $PAGE_ID );
}

// ── 4. Verificação ───────────────────────────────────────────────────────────
$check = get_post_meta( $PAGE_ID, '_elementor_data', true );
if ( empty( $check ) ) {
    WP_CLI::error( "Algo deu errado — _elementor_data ficou vazio." );
} else {
    $decoded = json_decode( $check, true );
    $count   = is_array( $decoded ) ? count( $decoded ) : 0;
    WP_CLI::success( "Página Team (ID {$PAGE_ID}) atualizada com {$count} seções. Abra no Elementor para editar." );
}
