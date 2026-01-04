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

```bash
# p0f is startet via:
/path/to/p0f -d -f /path/to/p0f.fp -s '/var/run/p0f.sock'

# cron example:
@reboot /path/to/p0f -d -f /path/to/p0f.fp -s '/var/run/p0f.sock'

# p0f-client is used via, must be useable from PHP (see p0f.php):
/path/to/p0f-client /var/run/p0f.sock <IP-ADDRESS>
```
