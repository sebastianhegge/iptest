```bash
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
