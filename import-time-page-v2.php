<?php
/**
 * KOFF — Página Time / Equipe (ID 469)
 * Versão 2: estrutura limpa, sem containers desnecessários.
 *
 * Rodar via WP-CLI:
 *   wp eval-file wp-content/themes/koff/import-time-page-v2.php
 *
 * Cada seção principal é um único Container com content_width=boxed.
 * Nenhum "wrap" extra — o Elementor já centraliza o conteúdo.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$PAGE_ID = 469;

/* ---------------------------------------------------------------
   Helpers
--------------------------------------------------------------- */

/** ID único para elemento Elementor (8 chars hex) */
function eid2() {
    return substr( md5( uniqid( '', true ) ), 0, 8 );
}

/** Cria um Container (flexbox) */
function el_c( array $settings, array $children = [] ): array {
    return [
        'id'       => eid2(),
        'elType'   => 'container',
        'settings' => $settings,
        'elements' => $children,
        'isInner'  => false,
    ];
}

/** Cria um Widget */
function el_w( string $type, array $settings ): array {
    return [
        'id'         => eid2(),
        'elType'     => 'widget',
        'widgetType' => $type,
        'settings'   => $settings,
        'elements'   => [],
    ];
}

/** Retorna settings base de tipografia Be Vietnam Pro */
function typo( int $size, string $weight = '700', string $unit = 'px', string $transform = 'none' ): array {
    return [
        'typography_typography'       => 'custom',
        'typography_font_family'      => 'Be Vietnam Pro',
        'typography_font_weight'      => $weight,
        'typography_font_size'        => [ 'unit' => $unit, 'size' => $size ],
        'typography_text_transform'   => $transform,
    ];
}

/** Padding shorthand [top, right, bottom, left] */
function pad( int $t, int $r, int $b, int $l, string $unit = 'px' ): array {
    return [ 'unit' => $unit, 'top' => "$t", 'right' => "$r", 'bottom' => "$b", 'left' => "$l", 'isLinked' => false ];
}

/* ---------------------------------------------------------------
   Constantes de cor
--------------------------------------------------------------- */
const C_BG     = '#131313';
const C_BG2    = '#1A1A1A';
const C_CARD   = '#1E1E1E';
const C_WHITE  = '#FFFFFF';
const C_GOLD   = '#FFDC42';
const C_MUTED  = '#999999';
const C_PH     = '#2A2A2A';  // placeholder foto

/* ---------------------------------------------------------------
   SEÇÃO 1 — HERO
--------------------------------------------------------------- */
$hero = el_c([
    'content_width'    => 'boxed',
    'flex_direction'   => 'column',
    'gap'              => [ 'unit' => 'px', 'column' => '0', 'row' => '16', 'isLinked' => false ],
    'padding'          => pad( 80, 0, 80, 0 ),
    'background_color' => C_BG,
], [

    // Eyebrow
    el_w('heading', array_merge([
        'title'       => 'Quem faz o festival',
        'header_size' => 'p',
        'align'       => 'left',
        'title_color' => C_GOLD,
        '_margin'     => pad( 0, 0, 8, 0 ),
    ], typo( 13, '700', 'px', 'uppercase' ), [
        'typography_letter_spacing' => [ 'unit' => 'em', 'size' => 0.1 ],
    ])),

    // Título H1
    el_w('heading', array_merge([
        'title'       => 'Time',
        'header_size' => 'h1',
        'align'       => 'left',
        'title_color' => C_WHITE,
    ], typo( 60, '900', 'px', 'uppercase' ))),

    // Lead
    el_w('text-editor', [
        'editor'      => '<p style="color:#CCCCCC;font-size:18px;line-height:1.6;">Curadores, produtores e a equipe que dá vida ao KOFF a cada edição.</p>',
    ]),

]);

/* ---------------------------------------------------------------
   SEÇÃO 2 — CURADORIA EM DESTAQUE
--------------------------------------------------------------- */

// Coluna esquerda: placeholder de foto
$col_foto = el_c([
    'width'            => [ 'unit' => 'px', 'size' => 280 ],
    'min_height'       => [ 'unit' => 'px', 'size' => 280 ],
    'flex_direction'   => 'column',
    'align_items'      => 'center',
    'justify_content'  => 'center',
    'background_color' => C_PH,
], [
    el_w('heading', [
        'title'       => 'FOTO',
        'header_size' => 'p',
        'align'       => 'center',
        'title_color' => '#555555',
    ]),
]);

