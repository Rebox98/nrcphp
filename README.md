# nrcphp

nrcphp is a Python package for working with NRC devices. It provides a convenient interface to connect to an NRC device, send commands, and retrieve information from the device.

## 🔥 Installation

You can install `nrcphp` using pip:

```shell
composer require rebox98/nrcphp
composer dump-autoload
```
## 🪧 Usage
Here is an example of how to use nrcphp to connect to an NRC device and control the relays:
```php
<?php
require 'vendor/autoload.php';

use NrcDevice\NrcDevice;

$ip = '192.168.1.200';
$port = 23;
$username = "admin";
$password = "admin";

$nrc = new NrcDevice([$ip, $port, $username, $password]);
// Open Connection
$nrc->connect();

// Login
if ($nrc->login()) {
    // Commands
    $nrc->relayContact(1, 500);
    $nrc->relayContact(2, 1000);
    $nrc->relayOff(1);
    $nrc->relayOn(2);
    echo "Relays Status (hex): " . $nrc->getRelaysValues() . "\n";
    echo "Relay 1 Status: " . $nrc->getRelayValue(1) . "\n";
    echo "Relay 2 Status: " . $nrc->getRelayValue(2) . "\n";

    try {
        echo "SW Inputs Status: " . $nrc->getSwInputsValues() . "\n";
        echo "SW 1 Status: " . $nrc->getSwInputValue(1) . "\n";
        echo "SW 2 Status: " . $nrc->getSwInputValue(2) . "\n";
        echo "SW 3 Status: " . $nrc->getSwInputValue(3) . "\n";
    } catch (Exception $e) {
        echo "SW Inputs Status: " . $e->getMessage() . "\n";
    }

    try {
        echo "HV Inputs Status: " . $nrc->getHvInputsValues() . "\n";
        echo "HV 1 Status: " . $nrc->getHvInputValue(1) . "\n";
        echo "HV 2 Status: " . $nrc->getHvInputValue(2) . "\n";
        echo "HV 3 Status: " . $nrc->getHvInputValue(3) . "\n";
    } catch (Exception $e) {
        echo "HV Inputs Status: " . $e->getMessage() . "\n";
    }
} else {
    echo "Error in login\n";
}

$nrc->disconnect();

?>
```
