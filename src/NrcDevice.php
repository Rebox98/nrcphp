<?php

class NrcDevice {
    private $ip;
    private $port;
    private $username;
    private $password;
    private $socket;

    public function __construct($config) {
        list($this->ip, $this->port, $this->username, $this->password) = $config;
    }

    public function connect() {
        $this->socket = fsockopen($this->ip, $this->port, $errno, $errstr, 5);
        if (!$this->socket) {
            throw new Exception("Connection failed: $errstr ($errno)");
        }
    }

    public function disconnect() {
        if ($this->socket) {
            fclose($this->socket);
        }
    }

    private function send($command) {
        if (!$this->socket) {
            throw new Exception("Socket is not connected");
        }
        fwrite($this->socket, $command);
        $response = fread($this->socket, 1024);
        return trim($response);
    }

    public function login() {
        $response = $this->send($this->username . ":" . $this->password);
        return $response === "Successful Login";
    }

    public function relayContact($relayCode, $delay_ms = null) {
        $cmd = "%RCT" . $relayCode;
        if ($delay_ms !== null) {
            $cmd .= ":" . $delay_ms;
        }
        $this->send($cmd);
    }

    public function relayOn($relayCode) {
        $this->send("%RON" . $relayCode);
    }

    public function relayOff($relayCode) {
        $this->send("%ROF" . $relayCode);
    }

    private function getBit($num, $index) {
        return ($num >> $index) & 1;
    }

    public function getRelaysValues() {
        $response = $this->send("%RST");
        if (str_ends_with($response, "h")) {
            return hexdec(substr($response, 0, -1));
        }
        throw new Exception("Invalid Response! Response must end with 'h'");
    }

    public function getRelayValue($relayCode) {
        return $this->getBit($this->getRelaysValues(), $relayCode - 1);
    }

    public function getSwInputsValues() {
        $response = $this->send("%ISW");
        if ($response === "Error") {
            throw new Exception("Device does not support feature!");
        }
        if (str_ends_with($response, "h")) {
            return hexdec(substr($response, 0, -1));
        }
        throw new Exception("Invalid Response! Response must end with 'h'");
    }

    public function getSwInputValue($inputCode) {
        return $this->getBit($this->getSwInputsValues(), $inputCode - 1);
    }

    public function getHvInputsValues() {
        $response = $this->send("%IHV");
        if ($response === "Error") {
            throw new Exception("Device does not support feature!");
        }
        if (str_ends_with($response, "h")) {
            return hexdec(substr($response, 0, -1));
        }
        throw new Exception("Invalid Response! Response must end with 'h'");
    }

    public function getHvInputValue($inputCode) {
        return $this->getBit($this->getHvInputsValues(), $inputCode - 1);
    }
}

?>
