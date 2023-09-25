FROM httpd:2.4.57

RUN apt-get update && apt-get install -y \
    libapache2-mod-fcgid

COPY ./httpd.conf /usr/local/apache2/conf/httpd.conf