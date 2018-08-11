## dream.conf

    
        server {
            listen       80;
            listen     443 default ssl;
            server_name  54php.cn api.54php.cn  www.54php.cn blog.54php.cn   admin.54php.cn static.54php.cn awephp.54php.cn;
    
            if ( $http_host  = '54php.cn' ){
                   rewrite ^/(.*)$ http://www.54php.cn/$1 permanent;
            }
    
            if (  $request_filename ~* "wap/robots\.txt" ) {
                   rewrite  ^/(.*)$  http://www.54php.cn/robots.txt permanent;
            }
    
            if ( $http_host ~* "^(.*?)\.54php\.cn$"){
                  set $domain $1;
            }
    
            if ( $domain = 'www' ){
                 set $domain 'blog';
            }
    
    
            root  /data/www/dream/$domain/web;
            #access_log  /data/logs/nginx/dream_access_$domain.log  main;
            index       index.php;
    
            ssl_certificate /data/www/https/www.vincentguo.cn_bundle.crt;
            ssl_certificate_key /data/www/https/startssl.key;
    
            location / {
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
