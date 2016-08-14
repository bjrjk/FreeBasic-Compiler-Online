FROM daocloud.io/php:5.6-apache
MAINTAINER Jack Ren bjrjk@qq.com
WORKDIR /root
RUN apt-get update -y
RUN apt-get install python g++ gcc make build-essential tar wget python -y
RUN wget http://heanet.dl.sourceforge.net/project/fbc/Binaries%20-%20Linux/FreeBASIC-1.05.0-linux-x86_64.tar.gz
RUN tar zxvf FreeBASIC-1.05.0-linux-x86_64.tar.gz
WORKDIR /root/FreeBASIC-1.05.0-linux-x86_64
RUN ./install.sh -i /
COPY ./ /var/www/html/
ENTRYPOINT ["python","Main.py",">log.txt &"]
EXPOSE 80