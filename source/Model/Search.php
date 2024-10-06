<?php

namespace Source\Model;

use PDO;
use Source\Core\Core;

class Search extends Core
{

    public function getResults($search, $get) {
        return [
            [
                'type'          => 'event',
                'id'            => 1,
                'url'           => 'anime-santos',
                'title'         => 'Anime Santos',
                'subtitle'      => 'O Anime Santos é um evento que reúne fãs de animes, mangás e cultura pop em geral. O evento acontece em Santos e reúne milhares de pessoas todos os anos.',
                'start_date'    => '10/10/2020',
                'end_date'      => '12/10/2020',
                'image'         => 'https://www.turismosantos.com.br/static/files_turismosantos/styles/wpp/public/img4-scaled.jpg?itok=7-35bhk-',
            ],
            [
                'type'          => 'exhibitor',
                'id'            => 1,
                'url'           => 'deartcass',
                'title'         => 'Deartcass',
                'subtitle'      => 'Aqui fica a bio da Deartcass',
                'image'         => 'https://yt3.googleusercontent.com/_scWtkNh4pMwtQHlmH0L7L8PymaUNWy3--vtEEWjKKYC5pB1i0BTvpf9VuW8Up2s7kk9IEqTxg=s900-c-k-c0x00ffffff-no-rj',
            ],
            [
                'type'          => 'productor',
                'id'            => 1,
                'url'           => 'parker-producoes',
                'title'         => 'Parker Produções',
                'subtitle'      => 'Aqui fica a bio da Parker Produções',
                'image'         => 'https://parkerproducoes.com.br/wp-content/uploads/2022/12/logo-parker-producoes.png',
            ],
            [
                'type'          => 'event',
                'id'            => 2,
                'url'           => 'ccxp',
                'title'         => 'CCXP',
                'subtitle'   => 'A CCXP é um evento que já se tornou tradição para os fãs de quadrinhos, séries, filmes e games. A Comic Con Experience acontece em São Paulo e reúne milhares de pessoas todos os anos.',
                'start_date'    => '04/12/2020',
                'end_date'      => '06/12/2020',
                'image'         => 'https://www.tnh1.com.br//fileadmin/_processed_/d/9/csm_CCXP_tera_2a_edicao_totalmente_virtual_com_promessa_de_50_horas_de_conteudo_Divulgacao_7a46703637.jpg'
            ],
            [
                'type'          => 'event',
                'id'            => 3,
                'url'           => 'steampunk',
                'title'         => 'SteamPunk',
                'subtitle'   => 'O SteamPunk é um evento que reúne fãs de ficção científica, fantasia e tecnologia. O evento acontece em São Paulo e reúne milhares de pessoas todos os anos.',
                'start_date'    => '10/01/2021',
                'end_date'      => '12/01/2021',
                'image'         => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTwV3Ev2pw7FAAzPfNPUfu5OxEOblEqECFkTw&s'
            ],
            [
                'type'          => 'event',
                'id'            => 4,
                'url'           => 'santos-geek-convention',
                'title'         => 'Santos Geek Convention',
                'subtitle'   => 'O Santos Geek Convention é um evento que reúne fãs de quadrinhos, séries, filmes e games. O evento acontece em Santos e reúne milhares de pessoas todos os anos.',
                'start_date'    => '20/02/2021',
                'end_date'      => '22/02/2021',
                'image'         => 'https://spotme.com/wp-content/uploads/2020/07/Hero-1.jpg'
            ],
            [
                'type'          => 'event',
                'id'            => 5,
                'url'           => 'praia-games',
                'title'         => 'Praia Games',
                'subtitle'   => 'O Praia Games é um evento que reúne fãs de jogos eletrônicos, tecnologia e cultura pop em geral. O evento acontece em Santos e reúne milhares de pessoas todos os anos.',
                'start_date'    => '10/03/2021',
                'end_date'      => '12/03/2021',
                'image'         => 'https://s3.guicheweb.com.br/imagenseventos/20-10-2022_12-18-44.jpg'
            ],
            [
                'type'          => 'event',
                'id'            => 6,
                'url'           => 'festival-geek',
                'title'         => 'Festival Geek',
                'subtitle'   => 'O Festival Geek é um evento que reúne fãs de quadrinhos, séries, filmes e games. O evento acontece em São Paulo e reúne milhares de pessoas todos os anos.',
                'start_date'    => '20/04/2021',
                'end_date'      => '22/04/2021',
                'image'         => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT4wSwdZll7hWnVUvFJnEkbMZILeyMArx7UZQ&s'
            ],
            [
                'type'          => 'event',
                'id'            => 7,
                'url'           => 'rota-geek',
                'title'         => 'Rota Geek',
                'subtitle'   => 'O Rota Geek é um evento que reúne fãs de quadrinhos, séries, filmes e games. O evento acontece em Santos e reúne milhares de pessoas todos os anos.',
                'start_date'    => '10/05/2021',
                'end_date'      => '12/05/2021',
                'image'         => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRHElGdgSmzKQYAIyho6Hs90ugmT89-6AYSdQ&s'
            ],
            [
                'type'          => 'event',
                'id'            => 8,
                'url'           => 'expo-comics',
                'title'         => 'Expo Comics',
                'subtitle'   => 'O Expo Comics é um evento que reúne fãs de quadrinhos, séries, filmes e games. O evento acontece em São Paulo e reúne milhares de pessoas todos os anos.',
                'start_date'    => '20/06/2021',
                'end_date'      => '22/06/2021',
                'image'         => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcShIQyFSlpe-VijQiVC5WijYrjiEIUN6bUL8g&s'
            ],
            [
                'type'          => 'event',
                'id'            => 9,
                'url'           => 'anime-friends',
                'title'         => 'Anime Friends',
                'subtitle'   => 'O Anime Friends é um evento que reúne fãs de animes, mangás e cultura pop em geral. O evento acontece em São Paulo e reúne milhares de pessoas todos os anos.',
                'start_date'    => '10/07/2021',
                'end_date'      => '12/07/2021',
                'image'         => 'https://wdmfoto.com.br/wp-content/uploads/2023/07/logo-AF23-selo20-duotone-150x282-1-1.png'
            ],
            [
                'type'          => 'event',
                'id'            => 10,
                'url'           => 'festival-do-japao',
                'title'         => 'Fesival do Japão',
                'subtitle'   => 'O Festival do Japão é um evento que reúne fãs da cultura japonesa em geral. O evento acontece em São Paulo e reúne milhares de pessoas todos os anos.',
                'start_date'    => '20/08/2021',
                'end_date'      => '22/08/2021',
                'image'         => 'https://clickitatiba.com.br/v5/wp-content/uploads/2023/07/07f953dd-6fc1-4718-a0cc-f52c56a26aa3.jpeg'
            ],
            [
                'type'          => 'event',
                'id'            => 11,
                'url'           => 'up-abc',
                'title'         => 'UP?ABC',
                'subtitle'   => 'O UP?ABC é um evento que reúne fãs de quadrinhos, séries, filmes e games. O evento acontece em São Paulo e reúne milhares de pessoas todos os anos.',
                'start_date'    => '10/09/2021',
                'end_date'      => '12/09/2021',
                'image'         => 'https://finalbossgeek.com.br/wp-content/uploads/2024/04/upabc_logo_tema_data.png'
            ],
            [
                'type'          => 'event',
                'id'            => 12,
                'url'           => 'horror-expo',
                'title'         => 'Horror Expo',
                'subtitle'   => 'O Horror Expo é um evento que reúne fãs de terror, suspense e ficção científica. O evento acontece em São Paulo e reúne milhares de pessoas todos os anos.',
                'start_date'    => '20/10/2021',
                'end_date'      => '22/10/2021',
                'image'         => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQXwoy-_R07pFeOG5ZmoXCP3RpLkdQOaITrRQ&s'
            ],
        ];
    }
}