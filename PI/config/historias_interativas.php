<?php
$historias_interativas = [
    'periodo_colonial' => [
        'titulo' => 'O Período Colonial',
        'descricao' => 'Explore o Brasil dos primeiros anos após o descobrimento, quando os portugueses começaram a colonizar a nova terra.',
        'capitulos' => [
            [
                'titulo' => 'A Chegada dos Portugueses',
                'conteudo' => 'Em 22 de abril de 1500, a frota de Pedro Álvares Cabral avistou o Monte Pascoal, na costa da Bahia. Você é um marinheiro da frota. O que você faz?',
                'escolhas' => [
                    [
                        'texto' => 'Explorar a costa com uma pequena embarcação',
                        'proximo_capitulo' => 'exploracao_costa'
                    ],
                    [
                        'texto' => 'Aguardar ordens do capitão',
                        'proximo_capitulo' => 'aguardar_ordens'
                    ]
                ]
            ],
            [
                'titulo' => 'Exploração da Costa',
                'conteudo' => 'Você e mais alguns marinheiros desembarcam em uma pequena praia. Encontram nativos curiosos. Como você reage?',
                'escolhas' => [
                    [
                        'texto' => 'Tentar se comunicar com gestos',
                        'proximo_capitulo' => 'comunicacao_gestos'
                    ],
                    [
                        'texto' => 'Oferecer presentes',
                        'proximo_capitulo' => 'oferecer_presentes'
                    ]
                ]
            ],
            [
                'titulo' => 'Primeiro Contato',
                'conteudo' => 'Os nativos parecem amigáveis e mostram interesse nos objetos que você trouxe. O que você faz?',
                'escolhas' => [
                    [
                        'texto' => 'Tentar aprender algumas palavras da língua deles',
                        'proximo_capitulo' => 'aprender_lingua'
                    ],
                    [
                        'texto' => 'Mostrar objetos mais avançados para impressioná-los',
                        'proximo_capitulo' => 'mostrar_objetos'
                    ]
                ]
            ],
            [
                'titulo' => 'Desfecho',
                'conteudo' => 'Sua jornada no Brasil colonial termina aqui. Suas ações influenciaram o primeiro contato entre portugueses e nativos. Você:',
                'escolhas' => [
                    [
                        'texto' => 'Ajudou a estabelecer uma relação pacífica com os nativos',
                        'proximo_capitulo' => 'desfecho_pacifico'
                    ],
                    [
                        'texto' => 'Contribuiu para o início da exploração colonial',
                        'proximo_capitulo' => 'desfecho_exploracao'
                    ]
                ]
            ],
            [
                'titulo' => 'Desfecho Pacífico',
                'conteudo' => 'Parabéns! Suas ações ajudaram a estabelecer uma relação pacífica entre portugueses e nativos. Você aprendeu sobre a cultura local e contribuiu para um primeiro contato respeitoso. Sua história será lembrada como um exemplo de diplomacia e compreensão cultural.',
                'escolhas' => [
                    [
                        'texto' => 'Voltar para o início',
                        'proximo_capitulo' => 0
                    ]
                ]
            ],
            [
                'titulo' => 'Desfecho Explorador',
                'conteudo' => 'Sua exploração ajudou a mapear a costa brasileira e identificar recursos valiosos. No entanto, suas ações também marcaram o início da exploração colonial que traria consequências profundas para os povos nativos. Sua história é um lembrete das complexidades do período colonial.',
                'escolhas' => [
                    [
                        'texto' => 'Voltar para o início',
                        'proximo_capitulo' => 0
                    ]
                ]
            ]
        ]
    ],
    'inconfidencia_mineira' => [
        'titulo' => 'A Inconfidência Mineira',
        'descricao' => 'Vivencie os eventos que levaram à conspiração contra a Coroa Portuguesa em Minas Gerais.',
        'capitulos' => [
            [
                'titulo' => 'O Movimento Começa',
                'conteudo' => 'Você é um intelectual em Vila Rica, insatisfeito com os altos impostos cobrados pela Coroa. O que você faz?',
                'escolhas' => [
                    [
                        'texto' => 'Participar das reuniões secretas',
                        'proximo_capitulo' => 'reunioes_secretas'
                    ],
                    [
                        'texto' => 'Manter-se afastado do movimento',
                        'proximo_capitulo' => 'manter_distancia'
                    ]
                ]
            ],
            [
                'titulo' => 'A Traição',
                'conteudo' => 'Você descobre que o movimento será denunciado. Como você reage?',
                'escolhas' => [
                    [
                        'texto' => 'Avisar os líderes',
                        'proximo_capitulo' => 'aviso_lideres'
                    ],
                    [
                        'texto' => 'Fugir da cidade',
                        'proximo_capitulo' => 'fuga'
                    ]
                ]
            ],
            [
                'titulo' => 'O Desfecho',
                'conteudo' => 'A Inconfidência Mineira foi descoberta e seus líderes foram presos. Suas ações durante o movimento:',
                'escolhas' => [
                    [
                        'texto' => 'Ajudaram a preservar a memória do movimento',
                        'proximo_capitulo' => 'desfecho_memoria'
                    ],
                    [
                        'texto' => 'Contribuíram para o início do movimento de independência',
                        'proximo_capitulo' => 'desfecho_independencia'
                    ]
                ]
            ],
            [
                'titulo' => 'Desfecho Memória',
                'conteudo' => 'Sua participação no movimento ajudou a preservar a memória da Inconfidência Mineira. Embora o movimento tenha sido derrotado, suas ideias de liberdade e independência continuaram a inspirar gerações futuras. Você se tornou parte da história do Brasil.',
                'escolhas' => [
                    [
                        'texto' => 'Voltar para o início',
                        'proximo_capitulo' => 0
                    ]
                ]
            ],
            [
                'titulo' => 'Desfecho Independência',
                'conteudo' => 'Sua coragem e ações durante a Inconfidência Mineira ajudaram a plantar as sementes do movimento de independência. Embora o movimento tenha sido derrotado, suas ideias continuaram a crescer, influenciando futuros movimentos pela independência do Brasil.',
                'escolhas' => [
                    [
                        'texto' => 'Voltar para o início',
                        'proximo_capitulo' => 0
                    ]
                ]
            ]
        ]
    ],
    'proclamacao_republica' => [
        'titulo' => 'A Proclamação da República',
        'descricao' => 'Vivencie os momentos decisivos que levaram à queda da Monarquia e ao estabelecimento da República.',
        'capitulos' => [
            [
                'titulo' => 'O Movimento Republicano',
                'conteudo' => 'Você é um militar insatisfeito com o governo imperial. O que você faz?',
                'escolhas' => [
                    [
                        'texto' => 'Participar das conspirações',
                        'proximo_capitulo' => 'conspiracao'
                    ],
                    [
                        'texto' => 'Manter lealdade ao imperador',
                        'proximo_capitulo' => 'lealdade_imperador'
                    ]
                ]
            ],
            [
                'titulo' => 'O Dia Decisivo',
                'conteudo' => 'Chegou o momento da Proclamação. Você está no Campo de Santana. O que você faz?',
                'escolhas' => [
                    [
                        'texto' => 'Apoiar Deodoro da Fonseca',
                        'proximo_capitulo' => 'apoio_deodoro'
                    ],
                    [
                        'texto' => 'Tentar impedir o movimento',
                        'proximo_capitulo' => 'impedir_movimento'
                    ]
                ]
            ],
            [
                'titulo' => 'O Desfecho',
                'conteudo' => 'A República foi proclamada. Suas ações durante o movimento:',
                'escolhas' => [
                    [
                        'texto' => 'Ajudaram a estabelecer a nova ordem republicana',
                        'proximo_capitulo' => 'desfecho_republica'
                    ],
                    [
                        'texto' => 'Preservaram a memória do período imperial',
                        'proximo_capitulo' => 'desfecho_imperio'
                    ]
                ]
            ],
            [
                'titulo' => 'Desfecho República',
                'conteudo' => 'Sua participação na Proclamação da República ajudou a estabelecer um novo sistema de governo no Brasil. Você se tornou parte da história do país, contribuindo para a transição da Monarquia para a República.',
                'escolhas' => [
                    [
                        'texto' => 'Voltar para o início',
                        'proximo_capitulo' => 0
                    ]
                ]
            ],
            [
                'titulo' => 'Desfecho Império',
                'conteudo' => 'Sua lealdade ao Império e suas ações durante a Proclamação da República ajudaram a preservar a memória do período imperial. Embora a Monarquia tenha chegado ao fim, sua história continua a ser lembrada como parte importante da formação do Brasil.',
                'escolhas' => [
                    [
                        'texto' => 'Voltar para o início',
                        'proximo_capitulo' => 0
                    ]
                ]
            ]
        ]
    ]
];
?> 