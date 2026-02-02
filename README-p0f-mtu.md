## How to create the p0f Tool and Service
#### 1. Download & Compile p0f
```bash
# creation gide:
apt install gcc libpcap-dev
cd /usr/local/src/
git clone https://github.com/ValdikSS/p0f-mtu.git
cd p0f-mtu
./build.sh
# you need "p0f" and "p0f.fp"
cd tools
make
# you need "p0f-client"
```
#### 2. Install

- Copy the 3 files (`p0f`, `p0f.fp` and `p0f-client`) to `/usr/local/bin/`
- Create Service `/etc/systemd/system/p0f.service`:
```bash
[Unit]
Description=p0f passive OS fingerprinting
After=network.target

[Service]
ExecStart=/usr/local/bin/p0f -f /usr/local/bin/p0f.fp -s '/var/run/p0f.sock'
Restart=always
RestartSec=5
StandardOutput=journal
StandardError=journal

[Install]
WantedBy=multi-user.target
```
- reload systemctl daemon: `systemctl daemon-reload`
- enable service: `systemctl enable p0f.service`

#### 3. Usage
Get ip address information from p0f via:
```bash
/usr/local/bin/p0f-client /var/run/p0f.sock <IP-ADDRESS>
```
is also used via PHP inside `p0f.php`
