FROM ubuntu:14.04
MAINTAINER Jack Ren bjrjk@qq.com
WORKDIR /root
RUN apt-get update -y
RUN apt-get install apache2 libapache2-mod-php5 php5 -y
RUN /etc/init.d/apache2 restart
RUN apt-get install python g++ gcc make build-essential tar wget python -y
RUN wget http://heanet.dl.sourceforge.net/project/fbc/Binaries%20-%20Linux/FreeBASIC-1.05.0-linux-x86_64.tar.gz
RUN tar zxvf FreeBASIC-1.05.0-linux-x86_64.tar.gz
WORKDIR /root/FreeBASIC-1.05.0-linux-x86_64
RUN ./install.sh -i /
WORKDIR /var/www/html/
RUN rm -rf *
COPY ./ /var/www/html/
RUN chmod -R 777 app code result error timeup
ENTRYPOINT ["python","Main.py"]
EXPOSE 80