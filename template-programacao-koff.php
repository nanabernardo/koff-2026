<?php
/**
 * Template Name: Programação KOFF
 *
 * Página estática de programação do festival KOFF (Korean Film Festival).
 * 100% código, sem Elementor. Reaproveita a estética do koff.css /
 * Programação_Atual.html (classes .session, .daygroup, .dayhead, tokens
 * --gold, --card, --line, --fg-3, var(--head-bold/medium/light)).
 *
 * Fonte dos dados: PROGRAMAÇÃO COMPLETA KOFF 2026.docx (array estático abaixo,
 * NÃO vem de CPT de sessões — não relaciona via JetEngine Relations).
 *
 * Cada filme é buscado no CPT "filmes" (JetEngine) pelo título exato para
 * pegar poster (Featured Image) e link (permalink da single via Theme Builder).
 * Se não encontrar, cai no rodízio de 9 imagens placeholder e não gera link.
 */

get_header();

$koff_ano_edicao = '2026';

/* =========================================================================
 * 1) PLACEHOLDERS (rodízio sequencial 1→9→1...)
 *    URLs resolvidas dinamicamente via koff_logo_url() / wp_get_upload_dir()
 *    (functions.php) em vez de hardcodar "http://koff-teste.local" — mesmo
 *    ajuste feito em koff_fmc_placeholders() (functions.php), pra funcionar
 *    sem troca manual de domínio em produção e sem disparar o aviso de
 *    "acessar dispositivos/serviços na rede local" ao testar pelo celular.
 * ====================================================================== */
