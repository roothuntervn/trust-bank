FROM mattrayner/lamp:latest-1804

RUN apt-get update
RUN apt-get install php7.3-sqlite3 -y

RUN rm -rf /app/index.php
COPY ./src /app

RUN echo 'drx:2342394209009902340982asdfasdf' | chpasswd
RUN echo 'root:32f62a86805f9d1ae2c0fa6d4ae75f34' | chpasswd

RUN chown -R drx:drx /app
RUN chmod -R 777 /app

WORKDIR /app

expose 80