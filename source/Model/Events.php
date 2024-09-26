<?php


namespace Source\Model;

use PDO;
use Source\Core\Core;

class Events extends Core
{

    public function __construct() {
    }

    public function getBasicEventInfo($id) {

        $eventos = [
            1 => [
                'id'            => 1,
                'url'           => 'anime-santos',
                'title'         => 'Anime Santos',
            ],
            2 => [
                'id'            => 2,
                'url'           => 'ccxp',
                'title'         => 'CCXP',
            ],
            3 => [
                'id'            => 3,
                'url'           => 'steampunk',
                'title'         => 'SteamPunk',
            ],
            4 => [
                'id'            => 4,
                'url'           => 'santos-geek-convention',
                'title'         => 'Santos Geek Convention',
            ],
            5 => [
                'id'            => 5,
                'url'           => 'praia-games',
                'title'         => 'Praia Games',
            ],
            6 => [
                'id'            => 6,
                'url'           => 'santos-geek-convention',
                'title'         => 'Santos Geek Convention',
            ],
            7 => [
                'id'            => 7,
                'url'           => 'praia-games',
                'title'         => 'Praia Games',
            ],
            8 => [
                'id'            => 8,
                'url'           => 'santos-geek-convention',
                'title'         => 'Santos Geek Convention',
            ],
            9 => [
                'id'            => 9,
                'url'           => 'praia-games',
                'title'         => 'Praia Games',
            ],
            10 => [
                'id'            => 10,
                'url'           => 'santos-geek-convention',
                'title'         => 'Santos Geek Convention',
            ],
            11 => [
                'id'            => 11,
                'url'           => 'praia-games',
                'title'         => 'Praia Games',
            ],
            12 => [
                'id'            => 12,
                'url'           => 'santos-geek-convention',
                'title'         => 'Santos Geek Convention',
            ],
        ];

        return $eventos[$id];

    }

}