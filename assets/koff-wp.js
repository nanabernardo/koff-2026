/* ============================================================
   KOFF — Interações para WordPress
   Versão adaptada do koff.js original.
   O header/footer são gerenciados pelo Elementor Pro — este
   arquivo cuida apenas das interações de página.
   Sem dependências externas.
   ============================================================ */
(function () {
  'use strict';

  /* ----------------------------------------------------------
     Tabs: container [data-tabs], botões [data-tab="id"],
     painéis [data-panel="id"]
  ---------------------------------------------------------- */
  function wireTabs() {
    document.querySelectorAll('[data-tabs]').forEach(function (group) {
      var tabs  = group.querySelectorAll('[data-tab]');
      var scopeSel = group.getAttribute('data-tabs-panels');
      var scope = scopeSel ? document.querySelector(scopeSel) : document;

      tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
          var id = tab.getAttribute('data-tab');

          tabs.forEach(function (t) {
            t.setAttribute('aria-selected', t === tab ? 'true' : 'false');
          });

          scope.querySelectorAll('[data-panel]').forEach(function (p) {
            p.hidden = p.getAttribute('data-panel') !== id;
          });

          if (group.hasAttribute('data-scroll')) {
            window.scrollTo({ top: 0, behavior: 'smooth' });
          }
        });
      });
    });
  }

  /* ----------------------------------------------------------
     Filtros: container [data-filter-group][data-filter-list="#id"]
     botões [data-filter="valor"], itens [data-cat="valor valor"]
  ---------------------------------------------------------- */
  function wireFilters() {
    document.querySelectorAll('[data-filter-group]').forEach(function (group) {
      var btns    = group.querySelectorAll('[data-filter]');
      var listSel = group.getAttribute('data-filter-list');
      var list    = listSel ? document.querySelector(listSel) : null;

      btns.forEach(function (btn) {
        btn.addEventListener('click', function () {
          var val = btn.getAttribute('data-filter');

          btns.forEach(function (b) {
            b.setAttribute('aria-pressed', b === btn ? 'true' : 'false');
          });

          if (!list) return;

          list.querySelectorAll('[data-cat]').forEach(function (item) {
            var cats = item.getAttribute('data-cat').split(' ');
            item.style.display = (val === 'all' || cats.indexOf(val) > -1) ? '' : 'none';
          });

          var counter = group.querySelector('[data-count]');
          if (counter) {
            var visible = list.querySelectorAll('[data-cat]:not([style*="none"])').length;
            counter.textContent = visible;
          }
        });
      });
    });
  }

  /* ----------------------------------------------------------
     Seletor de cidade: <select data-city-selector>
     troca painéis [data-city="valor"]
  ---------------------------------------------------------- */
  function wireCitySelector() {
    document.querySelectorAll('[data-city-selector]').forEach(function (sel) {
      sel.addEventListener('change', function () {
        var v = sel.value;
        document.querySelectorAll('[data-city]').forEach(function (p) {
          p.hidden = p.getAttribute('data-city') !== v;
        });
      });
    });
  }

  /* ----------------------------------------------------------
     Arquivo: sincroniza o painel mega-menu com o ano/link atual
     (para páginas que usam data-nav="arquivo")
  ---------------------------------------------------------- */
  function wireArchive() {
    var panel = document.querySelector('.mega-panel');
    if (!panel) return;

    var page = (window.location.pathname.split('/').pop() || '').toLowerCase();
    var activeLinkKey = 'winners';
    if (page.indexOf('debate') > -1)         activeLinkKey = 'debates';
    else if (page.indexOf('filme') > -1)     activeLinkKey = 'filmes';
    else if (page.indexOf('programa') > -1)  activeLinkKey = 'programacao';
    else if (page.indexOf('workshop') > -1)  activeLinkKey = 'workshops';

    var storedYear  = sessionStorage.getItem('koff_archive_year');
    var activeYear  = storedYear || (activeLinkKey === 'workshops' ? '2023' : '2025');

    function applyState(year, linkKey) {
      panel.querySelectorAll('.mega-col').forEach(function (col) {
        col.classList.toggle('active', col.getAttribute('data-year') === year);
      });
      panel.querySelectorAll('.mega-link').forEach(function (a) {
        var inCol = a.closest('.mega-col').getAttribute('data-year') === year;
        a.classList.toggle('active', inCol && a.getAttribute('data-link-key') === linkKey);
      });
    }

    applyState(activeYear, activeLinkKey);

    panel.querySelectorAll('.mega-year').forEach(function (yel) {
      yel.style.cursor = 'pointer';
      yel.addEventListener('click', function () {
        var col   = yel.closest('.mega-col');
        var year  = col.getAttribute('data-year');
        var first = col.querySelector('.mega-link');
        sessionStorage.setItem('koff_archive_year', year);
        if (first) window.location.href = first.getAttribute('href');
      });
    });

    panel.querySelectorAll('.mega-link').forEach(function (a) {
      a.addEventListener('click', function () {
        var col  = a.closest('.mega-col');
        var year = col.getAttribute('data-year');
        sessionStorage.setItem('koff_archive_year', year);
      });
    });

    // Lê #year= do hash e atualiza eyebrow/breadcrumb
    var hashParams = new URLSearchParams(window.location.hash.replace('#', ''));
    var urlYear = hashParams.get('year');
    if (urlYear) {
      sessionStorage.setItem('koff_archive_year', urlYear);
      applyState(urlYear, activeLinkKey);

      document.querySelectorAll('.eyebrow, .pagehero .eyebrow').forEach(function (el) {
        el.textContent = el.textContent.replace(/20\d\d/, urlYear);
      });
      document.querySelectorAll('.crumbs span, .crumbs a').forEach(function (el) {
        if (/KOFF 20\d\d/.test(el.textContent)) {
          el.textContent = el.textContent.replace(/20\d\d/, urlYear);
        }
      });
    }
  }

  /* ----------------------------------------------------------
     Formulários demo (evita reload em protótipos)
  ---------------------------------------------------------- */
  function wireForms() {
    document.querySelectorAll('form[data-demo]').forEach(function (f) {
      f.addEventListener('submit', function (e) {
        e.preventDefault();
        var note = f.querySelector('[data-form-note]');
        if (note) note.hidden = false;
        f.reset();
      });
    });
  }

  /* ----------------------------------------------------------
     Scroll spy: índice de regulamento
     Lista #indice — seções: intro, org, datas, prog, prem,
                              inscri, selec, forma, uso, arqui
  ---------------------------------------------------------- */
  function wireRegNav() {
    var nav = document.getElementById('indice');
    if (!nav) return;

    var sectionIds = ['intro','org','datas','prog','prem','inscri','selec','forma','uso','arqui'];
    var links = nav.querySelectorAll('a');

    // Associa cada link ao ID da seção pela ordem
    var pairs = [];
    links.forEach(function(link, i) {
      var id = sectionIds[i];
      if (!id) return;
      pairs.push({ link: link, section: document.getElementById(id) });
    });

    function setActive(activeLink) {
      links.forEach(function(l) {
        var icon = l.querySelector('i, svg, span.elementor-icon-list-icon, .elementor-icon-list-icon i');
        if (icon) icon.style.color = '';
        l.style.color = '';
      });
      if (!activeLink) return;
      var icon = activeLink.querySelector('i, svg, span.elementor-icon-list-icon, .elementor-icon-list-icon i');
      if (icon) icon.style.color = '#E3C426';
    }

    // Clique imediato
    pairs.forEach(function(pair) {
      pair.link.addEventListener('click', function() {
        setActive(pair.link);
      });
    });

    // Scroll spy
    window.addEventListener('scroll', function() {
      var offset = 140;
      var current = null;
      pairs.forEach(function(pair) {
        if (!pair.section) return;
        if (pair.section.getBoundingClientRect().top <= offset) {
          current = pair;
        }
      });
      setActive(current ? current.link : null);
    }, { passive: true });

    // Estado inicial
    if (pairs.length) setActive(pairs[0].link);
  }

  /* ----------------------------------------------------------
     Init
  ---------------------------------------------------------- */
  function init() {
    wireTabs();
    wireFilters();
    wireCitySelector();
    wireArchive();
    wireForms();
    wireRegNav();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
