FROM centos:centos7

MAINTAINER Blue Snowman

# https://webtatic.com/packages/php70/
RUN rpm -Uvhi https://dl.fedoraproject.org/pub/epel/epel-release-latest-7.noarch.rpm
RUN rpm -Uvh https://mirror.webtatic.com/yum/el7/webtatic-release.rpm
RUN yum update -y

RUN yum install -y yum-utils
RUN yum-config-manager --enable cr

RUN yum install -y mc vim git

RUN yum install -y nginx
RUN yum install -y php70w-fpm php70w-common php70w-mbstring

RUN echo "date.timezone=America/New_York" >> /etc/php.ini

COPY ./setup/nginx.saber.conf /etc/nginx/default.d/
COPY ./src/classes /usr/share/nginx/classes

EXPOSE 80
