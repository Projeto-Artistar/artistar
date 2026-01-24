<?php

namespace Source\Controllers;

use CoffeeCode\Router\Router;
use Source\Core\Core;
use Source\Model\Events;

class eventsController extends Core {

    public function home() {
        // $get = [
        //     's'     => (isset($_GET['s']) ? filter_var($_GET['s'], FILTER_SANITIZE_STRING) : ''),
        //     'r'     => (isset($_GET['r']) ? filter_var($_GET['r'], FILTER_SANITIZE_STRING) : ''),
        //     'c'     => (isset($_GET['c']) ? filter_var($_GET['c'], FILTER_SANITIZE_STRING) : ''),
        //     'sd'    => (isset($_GET['sd']) ? filter_var($_GET['sd'], FILTER_SANITIZE_STRING) : ''),
        //     'fd'    => (isset($_GET['fd']) ? filter_var($_GET['fd'], FILTER_SANITIZE_STRING) : '')
        // ];

        // $paginaAtual = isset($_GET['page']) ? filter_var($_GET['page'], FILTER_SANITIZE_NUMBER_INT) : 1;

        // $dados = new Events(); 

        // $queryString = http_build_query($get);
        // $paginacao = $dados->getEventosPaginacao($paginaAtual, $queryString);

        // echo $this->view->render("events/home", [
        //     'title'         =>  'Eventos - Artistar', 
        //     'logado'        => $this->getLogado(),
        //     'events'        => $dados->getEvents(),
        //     'estados'       => $this->getEstados(),
        //     'get'           => $get,
        //     'queryString'   => $queryString,
        //     'currentPage'   => $paginaAtual,
        //     'pages'         => $paginacao
        // ]);
        // return;
    }

    public function details($data) {
        $dados = new Events();
        $event = $dados->getEventBasicInfo(filter_var($data['eventId'], FILTER_SANITIZE_NUMBER_INT));
        // Pça. ALM. Gago Coutinho, 29 - Ponta da Praia, Santos - SP, 11030-200
        $event['endereco_completo'] = $event['evento_endereco_logradouro'];
        if (!empty($event['evento_endereco_numero'])) $event['endereco_completo'] .= ', '.$event['evento_endereco_numero'];
        if (!empty($event['evento_endereco_bairro'])) $event['endereco_completo'] .= ' - '.$event['evento_endereco_bairro'];
        if (!empty($event['evento_endereco_cidade'])) $event['endereco_completo'] .= ', '.$event['evento_endereco_cidade'];
        if (!empty($event['evento_endereco_estado'])) $event['endereco_completo'] .= ' - '.$event['evento_endereco_estado'];
        if (!empty($event['evento_endereco_cep'])) $event['endereco_completo'] .= ', '.$event['evento_endereco_cep'];
        
        // if (empty($event)) {
        //     header("Location: /error/404");
        //     return;
        // } else if (!isset($data['friendlyUrl']) || $event['url'] != $data['friendlyUrl']) {
        //     header("Location: /events/{$event['id']}/{$event['url']}");
        //     return;
        // }

        $days = $dados->getEventDays(filter_var($data['eventId'], FILTER_SANITIZE_NUMBER_INT));
        $advantages = $dados->getEventAdvantages(filter_var($data['eventId'], FILTER_SANITIZE_NUMBER_INT));
        $prices = $dados->getEventPrices(filter_var($data['eventId'], FILTER_SANITIZE_NUMBER_INT));
        $photos = $dados->getEventPhotos(filter_var($data['eventId'], FILTER_SANITIZE_NUMBER_INT));
        echo $this->view->render("events/details", [
            'layout' => [
                'title' =>  $event['evento_nome'].' - Artistar', 
                'logado' => $this->getLogado(),
                'header' => true,
                'footer' => true
            ],
            'event' => $event,
            'days' => $days,
            'advantages' => $advantages,
            'prices' => $prices,
            'photos' => $photos
        ]);
        return;
    }

    public function subscribe($post) {
        if (!$this->getLogado()) exit($this->renderApiResponse(401, "Usuário não autenticado."));
        $eventsModel = new Events();
        $eventId = filter_var($post['eventId'], FILTER_SANITIZE_NUMBER_INT);
        $subscribed = $eventsModel->checkIfUserIsSubscribed($eventId, $this->getUser()['loja_id']);
        if (($post['status'] == 'true' || $post['status'] === true)) { 
            $status = false;
            if ($subscribed) {
                try {
                    $eventsModel->unsubscribeFromEvent($eventId, $this->getUser()['loja_id']);
                } catch (\Exception $e) {
                    exit($this->renderApiResponse(500, "Erro ao cancelar inscrição no evento: " . $e->getMessage()));
                }
            }
        } else {
            $status = true;
            if (!$subscribed) {
                try {
                    $eventsModel->subscribeToEvent($eventId, $this->getUser()['loja_id']);
                } catch (\Exception $e) {
                    exit($this->renderApiResponse(500, "Erro ao inscrever no evento: " . $e->getMessage()));
                }
            }
        }
        exit($this->renderApiResponse(200, "Inscrição realizada com sucesso!", [
            'subscribed' => $status
        ]));
        return;
    }

