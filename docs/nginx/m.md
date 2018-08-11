##m.conf

    server {
            listen       80;
            listen     443  ssl;
            ssl_certificate /data/www/https/www.vincentguo.cn_bundle.crt;
            ssl_certificate_key /data/www/https/startssl.key;
            server_name   m.54php.cn;
            root  /data/www/dream/blog/web;
            access_log  /data/logs/nginx/dream_access_wap.log  main;

            proxy_set_header Host www.54php.cn;
            location / {
                proxy_set_header Host www.54php.cn;
                proxy_set_header X-Real-IP $remote_addr;
                proxy_set_header REMOTE-HOST $remote_addr;
                proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
                rewrite ^(.*)$ /wap$1 break;
                proxy_pass $scheme://127.0.0.1:$server_port;
            }

            location ~* \.(gif|jpg|jpeg|png|ico|css|js|xml)$ {
                #rewrite ^(.*)$ /$1 break;
                #proxy_pass http://127.0.0.1:80;
            }
    
    }