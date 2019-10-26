# Sourcecode challange 'trust-bank'

#### How to build:

1. Install [docker](https://docs.docker.com/install/linux/docker-ce/ubuntu/).
2. Run docker service:
```bash
service docker start
```
3. Get source:
```bash
cd ~
git clone https://github.com/roothuntervn/trust-bank.git
cd trust-bank
```
3. Build image:
```bash
docker build -t trust-bank .
```
4. Run container:
```bash
docker run --name trust-bank -p 8088:80 trust-bank
```
3. Visit [http://localhost:8088](http://localhost:8088)