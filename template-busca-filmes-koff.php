<?php
/**
 * Template Name: Busca de Filmes KOFF
 *
 * Página "Busca de Filmes" do festival KOFF. 100% código, sem
 * Elementor (substitui a versão que existia em Elementor). Reaproveita
 * a estética do koff.css (classes .pagehero, .wrap, .crumbs, .eyebrow,
 * .lead, .section, .grid.g-5, .card, .ph.ph-2x3, .tag, .btn.btn-ghost)
 * e os tokens de cor (--gold, --gold-deep, --card, --bg-3, --line-2,
 * --fg, --fg-3, --ink), sem redefini-los — já são carregados
 * globalmente via koff_enqueue() em functions.php.
 *
 * Fonte dos dados: CPT "filmes" (JetEngine), via busca por título
 * (post_title) OU pelo meta "direction" (diretor) — TODOS os filmes
 * publicados desta edição (post_date depois de 02/07/2026, mesmo
 * corte usado na Mostra Competitiva), sem filtrar por "competitive"
 * nem "archived" (escopo confirmado com o usuário).
 *
 * A página carrega sem nenhum resultado (nenhuma WP_Query roda no
 * primeiro load). Toda a busca acontece via AJAX depois que o usuário
 * digita e clica em "Buscar" (ou aperta Enter) — sem recarregar a
 * página e sem busca a cada tecla digitada. A lógica de query e a
 * renderização do card vivem em functions.php
 * (koff_busca_encontrar_ids / koff_fmc_render_card), porque também
 * são usadas pelo handler AJAX (koff_ajax_busca_filmes), que roda via
 * admin-ajax.php e não tem acesso a este arquivo de template.
 *
 * Campo do formulário usa name="termo" (não "s"): "s" é reservado
 * pelo WordPress como parâmetro nativo de busca e, numa URL de Página
 * customizada, pode fazer o WordPress carregar search.php em vez
 * deste Page Template.
 *
 * Estilo do próprio formulário de busca (poster do input/botão) parte
 * do snippet original em Elementor (buscador-filme.html), mas trocando
 * as cores hex fixas de lá pelos tokens do koff.css (--gold, --card,
 * --line-2, --ink etc.) em vez de hardcodar. O input de texto não
 * tinha estilo definido no snippet original (só o <select> e o
 * botão tinham); foi estilizado aqui reaproveitando os mesmos tokens
 * do botão/card pra ficar visualmente consistente.
 */

get_header();
?>

<section class="pagehero">
    <div class="wrap">
        <nav class="crumbs">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Início</a><span class="sep">/</span><span>Busca de Filmes</span>
        </nav>
        <p class="eyebrow">Edição 2026</p>
        <h1>Busca de Filmes</h1>
        <p class="lead">Encontre filmes da 4ª edição do Koff pelo título ou nome do diretor</p>
    </div>
</section>

<section class="section">
    <div class="wrap">
        <form class="koff-busca-form" id="koff-busca-form" autocomplete="off">
            <input type="text" name="termo" id="koff-busca-input" placeholder="Digite o nome do filme ou do diretor...">
            <button type="submit">Buscar</button>
        </form>

        <p class="koff-busca-status" id="koff-busca-status">Digite pelo menos <?php echo (int) KOFF_BUSCA_MIN_CHARS; ?> caracteres e clique em Buscar.</p>

        <div class="grid g-5" id="koff-busca-grid" style="margin-top:32px"></div>

        <div style="text-align:center;margin-top:48px">
            <button type="button" class="btn btn-ghost" id="koff-busca-load-more" data-offset="0" hidden>Carregar mais</button>
        </div>
    </div>
</section>

<style>
/* Formulário de busca — usa os tokens do koff.css (--gold, --card,
   --line-2 etc.) em vez das cores hex fixas do snippet original em
   Elementor (buscador-filme.html). */
.koff-busca-form{display:flex;gap:12px;flex-wrap:wrap;align-items:stretch}
.koff-busca-form input[type="text"]{
    flex:1 1 320px;min-width:0;background:var(--card);border:1px solid var(--line-2);
    border-radius:var(--radius);padding:14px 16px;color:var(--fg);
    font-family:var(--body);font-size:16px;
}
.koff-busca-form input[type="text"]:focus{outline:none;border-color:var(--gold)}
.koff-busca-form button{
    display:inline-flex;align-items:center;gap:10px;font-family:var(--head);
    font-weight:500;font-size:14px;letter-spacing:.12em;text-transform:uppercase;
    padding:14px 28px;border-radius:var(--radius);border:1.5px solid var(--gold);
    background:var(--gold);color:var(--ink);white-space:nowrap;
    transition:background .2s ease,border-color .2s ease,transform .15s ease;
}
.koff-busca-form button:hover{background:var(--gold-deep);border-color:var(--gold-deep)}
.koff-busca-form button:active{transform:translateY(1px)}

.koff-busca-status{color:var(--fg-3);font-size:14px;margin-top:16px}

