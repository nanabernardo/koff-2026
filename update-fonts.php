<?php
/**
 * KOFF — Atualiza Global Typography do Elementor para Helvetica Neue LT Pro
 *
 * Rodar via WP-CLI:
 *   wp eval-file wp-content/themes/koff/update-fonts.php
 *
 * O que faz:
 *  1. Atualiza elementor_kit_settings (Global Fonts do kit ativo)
 *  2. Limpa o cache do Elementor para regenerar os CSS
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$NEW_FONT   = 'Helvetica Neue LT Pro';
$NEW_FONT_E = $NEW_FONT; // sem encoding especial

/* ---------------------------------------------------------------
   1. Pegar o Kit ativo do Elementor
--------------------------------------------------------------- */
$kit_id = (int) get_option( 'elementor_active_kit' );
if ( ! $kit_id ) {
    WP_CLI::error( 'Kit ativo do Elementor não encontrado.' );
}
WP_CLI::log( "Kit ativo: ID $kit_id" );

$kit_settings = get_post_meta( $kit_id, '_elementor_page_settings', true );
if ( ! is_array( $kit_settings ) ) {
    $kit_settings = [];
}

/* ---------------------------------------------------------------
   2. Substituir fontes nos grupos de tipografia global
   Grupos padrão: system_typography (array com primary, secondary, text, accent)
--------------------------------------------------------------- */
$changed = 0;

// system_typography é um array de grupos tipográficos
if ( isset( $kit_settings['system_typography'] ) && is_array( $kit_settings['system_typography'] ) ) {
    foreach ( $kit_settings['system_typography'] as &$group ) {
        if ( isset( $group['typography_font_family'] ) && ! empty( $group['typography_font_family'] ) ) {
            $old = $group['typography_font_family'];
            $group['typography_font_family'] = $NEW_FONT;

            // Ajusta weight: Be Vietnam Pro 900/800 → 700, 600/500 → 500, resto → mantém se disponível
            if ( isset( $group['typography_font_weight'] ) ) {
                $w = (int) $group['typography_font_weight'];
                if ( $w >= 800 ) $group['typography_font_weight'] = '700';
                elseif ( $w >= 600 ) $group['typography_font_weight'] = '500';
                elseif ( $w <= 200 ) $group['typography_font_weight'] = '300';
            }

            WP_CLI::log( "  typography[$changed]: '$old' → '$NEW_FONT'" );
            $changed++;
        }
    }
    unset( $group );
}

// custom_typography (fontes globais customizadas adicionadas pelo usuário)
if ( isset( $kit_settings['custom_typography'] ) && is_array( $kit_settings['custom_typography'] ) ) {
    foreach ( $kit_settings['custom_typography'] as &$group ) {
        if ( isset( $group['typography_font_family'] ) && ! empty( $group['typography_font_family'] ) ) {
            $old = $group['typography_font_family'];
            $group['typography_font_family'] = $NEW_FONT;
            WP_CLI::log( "  custom_typography: '$old' → '$NEW_FONT'" );
            $changed++;
        }
    }
    unset( $group );
}

if ( $changed === 0 ) {
    WP_CLI::log( '— Nenhum grupo de tipografia encontrado no kit. Verifique se o kit está configurado.' );
} else {
    update_post_meta( $kit_id, '_elementor_page_settings', $kit_settings );
    WP_CLI::log( "✓ $changed grupo(s) de tipografia atualizados no kit." );
}

/* ---------------------------------------------------------------
   3. Atualizar elementor_kit_settings na wp_options (fallback)
--------------------------------------------------------------- */
$opt = get_option( 'elementor_kit_settings' );
if ( is_array( $opt ) ) {
    $updated = false;
    array_walk_recursive( $opt, function( &$val, $key ) use ( $NEW_FONT, &$updated ) {
        if ( $key === 'font_family' || $key === 'typography_font_family' ) {
            if ( ! empty( $val ) && $val !== $NEW_FONT ) {
                $val     = $NEW_FONT;
                $updated = true;
            }
        }
    });
    if ( $updated ) {
        update_option( 'elementor_kit_settings', $opt );
        WP_CLI::log( '✓ elementor_kit_settings (wp_options) atualizado.' );
    }
}

/* ---------------------------------------------------------------
   4. Limpar cache do Elementor
--------------------------------------------------------------- */
if ( class_exists( '\Elementor\Plugin' ) ) {
    \Elementor\Plugin::$instance->files_manager->clear_cache();
    WP_CLI::log( '✓ Cache do Elementor limpo.' );
}

WP_CLI::success( 'Global Typography atualizado para Helvetica Neue LT Pro. Acesse o Elementor → Site Settings → Typography para confirmar.' );