// Coluna direita: textos do curador
$col_texto = el_c([
    'flex_direction'  => 'column',
    'flex'            => '1',
    'gap'             => [ 'unit' => 'px', 'column' => '0', 'row' => '12', 'isLinked' => false ],
    'padding'         => pad( 36, 36, 36, 36 ),
], [

    // Badge/cargo
    el_w('heading', array_merge([
        'title'       => 'Curador-chefe',
        'header_size' => 'p',
        'align'       => 'left',
        'title_color' => C_GOLD,
    ], typo( 12, '700', 'px', 'uppercase' ), [
        'typography_letter_spacing' => [ 'unit' => 'em', 'size' => 0.08 ],
    ])),

    // Nome
    el_w('heading', array_merge([
        'title'       => 'Prof. Dr. Rubens Rewald',
        'header_size' => 'h2',
        'align'       => 'left',
        'title_color' => C_WHITE,
    ], typo( 34, '900', 'px', 'uppercase' ))),

    // Afiliação
    el_w('heading', array_merge([
        'title'       => 'Cineasta · Produtor · ECA/USP',
        'header_size' => 'p',
        'align'       => 'left',
        'title_color' => C_GOLD,
    ], typo( 14, '700', 'px', 'uppercase' ), [
        'typography_letter_spacing' => [ 'unit' => 'em', 'size' => 0.06 ],
    ])),

    // Bio
    el_w('text-editor', [
        'editor' => '<p style="color:#BBBBBB;font-size:16px;line-height:1.7;">Cineasta, produtor e professor da Escola de Comunicações e Artes da USP, responsável pela curadoria do festival. Conduz a seleção das mostras competitiva e não-competitiva, equilibrando consagrados e novos talentos do cinema sul-coreano e brasileiro.</p>',
    ]),

]);

// Card (linha foto + texto)
$card = el_c([
    'flex_direction'   => 'row',
    'align_items'      => 'stretch',
    'background_color' => C_CARD,
    'border_radius'    => [ 'unit' => 'px', 'top' => '12', 'right' => '12', 'bottom' => '12', 'left' => '12', 'isLinked' => true ],
    'overflow'         => 'hidden',
], [
    $col_foto,
    $col_texto,
]);

$curadoria = el_c([
    'content_width'    => 'boxed',
    'flex_direction'   => 'column',
    'gap'              => [ 'unit' => 'px', 'column' => '0', 'row' => '24', 'isLinked' => false ],
    'padding'          => pad( 80, 0, 80, 0 ),
    'background_color' => C_BG,
], [

    // Eyebrow
    el_w('heading', array_merge([
        'title'       => 'Curadoria',
        'header_size' => 'p',
        'align'       => 'left',
        'title_color' => C_GOLD,
    ], typo( 13, '700', 'px', 'uppercase' ), [
        'typography_letter_spacing' => [ 'unit' => 'em', 'size' => 0.1 ],
    ])),

    $card,

]);

/* ---------------------------------------------------------------
   SEÇÃO 3 — GRID DA EQUIPE
--------------------------------------------------------------- */

$members = [
    [ 'Ana Caldas',    'Direção-geral' ],
    [ 'Marco Yun',     'Produção executiva' ],
    [ 'Júlia Tavares', 'Curadoria assistente' ],
    [ 'Daniel Sato',   'Programação' ],
    [ 'Sofia Mendes',  'Comunicação' ],
    [ 'Pedro Lima',    'Imprensa' ],
    [ 'Hana Park',     'Relações internacionais' ],
    [ 'Rafael Brito',  'Audiovisual' ],
];

