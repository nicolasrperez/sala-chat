<?php
    require_once('websockets.php');
class SalaChatServer extends WebSocketServer { ... }


public function process($user, $message) {
    $data = json_decode($message, true);

    if ($data && isset($data['alias']) && isset($data['mensaje'])) {
        $alias = $data['alias'];
        $msg = $data['mensaje'];
        $final = $alias . ": " . $msg;
    } else {
        // por si llega texto plano
        $final = $message;
    }

    // reenviar a todos los usuarios conectados
    foreach ($this->users as $u) {
        $this->send($u, $final);
    }
}