$koff_placeholders = array_map( 'koff_logo_url', [
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

/* =========================================================================
 * 2) DADOS DA PROGRAMAÇÃO — por cidade > dia > sessões
 *
 * Tipos de sessão:
 *  - 'simples' : 1 filme (curta OU longa), link+poster buscados no CPT
 *  - 'dupla'   : curta + longa na mesma sessão, unidos por "+", cada lado
 *                com seu próprio link/poster
 *  - 'bloco'   : "Bloco de curtas #X" — pôster do bloco usa placeholder em
 *                rodízio (sem busca individual de pôster); cada nome de
 *                curta na lista busca link no CPT (sem poster próprio)
 *  - 'evento'  : cerimônia / debate — sem poster, sem link
 * ====================================================================== */
$koff_cidades = [

    /* ---------------------------------------------------------------- */
    'piracicaba-sesc' => [
        'ativa' => true,
        'label' => 'Piracicaba - SESC',
        'local' => 'SESC Piracicaba',
        'dias'  => [
            [
                'data' => '13', 'mes' => '08', 'dia_semana' => 'Quinta',
                'sessoes' => [
                    ['tipo'=>'bloco','horario'=>'15h00','numero_bloco'=>1,'qtd'=>6,'duracao'=>133,
                        'curtas'=>['Standby, Mom','PONGNAN','The lion doesn\'t cry','Indigestion','Quiet Fires','The Bridges']],
                    ['tipo'=>'bloco','horario'=>'17h40','numero_bloco'=>2,'qtd'=>5,'duracao'=>102,
                        'curtas'=>['3, 2, 1, 0','I, doll','Cinderella at Noon','Visitors','Don\'t Come back']],
                    ['tipo'=>'bloco','horario'=>'19h40','numero_bloco'=>3,'qtd'=>4,'duracao'=>91,
                        'curtas'=>['The Possessed','Hole','Swapped Funerals','UNDERCURRENT']],
                ],
            ],
            [
                'data' => '14', 'mes' => '08', 'dia_semana' => 'Sexta',
                'sessoes' => [
                    ['tipo'=>'bloco','horario'=>'18h00','numero_bloco'=>4,'qtd'=>4,'duracao'=>104,
                        'curtas'=>['The Scent of Summer','Farewell, Saranghae, Farewell','The Last Stay','Leak']],
                    ['tipo'=>'bloco','horario'=>'20h00','numero_bloco'=>5,'qtd'=>4,'duracao'=>70,
                        'curtas'=>['Libera - the time: waiting for you','On the Way to Kill the Kick Scooter','The Game of Sisyphus','Illusory Dream']],
                ],
            ],
            [
                'data' => '15', 'mes' => '08', 'dia_semana' => 'Sábado',
                'sessoes' => [
                    ['tipo'=>'bloco','horario'=>'13h00','numero_bloco'=>6,'qtd'=>7,'duracao'=>109,
                        'curtas'=>['Womb Mates','Family Time','Tongue','SPEEDY!','TAINTED LOVE','Soony, meeny, miny, moe','Where roots go']],
                    ['tipo'=>'bloco','horario'=>'15h00','numero_bloco'=>7,'qtd'=>7,'duracao'=>131,
                        'curtas'=>['Sexy Fly','Anti-Sneak-Out Committee!','How to make a scary story?','Planet Spoilia','Normal human','Chicken Run','Tiny']],
                ],
            ],
            [
                'data' => '16', 'mes' => '08', 'dia_semana' => 'Domingo',
                'sessoes' => [
                    ['tipo'=>'bloco','horario'=>'13h00','numero_bloco'=>8,'qtd'=>7,'duracao'=>132,
                        'curtas'=>['Backpike','For the Mourning of a Mourning','Looking For Spring','The Good Student','After Submersion','Okpo','It Sounds Louder on Rainy Days']],
                    ['tipo'=>'bloco','horario'=>'15h30','numero_bloco'=>9,'qtd'=>4,'duracao'=>96,
                        'curtas'=>['Shimmer','Scramble','Welcome Home Freckles','Gyeong-Ae']],
                ],
            ],
        ],
    ],

    /* ---------------------------------------------------------------- */
    'piracicaba-engenho' => [
        'ativa' => true,
        'label' => 'Piracicaba - Engenho',
        'local' => 'Teatro do Engenho',
        'dias'  => [
            [
                'data' => '13', 'mes' => '08', 'dia_semana' => 'Quinta',
                'sessoes' => [                    
                    ['tipo'=>'evento','horario'=>'18h00','titulo'=>'Cerimônia de Abertura'],
                    ['tipo'=>'simples','horario'=>'19h00','titulo'=>'The King\'s Warden','formato'=>'Longa','duracao'=>117,'mostra'=>'Não-Competitiva'],
                ],
            ],
            [
                'data' => '14', 'mes' => '08', 'dia_semana' => 'Sexta',
                'sessoes' => [
                    ['tipo'=>'simples','horario'=>'15h00','titulo'=>'Sob o Céu de Seul','formato'=>'Longa','duracao'=>115,'mostra'=>'KOFA'],
                    ['tipo'=>'simples','horario'=>'17h00','titulo'=>'Hideaway','formato'=>'Longa','duracao'=>107,'mostra'=>'Competitiva'],
                    ['tipo'=>'simples','horario'=>'19h00','titulo'=>'No Other Choice','formato'=>'Longa','duracao'=>140,'mostra'=>'Não-Competitiva'],
                ],
            ],
            [
                'data' => '15', 'mes' => '08', 'dia_semana' => 'Sábado',
                'sessoes' => [
                    ['tipo'=>'simples','horario'=>'14h00','titulo'=>'Horoomon','formato'=>'Longa','duracao'=>93,'mostra'=>'Competitiva'],
                    ['tipo'=>'simples','horario'=>'16h00','titulo'=>'Tango at Dawn','formato'=>'Longa','duracao'=>116,'mostra'=>'Competitiva'],
                    ['tipo'=>'simples','horario'=>'18h00','titulo'=>'Halo','formato'=>'Longa','duracao'=>106,'mostra'=>'Competitiva'],
                    ['tipo'=>'simples','horario'=>'20h00','titulo'=>'Isle Child','formato'=>'Longa','duracao'=>88,'mostra'=>'Competitiva'],
                ],
            ],
            [
                'data' => '16', 'mes' => '08', 'dia_semana' => 'Domingo',
                'sessoes' => [
                    ['tipo'=>'simples','horario'=>'14h00','titulo'=>'Fuzileiros que Nunca Retornaram','formato'=>'Longa','duracao'=>109,'mostra'=>'KOFA'],
                    ['tipo'=>'simples','horario'=>'16h30','titulo'=>'My Missing Aunt','formato'=>'Longa','duracao'=>78,'mostra'=>'Competitiva'],
                    ['tipo'=>'simples','horario'=>'18h00','titulo'=>'Time of Cinema','formato'=>'Longa','duracao'=>95,'mostra'=>'Competitiva'],
                    ['tipo'=>'simples','horario'=>'20h00','titulo'=>'The Price of Goodbye','formato'=>'Longa','duracao'=>88,'mostra'=>'Competitiva'],
                ],
            ],
        ],
    ],

    /* ---------------------------------------------------------------- */
    'fortaleza' => [
        'ativa' => true,
        'label' => 'Fortaleza',
        'local' => 'Cineteatro São Luiz',
        'dias'  => [
            [
                'data' => '25', 'mes' => '08', 'dia_semana' => 'Terça',
                'sessoes' => [
                    ['tipo'=>'evento','horario'=>'18h30','titulo'=>'Cerimônia de Abertura'],
                    ['tipo'=>'simples','horario'=>'19h00','titulo'=>'The Mutation','formato'=>'Longa','duracao'=>107,'mostra'=>'Não-Competitiva'],
                ],
            ],
            [
                'data' => '26', 'mes' => '08', 'dia_semana' => 'Quarta',
                'sessoes' => [
                    ['tipo'=>'dupla','horario_curta'=>'19h00','horario_longa'=>'19h10',
                        'curta_titulo'=>'Theory of Mind','curta_duracao'=>10,
                        'longa_titulo'=>'Project Y','longa_duracao'=>109,'mostra'=>'Não-Competitiva'],
                ],
            ],
            [
                'data' => '27', 'mes' => '08', 'dia_semana' => 'Quinta',
                'sessoes' => [
                    ['tipo'=>'dupla','horario_curta'=>'16h00','horario_longa'=>'16h22',
                        'curta_titulo'=>'Behind His Door','curta_duracao'=>22,
                        'longa_titulo'=>'O Cocheiro','longa_duracao'=>105,'mostra'=>'KOFA'],
                    ['tipo'=>'dupla','horario_curta'=>'19h00','horario_longa'=>'19h19',
                        'curta_titulo'=>'The Planetesimal','curta_duracao'=>19,
                        'longa_titulo'=>'Winter Light','longa_duracao'=>88,'mostra'=>'Não-Competitiva'],
                ],
            ],
            [
                'data' => '28', 'mes' => '08', 'dia_semana' => 'Sexta',
                'sessoes' => [
                    ['tipo'=>'dupla','horario_curta'=>'16h00','horario_longa'=>'16h18',
                        'curta_titulo'=>'Nail Flower','curta_duracao'=>18,
                        'longa_titulo'=>'Little Dreamerz','longa_duracao'=>96,'mostra'=>'Não-Competitiva'],
                    ['tipo'=>'dupla','horario_curta'=>'18h30','horario_longa'=>'18h51',
                        'curta_titulo'=>'Papa’s Finger','curta_duracao'=>21,
                        'longa_titulo'=>'No Other Choice','longa_duracao'=>140,'mostra'=>'Não-Competitiva'],
                ],
            ],
            [
                'data' => '29', 'mes' => '08', 'dia_semana' => 'Sábado',
                'sessoes' => [
                    ['tipo'=>'dupla','horario_curta'=>'14h00','horario_longa'=>'14h11',
                        'curta_titulo'=>'Anatomy of Star','curta_duracao'=>11,
                        'longa_titulo'=>'The First Ride','longa_duracao'=>116,'mostra'=>'Não-Competitiva'],
                    ['tipo'=>'dupla','horario_curta'=>'16h30','horario_longa'=>'16h53',
                        'curta_titulo'=>'Rehearsing Anger','curta_duracao'=>23,
                        'longa_titulo'=>'Frosted Window','longa_duracao'=>81,'mostra'=>'Não-Competitiva'],
                    ['tipo'=>'dupla','horario_curta'=>'19h00','horario_longa'=>'19h16',
                        'curta_titulo'=>'Beyond the Outside','curta_duracao'=>16,
                        'longa_titulo'=>'The Ugly','longa_duracao'=>102,'mostra'=>'Não-Competitiva'],
                ],
            ],
        ],
    ],

    /* ---------------------------------------------------------------- */
    'curitiba' => [
        'ativa' => true,
        'label' => 'Curitiba',
        'local' => 'Cine Guarani',
        'dias'  => [
            [
                'data' => '10', 'mes' => '09', 'dia_semana' => 'Quinta',
                'sessoes' => [
                    ['tipo'=>'evento','horario'=>'18h30','titulo'=>'Cerimônia de Abertura'],
                    ['tipo'=>'simples','horario'=>'19h00','titulo'=>'The World of Love','formato'=>'Longa','duracao'=>119,'mostra'=>'Não-Competitiva'],
                ],
            ],
            [
                'data' => '11', 'mes' => '09', 'dia_semana' => 'Sexta',
                'sessoes' => [
                    ['tipo'=>'dupla','horario_curta'=>'17h00','horario_longa'=>'17h10',
                        'curta_titulo'=>'Theory of Mind','curta_duracao'=>10,
                        'longa_titulo'=>'Fuzileiros que nunca retornaram','longa_duracao'=>109,'mostra'=>'KOFA'],
                    ['tipo'=>'dupla','horario_curta'=>'19h30','horario_longa'=>'19h43',
                        'curta_titulo'=>'Wave of Blue','curta_duracao'=>13,
                        'longa_titulo'=>'The Mutation','longa_duracao'=>107,'mostra'=>'Não-Competitiva'],
                ],
            ],
            [
                'data' => '12', 'mes' => '09', 'dia_semana' => 'Sábado',
                'sessoes' => [
                    ['tipo'=>'simples','horario'=>'17h00','titulo'=>'The First Ride','formato'=>'Longa','duracao'=>116,'mostra'=>'Não-Competitiva'],
                    ['tipo'=>'dupla','horario_curta'=>'19h30','horario_longa'=>'19h46',
                        'curta_titulo'=>'Beyond the Outside','curta_duracao'=>16,
                        'longa_titulo'=>'Tell Me That You Love Me','longa_duracao'=>73,'mostra'=>'Não-Competitiva'],
                ],
            ],
            [
                'data' => '13', 'mes' => '09', 'dia_semana' => 'Domingo',
                'sessoes' => [
                    ['tipo'=>'dupla','horario_curta'=>'16h30','horario_longa'=>'17h19',
                        'curta_titulo'=>'The Planetesimal','curta_duracao'=>19,
                        'longa_titulo'=>'Winter Light','longa_duracao'=>88,'mostra'=>'Não-Competitiva'],
                    ['tipo'=>'simples','horario'=>'19h00','titulo'=>'No Other Choice','formato'=>'Longa','duracao'=>140,'mostra'=>'Não-Competitiva'],
                ],
            ],
            [
                'data' => '15', 'mes' => '09', 'dia_semana' => 'Terça',
                'sessoes' => [
                    ['tipo'=>'dupla','horario_curta'=>'17h00','horario_longa'=>'17h22',
                        'curta_titulo'=>'Behind His Door','curta_duracao'=>22,
                        'longa_titulo'=>'A Mãe e o Hóspede','longa_duracao'=>103,'mostra'=>'KOFA'],
                    ['tipo'=>'dupla','horario_curta'=>'19h30','horario_longa'=>'19h41',
                        'curta_titulo'=>'Nail Flower','curta_duracao'=>18,
                        'longa_titulo'=>'Boy','longa_duracao'=>91,'mostra'=>'Não-Competitiva'],
                ],
            ],
            [
                'data' => '16', 'mes' => '09', 'dia_semana' => 'Quarta',
                'sessoes' => [
                    ['tipo'=>'dupla','horario_curta'=>'17h00','horario_longa'=>'17h23',
                        'curta_titulo'=>'Rehearsing Anger','curta_duracao'=>23,
                        'longa_titulo'=>'Uma Assassina Sedenta de Sangue','longa_duracao'=>93,'mostra'=>'KOFA'],
                    ['tipo'=>'dupla','horario_curta'=>'19h30','horario_longa'=>'19h41',
                        'curta_titulo'=>'Anatomy of Star','curta_duracao'=>11,
                        'longa_titulo'=>'The Ghost Game','longa_duracao'=>95,'mostra'=>'Não-Competitiva'],
                ],
            ],
        ],
    ],

    /* ---------------------------------------------------------------- */
    'belo-horizonte' => [
        'ativa' => true,
        'label' => 'Belo Horizonte',
        'local' => 'Cine Santa Tereza',
        'dias'  => [
            [
                'data' => '15', 'mes' => '09', 'dia_semana' => 'Terça',
                'sessoes' => [
                    ['tipo'=>'evento','horario'=>'18h30','titulo'=>'Cerimônia de Abertura'],
                    ['tipo'=>'simples','horario'=>'19h00','titulo'=>'The King\'s Warden','formato'=>'Longa','duracao'=>116,'mostra'=>'Não-Competitiva'],
                ],
            ],
            [
                'data' => '16', 'mes' => '09', 'dia_semana' => 'Quarta',
                'sessoes' => [
                    ['tipo'=>'simples','horario'=>'17h00','titulo'=>'O cocheiro','formato'=>'Longa','duracao'=>105,'mostra'=>'KOFA'],
                    ['tipo'=>'dupla','horario_curta'=>'19h00','horario_longa'=>'19h40',
                        'curta_titulo'=>'Theory of Mind','curta_duracao'=>10,
                        'longa_titulo'=>'No Other Choice','longa_duracao'=>140,'mostra'=>'Não-Competitiva'],
                ],
            ],
            [
                'data' => '17', 'mes' => '09', 'dia_semana' => 'Quinta',
                'sessoes' => [
                    ['tipo'=>'simples','horario'=>'17h00','titulo'=>'Uma assassina sedenta de sangue','formato'=>'Longa','duracao'=>93,'mostra'=>'KOFA'],
                    ['tipo'=>'dupla','horario_curta'=>'19h00','horario_longa'=>'19h41',
                        'curta_titulo'=>'Anatomy of Star','curta_duracao'=>11,
                        'longa_titulo'=>'Once We Were Us','longa_duracao'=>114,'mostra'=>'Não-Competitiva'],
                ],
            ],
            [
                'data' => '18', 'mes' => '09', 'dia_semana' => 'Sexta',
                'sessoes' => [                    
                    ['tipo'=>'dupla','horario_curta'=>'16h30','horario_longa'=>'19h53',
                        'curta_titulo'=>'Beyond the Outside','curta_duracao'=>16,
                        'longa_titulo'=>'A Mãe e o Hóspede','longa_duracao'=>103,'mostra'=>'KOFA'],
                    ['tipo'=>'dupla','horario_curta'=>'19h00','horario_longa'=>'19h53',
                        'curta_titulo'=>'Behind His Door','curta_duracao'=>22,
                        'longa_titulo'=>'The Ghost Game','longa_duracao'=>95,'mostra'=>'Não-Competitiva'],
                ],
            ],
            [
                'data' => '19', 'mes' => '09', 'dia_semana' => 'Sábado',
                'sessoes' => [                   
                    ['tipo'=>'dupla','horario_curta'=>'16h30','horario_longa'=>'17h18',
                        'curta_titulo'=>'Nail Flower','curta_duracao'=>18,
                        'longa_titulo'=>'The First Ride','longa_duracao'=>116,'mostra'=>'Não-Competitiva'],
                    ['tipo'=>'dupla','horario_curta'=>'19h00','horario_longa'=>'19h52',
                        'curta_titulo'=>'Rehearsing Anger','curta_duracao'=>23,
                        'longa_titulo'=>'Funky Freaky Freaks','longa_duracao'=>87,'mostra'=>'Não-Competitiva'],
                ],
            ],
            [
                'data' => '20', 'mes' => '09', 'dia_semana' => 'Domingo',
                'sessoes' => [
                    ['tipo'=>'dupla','horario_curta'=>'16h30','horario_longa'=>'17h18',
                        'curta_titulo'=>'In the Waves','curta_duracao'=>18,
                        'longa_titulo'=>'Tell Me That You Love Me','longa_duracao'=>74,'mostra'=>'Não-Competitiva'],
                    ['tipo'=>'dupla','horario_curta'=>'18h30','horario_longa'=>'19h43',
                        'curta_titulo'=>'Wave of Blue','curta_duracao'=>13,
                        'longa_titulo'=>'The World of Love','longa_duracao'=>119,'mostra'=>'Não-Competitiva'],
                ],
            ],
        ],
    ],

    /* ---------------------------------------------------------------- */
    'sao-paulo' => [
        'ativa' => true,
        'label' => 'São Paulo',
        'local' => 'Reserva Cultural',
        'dias'  => [
            [
                'data' => '01', 'mes' => '10', 'dia_semana' => 'Quinta', 'sala' => 'Sala 1',
                'sessoes' => [
                    ['tipo'=>'evento','horario'=>'18h00','titulo'=>'Cerimônia de Abertura'],
                    ['tipo'=>'simples','horario'=>'18h30','titulo'=>'The King\'s Warden','formato'=>'Longa','duracao'=>116,'mostra'=>'Não-Competitiva'],
                    ['tipo'=>'simples','horario'=>'20h30','titulo'=>'Colony','formato'=>'Longa','duracao'=>122,'mostra'=>'Não-Competitiva'],
                ],
            ],
            [
                'data' => '02', 'mes' => '10', 'dia_semana' => 'Sexta', 'sala' => 'Sala 3',
                'sessoes' => [
                    ['tipo'=>'bloco','horario'=>'13h00','numero_bloco'=>1,'qtd'=>6,'duracao'=>96,
                        'curtas'=>['Womb Mates','Family Time','Tongue','SPEEDY!','Where roots go','Soony, meeny, miny, moe']],
                    ['tipo'=>'bloco','horario'=>'15h00','numero_bloco'=>2,'qtd'=>5,'duracao'=>111,
                        'curtas'=>['Standby, Mom','PONGNAN','Indigestion','Quiet Fires','The Bridges']],
                    ['tipo'=>'bloco_nc','horario'=>'17h00','qtd'=>5,'duracao'=>83,
                        'curtas'=>['Wave of Blue','Papa’s Finger','Beyond the Outside','Behind His Door','Anatomy of Star']],
                    ['tipo'=>'bloco_nc','horario'=>'19h00','qtd'=>5,'duracao'=>88,
                        'curtas'=>['In the Waves','The Planetesimal','Nail Flower','Theory of Mind','Rehearsing Anger']],
                    ['tipo'=>'simples','horario'=>'21h00','titulo'=>'Funky Freaky Freaks','formato'=>'Longa','duracao'=>87,'mostra'=>'Não-Competitiva'],
                ],
            ],
            [
                'data' => '03', 'mes' => '10', 'dia_semana' => 'Sábado', 'sala' => 'Sala 3',
                'sessoes' => [
                    ['tipo'=>'bloco','horario'=>'13h00','numero_bloco'=>3,'qtd'=>6,'duracao'=>117,
                        'curtas'=>['Sexy Fly','Anti-Sneak-Out Committee!','How to make a scary story?','Planet Spoilia','Normal human','Chicken Run']],
                    ['tipo'=>'simples','horario'=>'15h00','titulo'=>'Time of Cinema','formato'=>'Longa','duracao'=>95,'mostra'=>'Competitiva'],
                    ['tipo'=>'simples','horario'=>'18h00','titulo'=>'The First Ride','formato'=>'Longa','duracao'=>116,'mostra'=>'Não-Competitiva'],
                    ['tipo'=>'dupla','horario_curta'=>'21h00','horario_longa'=>'21h20',
                        'curta_titulo'=>'Shibal','curta_duracao'=>20,
                        'longa_titulo'=>'Boy','longa_duracao'=>91,'mostra'=>'Não-Competitiva'],
                ],
            ],
            [
                'data' => '04', 'mes' => '10', 'dia_semana' => 'Domingo', 'sala' => 'Sala 3',
                'sessoes' => [
                    ['tipo'=>'bloco','horario'=>'13h00','numero_bloco'=>4,'qtd'=>6,'duracao'=>97,
                        'curtas'=>['Libera - the time: waiting for you','On the Way to Kill the Kick Scooter','The Game of Sisyphus','Tiny','TAINTED LOVE','Illusory Dream']],
                    ['tipo'=>'simples','horario'=>'15h00','titulo'=>'My Missing Aunt','formato'=>'Longa','duracao'=>78,'mostra'=>'Competitiva'],
                    ['tipo'=>'simples','horario'=>'17h00','titulo'=>'Halo','formato'=>'Longa','duracao'=>106,'mostra'=>'Competitiva'],
                    ['tipo'=>'simples','horario'=>'19h00','titulo'=>'BOSS','formato'=>'Longa','duracao'=>97,'mostra'=>'Não-Competitiva'],
                    ['tipo'=>'simples','horario'=>'21h00','titulo'=>'Hideaway','formato'=>'Longa','duracao'=>107,'mostra'=>'Competitiva'],
                ],
            ],
            [
                'data' => '05', 'mes' => '10', 'dia_semana' => 'Segunda', 'sala' => 'Sala 3',
                'sessoes' => [
                    ['tipo'=>'bloco','horario'=>'15h00','numero_bloco'=>5,'qtd'=>4,'duracao'=>91,
                        'curtas'=>['The Possessed','Hole','Swapped Funerals','UNDERCURRENT']],
                    ['tipo'=>'bloco','horario'=>'17h00','numero_bloco'=>6,'qtd'=>5,'duracao'=>118,
                        'curtas'=>['Shimmer','Scramble','The lion doesn\'t cry','Welcome Home Freckles','Gyeong-Ae']],
                    ['tipo'=>'simples','horario'=>'19h00','titulo'=>'Isle Child','formato'=>'Longa','duracao'=>88,'mostra'=>'Competitiva'],
                    ['tipo'=>'simples','horario'=>'21h00','titulo'=>'The Price of Goodbye','formato'=>'Longa','duracao'=>88,'mostra'=>'Competitiva'],
                ],
            ],
            [
                'data' => '06', 'mes' => '10', 'dia_semana' => 'Terça', 'sala' => 'Sala 3',
                'sessoes' => [
                    ['tipo'=>'bloco','horario'=>'13h00','numero_bloco'=>7,'qtd'=>5,'duracao'=>120,
                        'curtas'=>['The Scent of Summer','Farewell, Saranghae, Farewell','The Good Student','The Last Stay','Leak']],
                    ['tipo'=>'simples','horario'=>'15h30','titulo'=>'Tango at Dawn','formato'=>'Longa','duracao'=>116,'mostra'=>'Competitiva'],
                    ['tipo'=>'simples','horario'=>'19h00','titulo'=>'The Only Child in the Butchery','formato'=>'Longa','duracao'=>81,'mostra'=>'Não-Competitiva'],
                    ['tipo'=>'simples','horario'=>'21h00','titulo'=>'The Mutation','formato'=>'Longa','duracao'=>107,'mostra'=>'Não-Competitiva'],
                ],
            ],
            [
                'data' => '07', 'mes' => '10', 'dia_semana' => 'Quarta', 'sala' => 'Sala 3',
                'sessoes' => [
                    ['tipo'=>'bloco','horario'=>'13h00','numero_bloco'=>8,'qtd'=>6,'duracao'=>116,
                        'curtas'=>['Backpike','For the Mourning of a Mourning','Looking For Spring','After Submersion','Okpo','It Sounds Louder on Rainy Days']],
                    ['tipo'=>'bloco','horario'=>'15h00','numero_bloco'=>9,'qtd'=>5,'duracao'=>102,
                        'curtas'=>['3, 2, 1, 0','I, doll','Cinderella at Noon','Visitors','Don\'t Come back']],
                    ['tipo'=>'simples','horario'=>'17h00','titulo'=>'Horoomon','formato'=>'Longa','duracao'=>93,'mostra'=>'Competitiva'],
                    ['tipo'=>'simples','horario'=>'19h00','titulo'=>'Frosted Window','formato'=>'Longa','duracao'=>81,'mostra'=>'Não-Competitiva'],
                    ['tipo'=>'simples','horario'=>'21h00','titulo'=>'Tell Me That You Love Me','formato'=>'Longa','duracao'=>73,'mostra'=>'Não-Competitiva'],
                ],
            ],
        ],
    ],

    /* ---------------------------------------------------------------- */
    'salvador' => [
        'ativa' => true,
        'label' => 'Salvador',
        'local' => 'Walter da Silveira',
        'dias'  => [
            [
                'data' => '27', 'mes' => '08', 'dia_semana' => 'Quinta',
                'sessoes' => [
                    ['tipo'=>'simples','horario'=>'14h00','titulo'=>'Juventude Descalça','formato'=>'Longa','duracao'=>116,'mostra'=>'Não-Competitiva'],
                    ['tipo'=>'simples','horario'=>'16h00','titulo'=>'The Mutation','formato'=>'Longa','duracao'=>107,'mostra'=>'Não-Competitiva'],
                ],
            ],
            [
                'data' => '28', 'mes' => '08', 'dia_semana' => 'Sexta',
                'sessoes' => [
                    ['tipo'=>'simples','horario'=>'14h00','titulo'=>'Bala sem rumo','formato'=>'Longa','duracao'=>140,'mostra'=>'KOFA'],
                    ['tipo'=>'simples','horario'=>'16h00','titulo'=>'Winter light','formato'=>'Longa','duracao'=>88,'mostra'=>'Não-Competitiva'],
                ],
            ],
            [
                'data' => '29', 'mes' => '08', 'dia_semana' => 'Sábado',
                'sessoes' => [
                    ['tipo'=>'simples','horario'=>'14h00','titulo'=>'Sob o céu de Seul','formato'=>'Longa','duracao'=>115,'mostra'=>'KOFA'],
                    ['tipo'=>'simples','horario'=>'16h00','titulo'=>'Once We Were Us','formato'=>'Longa','duracao'=>114,'mostra'=>'Não-Competitiva'],
                ],
            ],
        ],
    ],

    /* ---------------------------------------------------------------- */
    'recife' => [
        'ativa' => true,
        'label' => 'Recife',
        'local' => 'UFPE',
        'dias'  => [
            [
                'data' => '14', 'mes' => '09', 'dia_semana' => 'Segunda',
                'sessoes' => [
                    ['tipo'=>'simples','horario'=>'14h00','titulo'=>'Juventude Descalça','formato'=>'Longa','duracao'=>116,'mostra'=>'KOFA'],
                    ['tipo'=>'simples','horario'=>'16h00','titulo'=>'People and Meat','formato'=>'Longa','duracao'=>105,'mostra'=>'Não-Competitiva'],
                ],
            ],
            [
                'data' => '15', 'mes' => '09', 'dia_semana' => 'Terça',
                'sessoes' => [
                    ['tipo'=>'simples','horario'=>'14h00','titulo'=>'O Cocheiro','formato'=>'Longa','duracao'=>105,'mostra'=>'KOFA'],
                    ['tipo'=>'simples','horario'=>'16h00','titulo'=>'Little Dreamerz','formato'=>'Longa','duracao'=>96,'mostra'=>'Não-Competitiva'],
                ],
            ],
            [
                'data' => '16', 'mes' => '09', 'dia_semana' => 'Quarta',
                'sessoes' => [
                    ['tipo'=>'simples','horario'=>'14h00','titulo'=>'Uma assassina sedenta de sangue','formato'=>'Longa','duracao'=>93,'mostra'=>'KOFA'],
                    ['tipo'=>'simples','horario'=>'16h00','titulo'=>'The Ugly','formato'=>'Longa','duracao'=>102,'mostra'=>'Não-Competitiva'],
                ],
            ],
        ],
    ],
];

/* =========================================================================
 * 3) HELPERS
 * ====================================================================== */

/**
 * Busca um post do CPT "filmes" pelo título exato.
 * Retorna ['link'=>..., 'thumb'=>...] ou null se não encontrar / sem thumb.
 * Acumula títulos sem correspondência em $missing (por referência).
 */
function koff_find_filme( $titulo, &$missing ) {
    static $cache = [];
    $titulo = trim( $titulo );

    if ( isset( $cache[ $titulo ] ) ) {
        return $cache[ $titulo ];
    }

    $q = new WP_Query( [
        'post_type'              => 'filmes',
        'title'                  => $titulo,
        'posts_per_page'         => 1,
        'post_status'            => 'publish',
        'no_found_rows'          => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
    ] );

    $result = null;

    if ( $q->have_posts() ) {
        $post_id = $q->posts[0]->ID;
        $thumb   = get_the_post_thumbnail_url( $post_id, 'medium' );
        $result  = [
            'link'  => get_permalink( $post_id ),
            'thumb' => $thumb ?: null, // sem featured image -> cai no placeholder
        ];
    } else {
        $missing[] = $titulo;
    }

    wp_reset_postdata();
    $cache[ $titulo ] = $result;

    return $result;
}

/**
 * Retorna a próxima imagem placeholder em rodízio sequencial (1..9..1..).
 */
function koff_next_placeholder( &$counter, $placeholders ) {
    $img = $placeholders[ $counter % count( $placeholders ) ];
    $counter++;
    return $img;
}

// função para transformar número do mês em nome
function koff_mes_nome( $mes ) {
    $meses = [
        '01' => 'Janeiro', '02' => 'Fevereiro', '03' => 'Março',   '04' => 'Abril',
        '05' => 'Maio',    '06' => 'Junho',     '07' => 'Julho',   '08' => 'Agosto',
        '09' => 'Setembro','10' => 'Outubro',   '11' => 'Novembro','12' => 'Dezembro',
    ];
    return $meses[ $mes ] ?? '';
}

// Função que monta o período a partir de dias
function koff_periodo_cidade( $cidade, $ano) {
    $dias = $cidade['dias'];
    if ( empty( $dias)) return '';

    $primeiro = $dias[0];
    $ultimo = end( $dias);

    if ( $primeiro['data'] === $ultimo['data']) {
        return $primeiro['data'] . ' DE ' . strtoupper( koff_mes_nome( $primeiro['mes'] ) ) . ' DE ' . $ano;
    }
    if ( $primeiro['mes'] === $ultimo['mes'] ) {
        return $primeiro['data'] . ' A ' . $ultimo['data'] . ' DE ' . strtoupper( koff_mes_nome( $primeiro['mes'])) . ' DE ' . $ano;
    }

    return $primeiro['data'] . ' DE ' . strtoupper( koff_mes_nome( $primeiro['mes'])) . ' A ' . $ultimo['data'] . ' DE ' . strtoupper(koff_mes_nome( $ultimo['mes'])) . ' DE ' . $ano;
}

/**
 * Monta o bloco poster+título+meta de UM filme (usado em 'simples' e nos
 * dois lados de 'dupla'). Se não achar o post, não envolve em <a>.
 */
function koff_render_filme_bloco( $titulo, $formato, $duracao, $mostra, &$ph_counter, $placeholders, &$missing, $extra = '' ) {
    $filme  = koff_find_filme( $titulo, $missing );
    $link   = $filme['link'] ?? null;
    $poster = ( $filme && $filme['thumb'] ) ? $filme['thumb'] : koff_next_placeholder( $ph_counter, $placeholders );

    ob_start();
    ?>
    <div class="session-item">
        <?php if ( $link ) : ?><a href="<?php echo esc_url( $link ); ?>" class="poster-link"><?php endif; ?>
        <div class="poster">
            <img src="<?php echo esc_url( $poster ); ?>" alt="<?php echo esc_attr( $titulo ); ?>"
                 onerror="this.parentElement.innerHTML='<div class=ph-mini></div>'">
        </div>
        <?php if ( $link ) : ?></a><?php endif; ?>
        <div class="session-item-txt">
            <?php if ( $link ) : ?><a href="<?php echo esc_url( $link ); ?>" class="title-link"><?php endif; ?>
            <h3><?php echo esc_html( $titulo ); ?></h3>
            <?php if ( $link ) : ?></a><?php endif; ?>
            <div class="meta">
                <?php echo esc_html( $formato ); ?> · <?php echo (int) $duracao; ?> min · <?php echo esc_html( $mostra ); ?>
                <?php echo $extra ? ' · ' . esc_html( $extra ) : ''; ?>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Monta o HTML de um card "bloco" (pôster em rodízio + título do bloco +
 * meta com duração/qtd + lista de curtas com link se achadas no CPT).
 * Usado tanto por 'bloco' (numerado, Mostra Competitiva) quanto por
 * 'bloco_nc' (sem número, Mostra Não-Competitiva) — o único ponto que
 * muda entre os dois é o texto de $titulo_bloco recebido por parâmetro.
 */
function koff_render_bloco_curtas( $titulo_bloco, $s, $sala_dia, &$ph_counter, $placeholders, &$missing ) {
    $poster = koff_next_placeholder( $ph_counter, $placeholders );
    ob_start();
    ?>
    <div class="session session-bloco">
        <div class="time"><?php echo esc_html( $s['horario'] ); ?><small><?php echo esc_html( $s['sala'] ?? $sala_dia ?? 'ÚNICA' ); ?></small></div>
        <div class="poster">
            <img src="<?php echo esc_url( $poster ); ?>" alt="<?php echo esc_attr( $titulo_bloco ); ?>">
        </div>
        <div>
            <h3><?php echo esc_html( $titulo_bloco ); ?></h3>
            <div class="meta">
                <?php echo (int) $s['duracao']; ?> min · (<?php echo (int) $s['qtd']; ?> curtas-metragens)
            </div>
            <?php if ( ! empty( $s['curtas'] ) ) : ?>
                <div class="bloco-curtas-lista">
                    <?php
                    $koff_curtas_html = [];
                    foreach ( $s['curtas'] as $koff_curta_titulo ) {
                        $koff_curta_filme = koff_find_filme( $koff_curta_titulo, $missing );
                        if ( $koff_curta_filme && $koff_curta_filme['link'] ) {
                            $koff_curtas_html[] = '<a href="' . esc_url( $koff_curta_filme['link'] ) . '">' . esc_html( $koff_curta_titulo ) . '</a>';
                        } else {
                            $koff_curtas_html[] = esc_html( $koff_curta_titulo );
                        }
                    }
                    echo implode( ', ', $koff_curtas_html );
                    ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Renderiza um card de sessão completo, de acordo com o 'tipo'.
 */
function koff_render_sessao( $s, $sala_dia, &$ph_counter, $placeholders, &$missing ) {
    ob_start();

    switch ( $s['tipo'] ) {

        /* ---------------- SIMPLES (1 filme) ---------------- */
        case 'simples':
            ?>
            <div class="session session-simples">
                <div class="time"><?php echo esc_html( $s['horario'] ); ?><small><?php echo esc_html( $s['sala'] ?? $sala_dia ?? 'ÚNICA' ); ?></small></div>
                <?php echo koff_render_filme_bloco( $s['titulo'], $s['formato'], $s['duracao'], $s['mostra'], $ph_counter, $placeholders, $missing, $s['extra'] ?? '' ); ?>
            </div>
            <?php
            break;

        /* ---------------- DUPLA (curta + longa, unidos por "+") ---------------- */
        case 'dupla':
            ?>
            <div class="session session-dupla">
                <div class="time"><?php echo esc_html( $s['horario_curta'] ); ?><small><?php echo esc_html( $s['sala'] ?? $sala_dia ?? 'ÚNICA' ); ?></small></div>
                <div class="dupla-wrap">
                    <?php echo koff_render_filme_bloco( $s['curta_titulo'], 'Curta', $s['curta_duracao'], $s['mostra'], $ph_counter, $placeholders, $missing ); ?>
                    <span class="dupla-plus">+</span>
                    <?php echo koff_render_filme_bloco( $s['longa_titulo'], 'Longa', $s['longa_duracao'], $s['mostra'], $ph_counter, $placeholders, $missing ); ?>
                </div>
            </div>
            <?php
            break;

        /* ---------------- BLOCO DE CURTAS — Mostra Competitiva (numerado) ---------------- */
        case 'bloco':
            echo koff_render_bloco_curtas(
                'Bloco de curtas #' . (int) $s['numero_bloco'],
                $s, $sala_dia, $ph_counter, $placeholders, $missing
            );
            break;

        /* ---------------- BLOCO DE CURTAS — Mostra Não-Competitiva (sem número) ---------------- */
        case 'bloco_nc':
            echo koff_render_bloco_curtas(
                'BLOCO DE CURTAS MOSTRA NÃO-COMPETITIVA',
                $s, $sala_dia, $ph_counter, $placeholders, $missing
            );
            break;

        /* ---------------- EVENTO (cerimônia / debate) ---------------- */
        case 'evento':
            ?>
            <div class="session session-evento">
                <div class="time"><?php echo esc_html( $s['horario'] ); ?></div>
                <div class="evento-titulo"><?php echo esc_html( $s['titulo'] ); ?></div>
            </div>
            <?php
            break;
    }

    return ob_get_clean();
}

/* =========================================================================
 * 4) RENDERIZAÇÃO — 1ª passada em buffer para coletar títulos não encontrados
 * ====================================================================== */
$koff_missing    = [];
$koff_ph_counter = 0;

ob_start();
?>

<section class="pagehero">
    <div class="wrap">
        <nav class="crumbs"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Início</a><span class="sep">/</span><span>Programação</span></nav>
        <p class="eyebrow">Edição atual</p>
        <h1>Programação</h1>
        <p class="lead">Todas as sessões por cidade. Selecione a sua para ver a grade completa.</p>

        <label style="display:block;margin-top:28px;max-width:360px">
            <span class="select-label">Escolha a cidade</span>
            <select data-city-selector class="field koff-city-select">
                <?php foreach ( $koff_cidades as $slug => $cidade ) : ?>
                    <option value="<?php echo esc_attr( $slug ); ?>"><?php echo esc_html( $cidade['label'] ); ?></option>
                <?php endforeach; ?>
            </select>
        </label>
    </div>
</section>

<section class="section">
    <div class="wrap">
        <?php
        $first = true;
        foreach ( $koff_cidades as $slug => $cidade ) :
            ?>
            <div data-city="<?php echo esc_attr( $slug ); ?>" <?php echo $first ? '' : 'hidden'; ?>>
                <?php if ( $cidade['ativa'] ?? true ) : ?>

                    <p class="city-periodo"><?php echo esc_html( koff_periodo_cidade( $cidade, $koff_ano_edicao ) ); ?></p>
                    <?php foreach ( $cidade['dias'] as $dia ) : ?>
                        <div class="daygroup">
                            <div class="dayhead">
                                <span class="num"><?php echo esc_html( $dia['data'] ); ?></span>
                                <span class="lbl"><?php echo esc_html( $dia['dia_semana'] ); ?> · <?php echo esc_html( $cidade['local'] ); ?><?php echo isset( $dia['sala'] ) ? ' · ' . esc_html( $dia['sala'] ) : ''; ?></span>
                            </div>
                            <?php foreach ( $dia['sessoes'] as $s ) : ?>
                                <?php echo koff_render_sessao( $s, $dia['sala'] ?? null, $koff_ph_counter, $koff_placeholders, $koff_missing ); ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>

                <?php else : ?>

                    <div class="city-embreve">
                        <p class="city-embreve-periodo">
                            <?php echo esc_html( koff_periodo_cidade( $cidade, $koff_ano_edicao ) ); ?> · <?php echo esc_html( $cidade['local'] ); ?>
                        </p>
                        <p class="city-embreve-label">Em breve</p>
                    </div>

                <?php endif; ?>
            </div>
            <?php
            $first = false;
        endforeach;
        ?>
    </div>
</section>

<?php
$koff_conteudo = ob_get_clean();

/* =========================================================================
 * 5) AVISO DE TÍTULOS NÃO ENCONTRADOS — visível só para admins
 * ====================================================================== */
if ( current_user_can( 'manage_options' ) && ! empty( $koff_missing ) ) {
    $koff_missing_unicos = array_values( array_unique( $koff_missing ) );
    ?>
    <div class="wrap" style="padding-top:24px;">
        <div style="background:#2a1e0d;border:1px solid #ffb020;border-radius:6px;padding:16px 20px;color:#ffd27a;font-family:sans-serif;font-size:13px;">
            <strong>⚠ Aviso (visível só para administradores):</strong>
            <?php echo count( $koff_missing_unicos ); ?> título(s) da programação não encontraram post correspondente no CPT "filmes" (usando placeholder e sem link):
            <ul style="margin:8px 0 0;padding-left:20px;">
                <?php foreach ( $koff_missing_unicos as $t ) : ?>
                    <li><?php echo esc_html( $t ); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <?php
}

echo $koff_conteudo;
?>

<style>
:root{
    --gold:#F5C518;
    --card:#161616;
    --line:#2a2a2a;
    --line-2:#3a3a3a;
    --bg-3:#1e1e1e;
    --fg:#f2f2f2;
    --fg-3:#8a8a8a;
}
.wrap{max-width:1100px;margin:0 auto;padding:0 24px;}
.crumbs a{color:var(--fg-3);text-decoration:none;}
.crumbs .sep{margin:0 8px;color:var(--fg-3); font-weight: 300;}
.eyebrow{color:var(--gold);text-transform:uppercase;letter-spacing:.15em;font-size:12px;font-weight:300;margin:20px 0 8px;}
.select-label{display:block;font-weight:700;font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:var(--fg-3);margin-bottom:8px;}
.koff-city-select{background:var(--card);border:1px solid var(--gold);border-radius:4px;padding:14px 40px 14px 16px;color:var(--fg);font-size:16px;width:100%;appearance:none;
    background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23F5C518' stroke-width='2' fill='none'/%3E%3C/svg%3E");
    background-repeat:no-repeat;background-position:right 16px center;}

.daygroup{margin-bottom:40px;}
.dayhead{display:flex;align-items:baseline;gap:14px;margin-bottom:18px;padding-bottom:12px;border-bottom:1px solid var(--line);}
.dayhead .num{font-weight:700;font-size:48px;line-height:.9;color:var(--fg);}
.dayhead .lbl{font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--fg-3);font-size:12px;}

.session{display:grid;grid-template-columns:80px 1fr;gap:18px;align-items:center;
    padding:16px 20px;border:1px solid var(--line);border-radius:8px;background:var(--card);margin-bottom:12px;transition:border-color .2s;}
.session:hover{border-color:var(--line-2);}
.session-bloco{grid-template-columns:80px 64px 1fr;}
/* .session-simples usa a grid base (80px 1fr): .time + .session-item (que já
   contém poster+texto juntos). Dar 3 colunas aqui espremia o texto na coluna
   do meio (48px), forçando quebra de linha do título. */

.session .time{font-weight:700;font-size:22px;color:var(--gold);line-height:1;}
.session .time small{display:block;font-weight:700;color:var(--fg-3);font-size:11px;letter-spacing:.12em;margin-top:4px;}
.session .poster{width:64px;height:96px;border-radius:4px;overflow:hidden;background:var(--bg-3);flex:0 0 64px;}
.session .poster img{width:100%;height:100%;object-fit:cover;display:block;}
.session .poster .ph-mini{width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:#1e1e1e;}
.session h3{font-weight:500;font-size:19px;line-height:1.15;letter-spacing:-.01em;text-transform:uppercase;margin:0;color:var(--fg);}
.session .meta{font-weight:300;color:var(--fg-3);font-size:14px;line-height:1.4;margin-top:3px;}
.session a{color:inherit;text-decoration:none;}
.bloco-curtas-lista{font-size:12px;color:var(--fg-3);margin-top:6px;line-height:1.5;}

.city-periodo{
    font-weight:700;
    font-size:20px;
    text-transform:uppercase;
    letter-spacing:.05em;
    color:var(--fg);
    margin:0 0 28px;
}

/* Sessão dupla: curta + "+" + longa lado a lado.
   grid (não flex) com duas colunas 1fr iguais garante que as duas metades
   tenham SEMPRE a mesma largura em qualquer sessão dupla da página, então o
   "+" cai sempre na mesma posição horizontal, independente do tamanho dos
   títulos. */
.session-dupla{grid-template-columns:80px 1fr;}
.dupla-wrap{display:grid;grid-template-columns:1fr auto 1fr;align-items:center;gap:24px;}
.session-item{display:flex;align-items:center;gap:14px;min-width:0;}
.session-item .poster{width:64px;height:96px;flex:0 0 64px;}
.session-item-txt{flex:1;min-width:0;}
.dupla-plus{font-size:20px;font-weight:700;color:var(--gold);flex:0 0 auto;text-align:center;}

/* Evento (cerimônia/debate) */
.session-evento{grid-template-columns:80px 1fr;background:transparent;border-style:dashed;}
.session-evento .evento-titulo{font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:var(--fg-3);font-size:14px;}

/* Cidade ainda sem programação divulgada ('ativa' => false) */
.city-embreve{
    text-align:center;
    padding:40px 20px;
}
.city-embreve-periodo{
    font-weight:700;
    font-size:20px;
    text-transform:uppercase;
    letter-spacing:.05em;
    color:var(--fg);
    margin:0 0 12px;
}
.city-embreve-label{
    font-weight:700;
    font-size:24px;
    letter-spacing:.15em;
    text-transform:uppercase;
    color:var(--gold);
    margin:0;
}

@media(max-width:600px){
    .session{grid-template-columns:1fr;gap:8px;}
    .session-simples .poster,.session-bloco .poster,.session-dupla .poster{display:none;}
    /* Em mobile o dupla-wrap sai do grid de 2 colunas e volta a empilhar:
       curta em cima, "+" no meio, longa embaixo — sem largura fixa nem
       alinhamento entre cards, como no layout já aprovado. */
    .dupla-wrap{display:flex;flex-direction:column;align-items:flex-start;gap:10px;}
    .city-embreve{padding:40px 16px;}
    .city-embreve-periodo{font-size:16px;}
}
</style>

<script>
(function(){
    var sel = document.querySelector('[data-city-selector]');
    if (!sel) return;
    function updateCity(){
        document.querySelectorAll('[data-city]').forEach(function(el){
            el.hidden = (el.getAttribute('data-city') !== sel.value);
        });
    }
    sel.addEventListener('change', updateCity);
    updateCity();
})();
</script>

<?php get_footer(); ?>

