##m.conf


    server {
        listen       80;
        server_name   m.vincentguo.cn;
        root  /data/www/dream/blog/web;
        access_log  /data/logs/nginx/dream_access_wap.log  main;

        proxy_set_header Host www.vincentguo.cn;
        location / {

            rewrite ^(.*)$ /wap$1 break;
            proxy_pass http://127.0.0.1:80;
        }

        location ~* \.(gif|jpg|jpeg|png|ico|css|js)$ {
            rewrite ^(.*)$ /$1 break;
            proxy_pass http://127.0.0.1:80;
        }

        location ^~ /debug/ {
            rewrite ^(.*)$ /$1 break;
            proxy_pass http://127.0.0.1:80;
        }

    }