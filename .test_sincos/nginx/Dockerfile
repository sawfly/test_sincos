FROM nginx

MAINTAINER Eugene Sawfly aka Yevgeniy Trach <eugene.sawfly@gmail.com>

ADD nginx.conf /etc/nginx/
COPY /test_sincos_app.conf /etc/nginx/sites-available/

EXPOSE 80 443
CMD service nginx start

