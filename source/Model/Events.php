<?php


namespace Source\Model;

use PDO;
use Source\Core\Core;

class Events extends Core
{

    public function __construct() {
    }

    public function getEventBasicInfo($id){
        $data = [
            1 => [
                'id'            => 1,
                'url'           => 'anime-santos',
                'title'         => 'Anime Santos',
                'address'       => 'Pça. ALM. Gago Coutinho, 29 - Ponta da Praia, Santos - SP, 11030-200',
                'production'    => 'Parker Produções',
                'subtitle'      => 'O Anime Santos é um evento que reúne fãs de animes, mangás e cultura pop em geral. O evento acontece em Santos e reúne milhares de pessoas todos os anos.',
                'description'   => 'O Anime Santos é um dos maiores eventos de cultura pop e geek da Baixada Santista, realizado anualmente na cidade de Santos, SP. Voltado para fãs de anime, mangá, games, cosplay e cultura japonesa, o evento reúne milhares de pessoas em um ambiente cheio de atividades. <br><br>Nele, os visitantes podem participar de concursos de cosplay, assistir a palestras e workshops com convidados especiais, além de conferir apresentações musicais e danças típicas. Há também uma grande área de stands com produtos exclusivos de animes, quadrinhos e games. A interação com dubladores e criadores de conteúdo é outro destaque do Anime Santos. O evento busca sempre proporcionar uma experiência imersiva e divertida para todos os públicos, seja para veteranos da cultura geek ou novos entusiastas.',
                'favorite'      => in_array(1, isset($_SESSION['favorites']) ? $_SESSION['favorites'] : []) ? 1 : 0,
                'contacts'      => [
                    ['icon' => 'fas fa-phone-alt', 'value' => '(11) 1234-5678'],
                    ['icon' => 'fas fa-envelope', 'value' => 'contato@evento.com'],
                    ['icon' => 'fas fa-map-marker-alt', 'value' => 'Rua Exemplo, 123, São Paulo, SP'],
                ],
                'socialMedia'  => [
                    ['icon' => 'fab fa-facebook-f', 'name' => 'Facebook', 'url' => 'https://facebook.com'],
                    ['icon' => 'fab fa-instagram', 'name' => 'Instagram', 'url' => 'https://instagram.com'],
                    ['icon' => 'fab fa-plus', 'name' => 'Sympla', 'url' => 'https://www.sympla.com.br/evento/anime-santos-geek-fest-x-mas-edition/2500268'],
                ],
            ],
            2 => [
                'id'            => 2,
                'url'           => 'ccxp',
                'title'         => 'CCXP',
                'address'       => 'São Paulo Expo - Rodovia dos Imigrantes, km 1,5 - Água Funda, São Paulo - SP, 04329-900',
                'production'    => 'Omelete Company',
                'subtitle'      => 'A CCXP é um evento que já se tornou tradição para os fãs de quadrinhos, séries, filmes e games. A Comic Con Experience acontece em São Paulo e reúne milhares de pessoas todos os anos.',
                'description'   => 'A Comic Expo é um evento dedicado aos fãs de quadrinhos, cinema, séries e cultura geek, realizado em várias cidades pelo Brasil. Ela reúne grandes nomes do entretenimento, como artistas, escritores e dubladores, que participam de painéis, palestras e sessões de autógrafos. Um dos pontos altos é a área de exposição, onde os visitantes podem conferir lançamentos de quadrinhos, edições raras e artes originais. Além disso, a Comic Expo conta com um grande concurso de cosplay, que atrai competidores talentosos e criativos. O evento também oferece áreas temáticas inspiradas em filmes e séries famosas, além de estandes com produtos exclusivos. Para os gamers, há torneios de videogame e jogos de tabuleiro. A Comic Expo é um ponto de encontro para todos os apaixonados por cultura pop e geek, oferecendo uma experiência rica e variada.',
                'favorite'      => in_array(2, isset($_SESSION['favorites']) ? $_SESSION['favorites'] : []) ? 1 : 0,
                'contacts'      => [
                    ['icon' => 'fas fa-phone-alt', 'value' => '(11) 1234-5678'],
                    ['icon' => 'fas fa-envelope', 'value' => 'contato@evento.com'],
                    ['icon' => 'fas fa-map-marker-alt', 'value' => 'Rua Exemplo, 123, São Paulo, SP'],
                ],
                'socialMedia'  => [
                    ['icon' => 'fab fa-facebook-f', 'name' => 'Facebook', 'url' => 'https://facebook.com'],
                    ['icon' => 'fab fa-instagram', 'name' => 'Instagram', 'url' => 'https://instagram.com'],
                    ['icon' => 'fab fa-plus', 'name' => 'Sympla', 'url' => 'https://www.sympla.com.br/evento/anime-santos-geek-fest-x-mas-edition/2500268'],
                ],
            ],
            3 => [
                'id'            => 3,
                'url'           => 'steampunk',
                'title'         => 'SteamPunk',
                'address'       => 'Centro de Convenções Frei Caneca - R. Frei Caneca, 569 - Consolação, São Paulo - SP, 01307-001',
                'production'    => 'Parker Produções',
                'subtitle'   => 'O SteamPunk é um evento que reúne fãs de ficção científica, fantasia e tecnologia. O evento acontece em São Paulo e reúne milhares de pessoas todos os anos.',
                'favorite'      => in_array(3, isset($_SESSION['favorites']) ? $_SESSION['favorites'] : []) ? 1 : 0,
                'contacts'      => [
                    ['icon' => 'fas fa-phone-alt', 'value' => '(11) 1234-5678'],
                    ['icon' => 'fas fa-envelope', 'value' => 'contato@evento.com'],
                    ['icon' => 'fas fa-map-marker-alt', 'value' => 'Rua Exemplo, 123, São Paulo, SP'],
                ],
                'socialMedia'  => [
                    ['icon' => 'fab fa-facebook-f', 'name' => 'Facebook', 'url' => 'https://facebook.com'],
                    ['icon' => 'fab fa-instagram', 'name' => 'Instagram', 'url' => 'https://instagram.com'],
                    ['icon' => 'fab fa-plus', 'name' => 'Sympla', 'url' => 'https://www.sympla.com.br/evento/anime-santos-geek-fest-x-mas-edition/2500268'],
                ],
            ],
            4 => [
                'id'            => 4,
                'url'           => 'santos-geek-convention',
                'title'         => 'Santos Geek Convention',
                'address'       => 'Pça. ALM. Gago Coutinho, 29 - Ponta da Praia, Santos - SP, 11030-200',
                'production'    => 'Parker Produções',
                'subtitle'   => 'O Santos Geek Convention é um evento que reúne fãs de quadrinhos, séries, filmes e games. O evento acontece em Santos e reúne milhares de pessoas todos os anos.',
                'favorite'      => in_array(4, isset($_SESSION['favorites']) ? $_SESSION['favorites'] : []) ? 1 : 0,
                'contacts'      => [
                    ['icon' => 'fas fa-phone-alt', 'value' => '(11) 1234-5678'],
                    ['icon' => 'fas fa-envelope', 'value' => 'contato@evento.com'],
                    ['icon' => 'fas fa-map-marker-alt', 'value' => 'Rua Exemplo, 123, São Paulo, SP'],
                ],
                'socialMedia'  => [
                    ['icon' => 'fab fa-facebook-f', 'name' => 'Facebook', 'url' => 'https://facebook.com'],
                    ['icon' => 'fab fa-instagram', 'name' => 'Instagram', 'url' => 'https://instagram.com'],
                    ['icon' => 'fab fa-plus', 'name' => 'Sympla', 'url' => 'https://www.sympla.com.br/evento/anime-santos-geek-fest-x-mas-edition/2500268'],
                ],
            ],
            5 => [
                'id'            => 5,
                'url'           => 'praia-games',
                'title'         => 'Praia Games',
                'address'       => 'Pça. ALM. Gago Coutinho, 29 - Ponta da Praia, Santos - SP, 11030-200',
                'production'    => 'Parker Produções',
                'subtitle'   => 'O Praia Games é um evento que reúne fãs de jogos eletrônicos, tecnologia e cultura pop em geral. O evento acontece em Santos e reúne milhares de pessoas todos os anos.',
                'favorite'      => in_array(5, isset($_SESSION['favorites']) ? $_SESSION['favorites'] : []) ? 1 : 0,
                'contacts'      => [
                    ['icon' => 'fas fa-phone-alt', 'value' => '(11) 1234-5678'],
                    ['icon' => 'fas fa-envelope', 'value' => 'contato@evento.com'],
                    ['icon' => 'fas fa-map-marker-alt', 'value' => 'Rua Exemplo, 123, São Paulo, SP'],
                ],
                'socialMedia'  => [
                    ['icon' => 'fab fa-facebook-f', 'name' => 'Facebook', 'url' => 'https://facebook.com'],
                    ['icon' => 'fab fa-instagram', 'name' => 'Instagram', 'url' => 'https://instagram.com'],
                    ['icon' => 'fab fa-plus', 'name' => 'Sympla', 'url' => 'https://www.sympla.com.br/evento/anime-santos-geek-fest-x-mas-edition/2500268'],
                ],
            ],
            6 => [
                'id'            => 6,
                'url'           => 'festival-geek',
                'title'         => 'Festival Geek',
                'address'       => 'Valongo, Santos - SP, 11013-161',
                'production'    => 'Prefeitura Municipal de Santos',
                'subtitle'   => 'O Festival Geek é um evento que reúne fãs de quadrinhos, séries, filmes e games. O evento acontece em São Paulo e reúne milhares de pessoas todos os anos.',
                'favorite'      => in_array(6, isset($_SESSION['favorites']) ? $_SESSION['favorites'] : []) ? 1 : 0,
                'contacts'      => [
                    ['icon' => 'fas fa-phone-alt', 'value' => '(11) 1234-5678'],
                    ['icon' => 'fas fa-envelope', 'value' => 'contato@evento.com'],
                    ['icon' => 'fas fa-map-marker-alt', 'value' => 'Rua Exemplo, 123, São Paulo, SP'],
                ],
                'socialMedia'  => [
                    ['icon' => 'fab fa-facebook-f', 'name' => 'Facebook', 'url' => 'https://facebook.com'],
                    ['icon' => 'fab fa-instagram', 'name' => 'Instagram', 'url' => 'https://instagram.com'],
                    ['icon' => 'fab fa-plus', 'name' => 'Sympla', 'url' => 'https://www.sympla.com.br/evento/anime-santos-geek-fest-x-mas-edition/2500268'],
                ],
            ],
            7 => [
                'id'            => 7,
                'url'           => 'rota-geek',
                'title'         => 'Rota Geek',
                'address'       => 'Pça. ALM. Gago Coutinho, 29 - Ponta da Praia, Santos - SP, 11030-200',
                'production'    => 'Parker Produções',
                'subtitle'   => 'O Rota Geek é um evento que reúne fãs de quadrinhos, séries, filmes e games. O evento acontece em Santos e reúne milhares de pessoas todos os anos.',
                'favorite'      => in_array(7, isset($_SESSION['favorites']) ? $_SESSION['favorites'] : []) ? 1 : 0,
                'contacts'      => [
                    ['icon' => 'fas fa-phone-alt', 'value' => '(11) 1234-5678'],
                    ['icon' => 'fas fa-envelope', 'value' => 'contato@evento.com'],
                    ['icon' => 'fas fa-map-marker-alt', 'value' => 'Rua Exemplo, 123, São Paulo, SP'],
                ],
                'socialMedia'  => [
                    ['icon' => 'fab fa-facebook-f', 'name' => 'Facebook', 'url' => 'https://facebook.com'],
                    ['icon' => 'fab fa-instagram', 'name' => 'Instagram', 'url' => 'https://instagram.com'],
                    ['icon' => 'fab fa-plus', 'name' => 'Sympla', 'url' => 'https://www.sympla.com.br/evento/anime-santos-geek-fest-x-mas-edition/2500268'],
                ],
            ],
            8 => [
                'id'            => 8,
                'url'           => 'expo-comics',
                'title'         => 'Expo Comics',
                'address'       => 'Centro de Convenções Frei Caneca - R. Frei Caneca, 569 - Consolação, São Paulo - SP, 01307-001',
                'production'    => 'Parker Produções',
                'subtitle'   => 'O Expo Comics é um evento que reúne fãs de quadrinhos, séries, filmes e games. O evento acontece em São Paulo e reúne milhares de pessoas todos os anos.',
                'favorite'      => in_array(8, isset($_SESSION['favorites']) ? $_SESSION['favorites'] : []) ? 1 : 0,
                'contacts'      => [
                    ['icon' => 'fas fa-phone-alt', 'value' => '(11) 1234-5678'],
                    ['icon' => 'fas fa-envelope', 'value' => 'contato@evento.com'],
                    ['icon' => 'fas fa-map-marker-alt', 'value' => 'Rua Exemplo, 123, São Paulo, SP'],
                ],
                'socialMedia'  => [
                    ['icon' => 'fab fa-facebook-f', 'name' => 'Facebook', 'url' => 'https://facebook.com'],
                    ['icon' => 'fab fa-instagram', 'name' => 'Instagram', 'url' => 'https://instagram.com'],
                    ['icon' => 'fab fa-plus', 'name' => 'Sympla', 'url' => 'https://www.sympla.com.br/evento/anime-santos-geek-fest-x-mas-edition/2500268'],
                ],
            ],
            9 => [
                'id'            => 9,
                'url'           => 'anime-friends',
                'title'         => 'Anime Friends',
                'address'       => 'Centro de Convenções Frei Caneca - R. Frei Caneca, 569 - Consolação, São Paulo - SP, 01307-001',
                'production'    => 'Parker Produções',
                'subtitle'   => 'O Anime Friends é um evento que reúne fãs de animes, mangás e cultura pop em geral. O evento acontece em São Paulo e reúne milhares de pessoas todos os anos.',
                'favorite'      => in_array(9, isset($_SESSION['favorites']) ? $_SESSION['favorites'] : []) ? 1 : 0,
                'contacts'      => [
                    ['icon' => 'fas fa-phone-alt', 'value' => '(11) 1234-5678'],
                    ['icon' => 'fas fa-envelope', 'value' => 'contato@evento.com'],
                    ['icon' => 'fas fa-map-marker-alt', 'value' => 'Rua Exemplo, 123, São Paulo, SP'],
                ],
                'socialMedia'  => [
                    ['icon' => 'fab fa-facebook-f', 'name' => 'Facebook', 'url' => 'https://facebook.com'],
                    ['icon' => 'fab fa-instagram', 'name' => 'Instagram', 'url' => 'https://instagram.com'],
                    ['icon' => 'fab fa-plus', 'name' => 'Sympla', 'url' => 'https://www.sympla.com.br/evento/anime-santos-geek-fest-x-mas-edition/2500268'],
                ],
            ],
            10 => [
                'id'            => 10,
                'url'           => 'festival-do-japao',
                'title'         => 'Fesival do Japão',
                'address'       => 'Centro de Convenções Frei Caneca - R. Frei Caneca, 569 - Consolação, São Paulo - SP, 01307-001',
                'production'    => 'Parker Produções',
                'subtitle'   => 'O Festival do Japão é um evento que reúne fãs da cultura japonesa em geral. O evento acontece em São Paulo e reúne milhares de pessoas todos os anos.',
                'favorite'      => in_array(10, isset($_SESSION['favorites']) ? $_SESSION['favorites'] : []) ? 1 : 0,
                'contacts'      => [
                    ['icon' => 'fas fa-phone-alt', 'value' => '(11) 1234-5678'],
                    ['icon' => 'fas fa-envelope', 'value' => 'contato@evento.com'],
                    ['icon' => 'fas fa-map-marker-alt', 'value' => 'Rua Exemplo, 123, São Paulo, SP'],
                ],
                'socialMedia'  => [
                    ['icon' => 'fab fa-facebook-f', 'name' => 'Facebook', 'url' => 'https://facebook.com'],
                    ['icon' => 'fab fa-instagram', 'name' => 'Instagram', 'url' => 'https://instagram.com'],
                    ['icon' => 'fab fa-plus', 'name' => 'Sympla', 'url' => 'https://www.sympla.com.br/evento/anime-santos-geek-fest-x-mas-edition/2500268'],
                ],
            ],
            11 => [
                'id'            => 11,
                'url'           => 'up-abc',
                'title'         => 'UP?ABC',
                'address'       => 'Centro de Convenções Frei Caneca - R. Frei Caneca, 569 - Consolação, São Paulo - SP, 01307-001',
                'production'    => 'Parker Produções',
                'subtitle'   => 'O UP?ABC é um evento que reúne fãs de quadrinhos, séries, filmes e games. O evento acontece em São Paulo e reúne milhares de pessoas todos os anos.',
                'favorite'      => in_array(11, isset($_SESSION['favorites']) ? $_SESSION['favorites'] : []) ? 1 : 0,
                'contacts'      => [
                    ['icon' => 'fas fa-phone-alt', 'value' => '(11) 1234-5678'],
                    ['icon' => 'fas fa-envelope', 'value' => 'contato@evento.com'],
                    ['icon' => 'fas fa-map-marker-alt', 'value' => 'Rua Exemplo, 123, São Paulo, SP'],
                ],
                'socialMedia'  => [
                    ['icon' => 'fab fa-facebook-f', 'name' => 'Facebook', 'url' => 'https://facebook.com'],
                    ['icon' => 'fab fa-instagram', 'name' => 'Instagram', 'url' => 'https://instagram.com'],
                    ['icon' => 'fab fa-plus', 'name' => 'Sympla', 'url' => 'https://www.sympla.com.br/evento/anime-santos-geek-fest-x-mas-edition/2500268'],
                ],
            ],
            12 => [
                'id'            => 12,
                'url'           => 'horror-expo',
                'title'         => 'Horror Expo',
                'address'       => '',
                'production'    => 'Parker Produções',
                'subtitle'   => 'O Horror Expo é um evento que reúne fãs de terror, suspense e ficção científica. O evento acontece em São Paulo e reúne milhares de pessoas todos os anos.',
                'favorite'      => in_array(12, isset($_SESSION['favorites']) ? $_SESSION['favorites'] : []) ? 1 : 0,
                'contacts'      => [
                    ['icon' => 'fas fa-phone-alt', 'value' => '(11) 1234-5678'],
                    ['icon' => 'fas fa-envelope', 'value' => 'contato@evento.com'],
                    ['icon' => 'fas fa-map-marker-alt', 'value' => 'Rua Exemplo, 123, São Paulo, SP'],
                ],
                'socialMedia'  => [
                    ['icon' => 'fab fa-facebook-f', 'name' => 'Facebook', 'url' => 'https://facebook.com'],
                    ['icon' => 'fab fa-instagram', 'name' => 'Instagram', 'url' => 'https://instagram.com'],
                    ['icon' => 'fab fa-plus', 'name' => 'Sympla', 'url' => 'https://www.sympla.com.br/evento/anime-santos-geek-fest-x-mas-edition/2500268'],
                ],
            ],
        ];
        
        return isset($data[$id]) ? $data[$id] : [];
    }

