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

