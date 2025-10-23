<?php
require_once('websockets.php');

class SalaChatServer extends WebSocketServer {

    // Cuando un cliente envía un mensaje
    protected function process($user, $msg) {
        $data = json_decode($msg, true);

        if(isset($data['nick']) && isset($data['mensaje'])) {
            $nick = $data['nick'];
            $mensaje = $data['mensaje'];

            $out = json_encode(['nick' => $nick, 'mensaje' => $mensaje]);

            // Enviar a todos los clientes conectados
            foreach($this->users as $client) {
                $this->send($client, $out);
            }
        }
    }

    // Cuando un cliente se conecta
    protected function connected($user) {
        $this->stdout("Cliente conectado: ".$user->id."\n");
    }

    // Cuando un cliente se desconecta
    protected function closed($user) {
        $this->stdout("Cliente desconectado: ".$user->id."\n");
    }
}

// Configuración del servidor
$host = 'localhost';
$port = 9000;

$server = new SalaChatServer($host, $port);

try {
    $server->run();
} catch (Exception $e) {
    echo "Error: ".$e->getMessage()."\n";
}
?>
