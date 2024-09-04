<?php


namespace Source\Model;

use PDO;
use Source\Core\Core;

class Home extends Core
{

    public function __construct() {
    }

    public function trazerEventos(){
        $eventos = [
            [
                'titulo' => 'Anime Santos',
                'descricao' => 'O Anime Santos é um evento que reúne fãs de animes, mangás e cultura pop em geral. O evento acontece em Santos e reúne milhares de pessoas todos os anos.',
                'data' => '10/01/2020',
                'imagem' => 'https://www.turismosantos.com.br/static/files_turismosantos/styles/wpp/public/img4-scaled.jpg?itok=7-35bhk-'
            ],
            [
                'titulo' => 'CCXP',
                'descricao' => 'A CCXP é um evento que já se tornou tradição para os fãs de quadrinhos, séries, filmes e games. A Comic Con Experience acontece em São Paulo e reúne milhares de pessoas todos os anos.',
                'data' => '04/12/2019',
                'imagem' => 'https://www.tnh1.com.br//fileadmin/_processed_/d/9/csm_CCXP_tera_2a_edicao_totalmente_virtual_com_promessa_de_50_horas_de_conteudo_Divulgacao_7a46703637.jpg'
            ],
            [
                'titulo' => 'SteamPunk',
                'descricao' => 'O SteamPunk é um evento que reúne fãs de ficção científica, fantasia e tecnologia. O evento acontece em São Paulo e reúne milhares de pessoas todos os anos.',
                'data' => '20/02/2020',
                'imagem' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTwV3Ev2pw7FAAzPfNPUfu5OxEOblEqECFkTw&s'
            ],
            [
                'titulo' => 'Santos Geek Convention',
                'descricao' => 'O Santos Geek Convention é um evento que reúne fãs de quadrinhos, séries, filmes e games. O evento acontece em Santos e reúne milhares de pessoas todos os anos.',
                'data' => '15/03/2020',
                'imagem' => 'https://spotme.com/wp-content/uploads/2020/07/Hero-1.jpg'
            ],
            [
                'titulo' => 'Praia Games',
                'descricao' => 'O Praia Games é um evento que reúne fãs de jogos eletrônicos, tecnologia e cultura pop em geral. O evento acontece em Santos e reúne milhares de pessoas todos os anos.',
                'data' => '10/04/2020',
                'imagem' => 'https://s3.guicheweb.com.br/imagenseventos/20-10-2022_12-18-44.jpg'
            ],
            [
                'titulo' => 'Festival Geek',
                'descricao' => 'O Festival Geek é um evento que reúne fãs de quadrinhos, séries, filmes e games. O evento acontece em São Paulo e reúne milhares de pessoas todos os anos.',
                'data' => '20/05/2020',
                'imagem' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT4wSwdZll7hWnVUvFJnEkbMZILeyMArx7UZQ&s'
            ],
            [
                'titulo' => 'Rota Geek',
                'descricao' => 'O Rota Geek é um evento que reúne fãs de quadrinhos, séries, filmes e games. O evento acontece em Santos e reúne milhares de pessoas todos os anos.',
                'data' => '10/06/2020',
                'imagem' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRHElGdgSmzKQYAIyho6Hs90ugmT89-6AYSdQ&s'
            ],
            [
                'titulo' => 'Expo Comics',
                'descricao' => 'O Expo Comics é um evento que reúne fãs de quadrinhos, séries, filmes e games. O evento acontece em São Paulo e reúne milhares de pessoas todos os anos.',
                'data' => '20/07/2020',
                'imagem' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcShIQyFSlpe-VijQiVC5WijYrjiEIUN6bUL8g&s'
            ],
            [
                'titulo' => 'Anime Friends',
                'descricao' => 'O Anime Friends é um evento que reúne fãs de animes, mangás e cultura pop em geral. O evento acontece em São Paulo e reúne milhares de pessoas todos os anos.',
                'data' => '10/08/2020',
                'imagem' => 'https://wdmfoto.com.br/wp-content/uploads/2023/07/logo-AF23-selo20-duotone-150x282-1-1.png'
            ],
            [
                'titulo' => 'Fesival do Japão',
                'descricao' => 'O Festival do Japão é um evento que reúne fãs da cultura japonesa em geral. O evento acontece em São Paulo e reúne milhares de pessoas todos os anos.',
                'data' => '20/09/2020',
                'imagem' => 'https://clickitatiba.com.br/v5/wp-content/uploads/2023/07/07f953dd-6fc1-4718-a0cc-f52c56a26aa3.jpeg'
            ],
            [
                'titulo' => 'UP?ABC',
                'descricao' => 'O UP?ABC é um evento que reúne fãs de quadrinhos, séries, filmes e games. O evento acontece em São Paulo e reúne milhares de pessoas todos os anos.',
                'data' => '10/10/2020',
                'imagem' => 'https://finalbossgeek.com.br/wp-content/uploads/2024/04/upabc_logo_tema_data.png'
            ],
            [
                'titulo' => 'Horror Expo',
                'descricao' => 'O Horror Expo é um evento que reúne fãs de terror, suspense e ficção científica. O evento acontece em São Paulo e reúne milhares de pessoas todos os anos.',
                'data' => '20/11/2020',
                'imagem' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQXwoy-_R07pFeOG5ZmoXCP3RpLkdQOaITrRQ&s'
            ],
        ];

        return $eventos;
    }

}