    public function getEventDays($id) {
        $data = [
            ['date' => '10/10/2020', 'start_time' => '12:00', 'end_time' => '19:00'],
            ['date' => '11/10/2020', 'start_time' => '12:00', 'end_time' => '19:00'],
            ['date' => '12/10/2020', 'start_time' => '12:00', 'end_time' => '19:00'],
        ];

        return $data;
    }

    public function getEventPrices($id) {
        $data = [
            ['name' => 'Artist Alley', 'price' => 'R$180', 'end_date' => '20/11'],
            ['name' => 'Loja', 'price' => 'R$1800', 'end_date' => '20/11'],
        ];

        return $data;
    }

    public function getEventPhotos($id) {
        // pelo menos 3 fotos diferentes para cada
        $data = [
            1 => [
                [
                    'order' => 0,
                    'url'   => 'https://www.turismosantos.com.br/static/files_turismosantos/styles/wpp/public/img4-scaled.jpg',
                    'label' => 'Foto 1',
                ],
                [
                    'order' => 1,
                    'url'   => 'https://images.sympla.com.br/662904e02c698-lg.png',
                    'label' => 'Foto 2',
                ],
                [
                    'order' => 2,
                    'url'   => 'https://images.sympla.com.br/640b32e544326-xs.png',
                    'label' => 'Foto 3',
                ],
            ],
            2 => [
                [
                    'order' => 0,
                    'url'   => 'https://www.tnh1.com.br//fileadmin/_processed_/d/9/csm_CCXP_tera_2a_edicao_totalmente_virtual_com_promessa_de_50_horas_de_conteudo_Divulgacao_7a46703637.jpg',
                    'label' => 'Foto 1',
                ],
                [
                    'order' => 1,
                    'url'   => 'https://www.tnh1.com.br//fileadmin/_processed_/d/9/csm_CCXP_tera_2a_edicao_totalmente_virtual_com_promessa_de_50_horas_de_conteudo_Divulgacao_7a46703637.jpg',
                    'label' => 'Foto 2',
                ],
                [
                    'order' => 2,
                    'url'   => 'https://www.tnh1.com.br//fileadmin/_processed_/d/9/csm_CCXP_tera_2a_edicao_totalmente_virtual_com_promessa_de_50_horas_de_conteudo_Divulgacao_7a46703637.jpg',
                    'label' => 'Foto 3',
                ],
            ],
            3 => [
                [
                    'order' => 0,
                    'url'   => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTwV3Ev2pw7FAAzPfNPUfu5OxEOblEqECFkTw&s',
                    'label' => 'Foto 1',
                ],
                [
                    'order' => 1,
                    'url'   => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTwV3Ev2pw7FAAzPfNPUfu5OxEOblEqECFkTw&s',
                    'label' => 'Foto 2',
                ],
                [
                    'order' => 2,
                    'url'   => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTwV3Ev2pw7FAAzPfNPUfu5OxEOblEqECFkTw&s',
                    'label' => 'Foto 3',
                ],
            ]
        ];

        return isset($data[$id]) ? $data[$id] : [];
    }

}