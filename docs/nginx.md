## pic.conf

    server {
        listen       80;
        server_name  pic1.vincentguo.cn pic2.vincentguo.cn;


        if ( $http_host ~* "^(.*?)\.vincentguo\.cn$"){
              set $domain $1;
        }


        root  /data/www/$domain;
        #rewrite ^/(.*)$ /index.php?filename=/$1 last;

        if ($request_filename ~* .(gif|jpg|jpeg|png)$ ) {
            rewrite ^/(.*)$ /index.php?filename=/$1 last;
        }
        location ~ \.php$ {
            fastcgi_index  index.php;
            include   fastcgi_params;
            fastcgi_pass   127.0.0.1:9000;
            fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
        }
    }

## dream.conf

    server {
        listen       80;
        server_name  vincentguo.cn www.vincentguo.cn blog.vincentguo.cn admin.vincentguo.cn;

        if ( $http_host  = 'vincentguo.cn' ){
        	   rewrite ^/(.*)$ http://www.vincentguo.cn/$1 permanent;
        }

        if ( $http_host ~* "^(.*?)\.vincentguo\.cn$"){
              set $domain $1;
        }

        if ( $domain = 'www' ){
             set $domain 'blog';
        }

        root  /data/www/dream/$domain/web;
        #access_log  /data/logs/nginx/dream_access_$domain.log  main;
        index       index.php;

        location / {
            expires 30d;
            try_files $uri $uri/ /index.php?$args;
        }

        location ~ \.php$ {
            fastcgi_index  index.php;
            include   fastcgi_params;
            fastcgi_pass   127.0.0.1:9000;
            fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
        }
    }
    #add_header Content-Type "text/plain;charset=utf-8";
    #return 200 "$domain";


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