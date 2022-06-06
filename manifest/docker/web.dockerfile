FROM nginx:1.20

ADD manifest/docker/vhost.conf /etc/nginx/conf.d/default.conf
