# nrcphp

nrcphp is a Python package for working with NRC devices. It provides a convenient interface to connect to an NRC device, send commands, and retrieve information from the device.

## 🔥 Installation

You can install `nrcphp` using pip:

```shell
pip install nrcphp
```
## 🪧 Usage
Here is an example of how to use nrcphp to connect to an NRC device and control the relays:
```python
from nrcphp import NrcDevice

ip='192.168.1.200'
port=23
username="admin"
password="admin"


nrc=NrcDevice((ip,port,username,password))
# Open Connection
nrc.connect()

# Login
if nrc.login():
    # Commands
    nrc.relayContact(1,500)
    nrc.relayContact(2,1000)
    nrc.relayOff(1)
    nrc.relayOn(2)
    print("Relays Status (hex):" ,nrc.getRelaysValues())
    print("Relay 1 Status:" ,nrc.getRelayValue(1))
    print("Relay 2 Status:" ,nrc.getRelayValue(2))

    try: 
        print("SW Inputs Status (hex):" ,nrc.getSwInputsValues())
        print("SW 1 Status:" ,nrc.getSwInputValue(1))
        print("SW 2 Status:" ,nrc.getSwInputValue(2))
        print("SW 3 Status:" ,nrc.getSwInputValue(3))
    except Exception as e: 
        print("Error:" ,e)

    try: 
        print("HV Inputs Status (hex):" ,nrc.getHvInputsValues())
        print("HV 1 Status:" ,nrc.getHvInputValue(1))
        print("HV 2 Status:" ,nrc.getHvInputValue(2))
        print("HV 3 Status:" ,nrc.getHvInputValue(3))
    except Exception as e: 
        print("Error:" ,e)
else:
    print("Error in login")

nrc.disconnect()
```
