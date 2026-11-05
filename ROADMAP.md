# KOFF WordPress — Roadmap de implementação

> **Como usar este documento:** siga as fases em ordem. Não pule para conteúdo dinâmico antes de terminar a infraestrutura — você vai precisar retrabalhar.

---

## Legenda de complexidade
- 🟢 Fácil — só Elementor, sem dependências
- 🟡 Médio — precisa de plugin ou configuração extra
- 🔴 Difícil — depende de CPT + JetEngine Listing

---

## FASE 0 — Infraestrutura ✅ (já feito)
- [x] Child theme (koff / hello-elementor)
- [x] koff.css com design tokens
- [x] koff-wp.js com interações
- [x] JetEngine instalado
- [x] CPT "Filmes" criado

---

## FASE 1 — Header & Footer (global)
> Faça isso antes de qualquer página. Esses componentes aparecem em todo o site.

| O que fazer | Onde no WP | Complexidade |
|---|---|---|
| Criar template de Header no Elementor Theme Builder | Templates → Theme Builder → Header | 🟡 |
| Montar navegação principal (mega menu do `Home.html`) | Dentro do header | 🟡 |
| Criar template de Footer | Templates → Theme Builder → Footer | 🟢 |
| Configurar condições de exibição (todas as páginas) | Nas configurações de cada template | 🟢 |

**Referência visual:** seção `<header>` do `Home.html` e `<footer>` de qualquer .html.

---

## FASE 2 — Páginas estáticas (sem CMS dinâmico)
> Conteúdo fixo — você edita diretamente no Elementor, sem precisar de CPT ou banco de dados.

| Página | Arquivo HTML | O que montar | Complexidade |
|---|---|---|---|
| **Time / Equipe** | `Time.html` | Hero + card curador + grid 4 colunas (8 membros) | 🟢 |
| **O Festival** | `O Festival.html` | Hero + texto com imagem lateral + stats + tabela locais/datas | 🟢 |
| **Workshops** | `Workshops.html` | Hero + texto + blocos de objetivo/local/temas | 🟢 |
| **Vencedores** | `Winners.html` | Hero + grid de vencedores (dados fixos por enquanto) | 🟢 |
| **Contato** | `Contato.html` | Hero + formulário (Elementor Form) + dados de contato | 🟡 |
| **Credenciamento** | `Credenciamento.html` | Hero + formulário de credenciamento (Elementor Form) | 🟡 |
| **Apoiadores** ✅ | `Apoiadores.html` | Hero + mural de logos por grupo (Apoio, Apoio Cultural, Apoio Institucional) | 🟢 |
| **Distribuidoras** ✅ | `Distribuidoras.html` | Hero + mural de logos por grupo (Brasil, América Latina, Coreia do Sul) | 🟢 |
| **Parceiros** ✅ | `Parceiros.html` | Hero + mural de logos por grupo (Educacional, Mídia, Assessoria de Imprensa) | 🟢 |
| **Patrocinadores** ✅ | `Patrocinadores.html` | Hero + cards com logo, nome e texto institucional — substitui versão feita no Elementor | 🟢 |
| **Realização** ✅ | *(sem .html — página nova)* | Hero + mural de logos por grupo (Realização, Produção, Incentivo) | 🟢 |

**Para os formulários:** use o widget nativo "Form" do Elementor Pro. Você não precisa de plugin extra.

**Sobre as 5 páginas de logos (✅ acima):** implementadas em PHP puro
(`template-apoiadores-koff.php`, `template-distribuidoras-koff.php`,
`template-parceiros-koff.php`, `template-patrocinadores-koff.php`,
`template-realizacao-koff.php`), reaproveitando `koff_render_mural_section()`
e `koff_logo_url()` em `functions.php`. "Realização" ainda não tem link no
submenu "O Festival" do header (Elementor Theme Builder) — pendente de
inclusão manual pelo usuário.

---

## FASE 3 — Configurar CPTs no JetEngine
> Antes de montar qualquer página dinâmica, crie os tipos de conteúdo no JetEngine. É como criar as "tabelas" do banco de dados que vão alimentar as páginas.

| CPT a criar | Campos necessários | Usado em |
|---|---|---|
| **Sessões** | data, horário, local, cidade, filme (relação), ingressos_url | Programação, Cidade |
| **Locais** | cidade, nome_local, endereço, link_mapa_embed, foto | Cidade |
| **Debates** | título, data, mediador, descrição, vídeo_url, edição (2025/2024…) | Debates |
| **Vencedores** | filme (relação), categoria, prêmio, edição | Winners (dinâmico) |

> CPT **Filmes** já existe. Verifique se tem os campos: poster, título_original, diretor, ano, sinopse, galeria, categoria (Longa/Curta), mostra (competitiva/não-competitiva).

---

## FASE 4 — Páginas dinâmicas (dependem da Fase 3)
> Cada uma usa um JetEngine **Listing Grid** para exibir os conteúdos do banco.

| Página | Arquivo HTML | O que montar | Complexidade |
|---|---|---|---|
| **Filmes** (arquivo) | `Filmes.html` | Hero + filtro Longa/Curta + JetEngine Listing de filmes | 🔴 |
| **Programação** | `Programação.html` | Hero + select de cidade + JetEngine Listing de sessões filtrada | 🔴 |
| **Debates** | `Debates.html` | Hero + destaque principal + grid de debates | 🔴 |
| **Imprensa** | `Imprensa.html` | Hero + destaque + JetEngine Listing de posts | 🔴 |
| **Cidade / Locais** | `Cidade.html` | Hero + tabs por cidade + mapa + sessões por local | 🔴 |

---

## FASE 5 — Single templates (Elementor Theme Builder)
> São os templates que o WP usa para exibir cada item individual dos CPTs.

| Template | Arquivo HTML | O que montar |
|---|---|---|
| **Single: Filme** | `Filme.html` | Pôster + badge + título + ficha técnica + sinopse + galeria |
| **Single: Post (Imprensa)** | `Post.html` | Destaque + data + título + autor + corpo + tags + posts relacionados |

---

## FASE 6 — Home (por último)
> A Home é a página mais complexa — ela puxa conteúdo de quase todos os CPTs.

| Seção | Depende de | Complexidade |
|---|---|---|
| Hero com carrossel de filmes | CPT Filmes | 🔴 |
| Seção "Sobre o festival" | Texto estático | 🟢 |
| Destaques do festival | Configuração manual no Elementor | 🟡 |
| Newsletter | Elementor Form | 🟡 |

---

## FASE 7 — Revisão final
- [ ] Testar navegação mobile (menu hamburger)
- [ ] Verificar todos os links internos
- [ ] Testar envio de formulários
- [ ] Conferir fontes e cores em todos os navegadores
- [ ] Verificar se o header/footer aparece corretamente em todas as páginas
- [ ] Remover páginas antigas que foram substituídas

---

## Resumo executivo

```
Fase 1 → Header/Footer        (2–3h)
Fase 2 → 6 páginas estáticas  (1–2h cada)
Fase 3 → 4 CPTs no JetEngine  (2–3h no total)
Fase 4 → 5 páginas dinâmicas  (3–4h cada)
Fase 5 → 2 single templates   (2–3h cada)
Fase 6 → Home                 (4–6h)
Fase 7 → Revisão              (2–3h)
```

**Estimativa total:** 35–50h de trabalho com assistência.

---

## Próximo passo recomendado
Terminar a **página Time** (Fase 2, primeira da lista) e usar ela como modelo de processo para as demais páginas estáticas. Quando você tiver um fluxo que funcione bem para uma página, as outras ficam mais rápidas.