// Cada card de membro
$member_cards = [];
foreach ( $members as [ $nome, $cargo ] ) {
    $member_cards[] = el_c([
        'flex_direction'   => 'column',
        'width'            => [ 'unit' => '%', 'size' => 25 ],
        'padding'          => pad( 0, 12, 0, 12 ),
    ], [

        // Placeholder foto quadrada
        el_c([
            'background_color' => C_PH,
            'min_height'       => [ 'unit' => 'px', 'size' => 200 ],
            'border_radius'    => [ 'unit' => 'px', 'top' => '8', 'right' => '8', 'bottom' => '8', 'left' => '8', 'isLinked' => true ],
            '_margin'          => pad( 0, 0, 16, 0 ),
            'align_items'      => 'center',
            'justify_content'  => 'center',
        ], [
            el_w('heading', [
                'title'       => 'FOTO',
                'header_size' => 'p',
                'align'       => 'center',
                'title_color' => '#555555',
            ]),
        ]),

        // Nome
        el_w('heading', array_merge([
            'title'       => strtoupper( $nome ),
            'header_size' => 'h4',
            'align'       => 'left',
            'title_color' => C_WHITE,
            '_margin'     => pad( 0, 0, 4, 0 ),
        ], typo( 17, '800', 'px', 'uppercase' ))),

        // Cargo
        el_w('heading', [
            'title'       => $cargo,
            'header_size' => 'p',
            'align'       => 'left',
            'title_color' => C_MUTED,
            'typography_typography'  => 'custom',
            'typography_font_size'   => [ 'unit' => 'px', 'size' => 14 ],
        ]),

    ]);
}

// Grid 4 colunas (flex wrap)
$grid = el_c([
    'flex_direction' => 'row',
    'flex_wrap'      => 'wrap',
    'gap'            => [ 'unit' => 'px', 'row' => '40', 'column' => '0', 'isLinked' => false ],
], $member_cards );

$equipe = el_c([
    'content_width'    => 'boxed',
    'flex_direction'   => 'column',
    'gap'              => [ 'unit' => 'px', 'column' => '0', 'row' => '40', 'isLinked' => false ],
    'padding'          => pad( 80, 0, 100, 0 ),
    'background_color' => C_BG2,
], [

    // Eyebrow
    el_w('heading', array_merge([
        'title'       => 'Equipe',
        'header_size' => 'p',
        'align'       => 'left',
        'title_color' => C_GOLD,
    ], typo( 13, '700', 'px', 'uppercase' ), [
        'typography_letter_spacing' => [ 'unit' => 'em', 'size' => 0.1 ],
    ])),

    // Título da seção
    el_w('heading', array_merge([
        'title'       => 'A equipe KOFF',
        'header_size' => 'h2',
        'align'       => 'left',
        'title_color' => C_WHITE,
        '_margin'     => pad( 0, 0, 0, 0 ),
    ], typo( 38, '900', 'px', 'uppercase' ))),

    $grid,

]);

/* ---------------------------------------------------------------
   MONTAR JSON FINAL
--------------------------------------------------------------- */
$page_data = [ $hero, $curadoria, $equipe ];
$json      = wp_json_encode( $page_data );

/* ---------------------------------------------------------------
   APLICAR NO BANCO DE DADOS
--------------------------------------------------------------- */

// 1. Deletar autosave (causa do editor mostrar versão antiga)
$autosave = wp_get_post_autosave( $PAGE_ID );
if ( $autosave ) {
    wp_delete_post_revision( $autosave->ID );
    WP_CLI::log( '✓ Autosave deletado (ID ' . $autosave->ID . ')' );
} else {
    WP_CLI::log( '— Nenhum autosave encontrado' );
}

// 2. Limpar draft do Elementor
delete_post_meta( $PAGE_ID, '_elementor_draft' );
WP_CLI::log( '✓ Draft do Elementor removido' );

// 3. Garantir que não há template canvas
delete_post_meta( $PAGE_ID, '_elementor_template' );
WP_CLI::log( '✓ Template canvas removido' );

// 4. Substituir _elementor_data
delete_post_meta( $PAGE_ID, '_elementor_data' );
$result = add_post_meta( $PAGE_ID, '_elementor_data', $json );
if ( $result ) {
    WP_CLI::log( '✓ _elementor_data gravado (' . strlen( $json ) . ' chars)' );
} else {
    WP_CLI::error( 'Falha ao gravar _elementor_data — verifique o PAGE_ID' );
}

// 5. Garantir modo builder
update_post_meta( $PAGE_ID, '_elementor_edit_mode', 'builder' );
WP_CLI::log( '✓ Modo builder ativado' );

// 6. Limpar cache do Elementor
if ( class_exists( '\Elementor\Plugin' ) ) {
    \Elementor\Plugin::$instance->files_manager->clear_cache();
    WP_CLI::log( '✓ Cache do Elementor limpo' );
}

WP_CLI::success( 'Pronto! Página ' . $PAGE_ID . ' atualizada com 3 seções: Hero + Curadoria + Equipe.' );