    public function updateSubscription($post) {
        if (!$this->getLogado()) exit($this->renderApiResponse(401, "Usuário não autenticado."));
        $eventsModel = new Events();
        $eventId = filter_var($post['eventId'], FILTER_SANITIZE_NUMBER_INT);
        try {
            $eventsModel->updateUserSubscription(
                $eventId,
                $this->getUser()['loja_id'],
                $post['inputSubscriptionStatus'],
                $post['inputUserTags'],
                $post['inputUserObservation'],
                isset($post['inputUserFeedback']) ? $post['inputUserFeedback'] : null
            );
        } catch (\Exception $e) {
            exit($this->renderApiResponse(500, "Erro ao atualizar inscrição no evento: " . $e->getMessage()));
        }
        exit($this->renderApiResponse(200, "Inscrição atualizada com sucesso!"));
        return;
    }

    public function myEvents() {
        $this->validaAcesso(true);
        $eventsModel = new Events();
        echo $this->view->render("events/myEvents", [
            'layout' => [
                'title' =>  'Meus Eventos - Artistar', 
                'logado' => $this->getLogado(),
                'header' => true,
                'footer' => true
            ],
            'events' => $eventsModel->getUserEvents($this->getUser()['id']),
            'totals' => $eventsModel->getUserEventsTotals($this->getUser()['id']),
            'todayEvents' => $eventsModel->getUserEventsToday($this->getUser()['id'])
        ]);
        return;
    }

    public function create() {
        $this->validaAcesso(true);
        $eventsModel = new Events();
        echo $this->view->render("events/create", [
            'layout' => [
                'title' =>  'Criar Evento - Artistar', 
                'logado' => $this->getLogado(),
                'header' => true,
                'footer' => true
            ],
            'advantages' => $eventsModel->getAdvantages()
        ]);
        return;
    }

    public function insert($post) {
        $this->validaAcesso(true);
        $eventsModel = new Events();
        $mensagens = [];
        try {
            $event = $eventsModel->createEvent($post, $this->getUser()['id']);
        } catch (\Exception $e) {
            exit($this->renderApiResponse(500, "Erro ao atualizar produto: " . $e->getMessage()));
        }
        if (isset($post['eventAdvantages']) && is_array($post['eventAdvantages'])) {
            foreach($post['eventAdvantages'] as $advantageId) {
                try {
                    $eventsModel->addEventAdvantage($event, $advantageId);
                } catch (\Exception $e) {
                    $mensagens[] = "Erro ao adicionar vantagem ID {$advantageId}: " . $e->getMessage();
                }
            }
        }
        if (isset($post['dates']) && is_array($post['dates'])) {
            foreach($post['dates'] as $date) {
                try {
                    $eventsModel->addEventDate($event, $date);
                } catch (\Exception $e) {
                    $mensagens[] = "Erro ao adicionar data {$date['day']}: " . $e->getMessage();
                }
            }
        }
        if (isset($post['prices']) && is_array($post['prices'])) {
            foreach($post['prices'] as $price) {
                try {
                    $eventsModel->addEventPrice($event, $price);
                } catch (\Exception $e) {
                    $mensagens[] = "Erro ao adicionar preço {$price['type']}: " . $e->getMessage();
                }
            }
        }
        try {
            $eventsModel->updateEventComplementaryInfo($event);
        } catch (\Exception $e) {
            $mensagens[] = "Erro ao atualizar informações complementares do evento: " . $e->getMessage();
        }

        try {
            $eventsModel->subscribeToEvent($event, $this->getUser()['loja_id']);
        } catch (\Exception $e) {
            exit($this->renderApiResponse(500, "Erro ao inscrever no evento: " . $e->getMessage()));
        }

        if (!empty($mensagens)) {
            exit($this->renderApiResponse(207, "Evento criado com algumas mensagens: " . implode("; ", $mensagens), [
                'eventId' => $event
            ]));
            return;
        }
        exit($this->renderApiResponse(200, "Evento criado com sucesso!", [
            'eventId' => $event
        ]));
        return;
    }

    public function edit($data) {
        return;
    }

    public function update() {
        return;
    }

    public function delete() {
        return;
    }

}