/* Card do filme: mesma neutralização do placeholder estático usada em
   template-filmes-competitiva-koff.php, aqui escopada pra
   #koff-busca-grid. As classes .koff-fmc-body/.koff-fmc-title/
   .koff-fmc-direction vêm de koff_fmc_render_card() (functions.php),
   reaproveitada por esta página. */
#koff-busca-grid .card .ph{display:block;background:var(--bg-3)}
#koff-busca-grid .card .ph::after{content:none}
#koff-busca-grid .card .ph img{width:100%;height:100%;object-fit:cover;display:block}

.koff-fmc-body{padding:14px}
.koff-fmc-body .tag{font-size:10px;padding:3px 8px}
.koff-fmc-title{
    font-family:var(--head);font-weight:500;text-transform:uppercase;
    font-size:15px;margin-top:9px;color:var(--fg);
}
.koff-fmc-direction{color:var(--fg-3);font-size:12.5px;margin-top:2px}

#koff-busca-load-more[disabled]{opacity:.5;cursor:default}

/* .btn tem display:inline-flex fixo, que empata em especificidade com
   a regra [hidden] do navegador e vence (regra de autor sempre bate
   regra padrão em empate) — sem isso, o atributo "hidden" do botão
   fica sem efeito visual e ele nunca some. */
#koff-busca-load-more[hidden]{display:none!important}

@media (max-width:760px){
    .koff-busca-form{flex-direction:column}
    /* Em flex-direction:column o eixo principal vira vertical, então o
       "320px" de flex:1 1 320px (definido lá em cima pro desktop) passa
       a valer como ALTURA em vez de largura — é isso que deixava o
       campo um quadrado gigante no mobile. Resetando o flex-basis pra
       "auto" aqui, a altura volta a ser só o padding/conteúdo. */
    .koff-busca-form input[type="text"]{flex:0 0 auto;width:100%}
    /* O botão é inline-flex (pra centralizar o texto verticalmente),
       mas sem justify-content ele fica alinhado à esquerda quando vira
       width:100% no mobile — daí o "Buscar" grudado na borda. */
    .koff-busca-form button{width:100%;justify-content:center}
}
</style>

<script>
(function () {
    var form   = document.getElementById('koff-busca-form');
    var input  = document.getElementById('koff-busca-input');
    var status = document.getElementById('koff-busca-status');
    var grid   = document.getElementById('koff-busca-grid');
    var btn    = document.getElementById('koff-busca-load-more');
    if (!form || !input || !grid || !btn) return;

    var ajaxUrl    = <?php echo wp_json_encode( admin_url( 'admin-ajax.php' ) ); ?>;
    var nonce      = <?php echo wp_json_encode( wp_create_nonce( KOFF_BUSCA_NONCE_ACTION ) ); ?>;
    var perPage    = <?php echo (int) KOFF_BUSCA_PER_PAGE; ?>;
    var minChars   = <?php echo (int) KOFF_BUSCA_MIN_CHARS; ?>;
    var termoAtual = '';

    function buscar(termo, offset, reset) {
        var body = new URLSearchParams();
        body.set('action', 'koff_busca_filmes');
        body.set('nonce', nonce);
        body.set('termo', termo);
        body.set('offset', String(offset));

        return fetch(ajaxUrl, {
            method: 'POST',
            credentials: 'same-origin',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: body.toString()
        })
            .then(function (r) { return r.json(); })
            .then(function (res) {
                if (!res || !res.success || !res.data) {
                    status.textContent = 'Não foi possível buscar agora. Tente novamente.';
                    btn.hidden = true;
                    return;
                }

                if (reset) {
                    grid.innerHTML = '';
                }
                if (res.data.html) {
                    grid.insertAdjacentHTML('beforeend', res.data.html);
                }

                status.textContent = (res.data.found === 0) ? 'Nenhum filme encontrado para a busca.' : '';

                btn.setAttribute('data-offset', String(offset + perPage));
                btn.hidden = !res.data.has_more;
            })
            .catch(function () {
                status.textContent = 'Não foi possível buscar agora. Tente novamente.';
                btn.hidden = true;
            });
    }

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        var termo = input.value.trim();

        if (termo.length < minChars) {
            status.textContent = 'Digite pelo menos ' + minChars + ' caracteres e clique em Buscar.';
            grid.innerHTML = '';
            btn.hidden = true;
            return;
        }

        termoAtual = termo;
        status.textContent = 'Buscando...';
        btn.hidden = true;
        buscar(termoAtual, 0, true);
    });

    btn.addEventListener('click', function () {
        var offset = parseInt(btn.getAttribute('data-offset'), 10) || 0;
        var originalText = btn.textContent;

        btn.disabled = true;
        btn.textContent = 'Carregando...';

        buscar(termoAtual, offset, false).finally(function () {
            btn.disabled = false;
            btn.textContent = originalText;
        });
    });
})();
</script>

<?php get_footer(); ?>
