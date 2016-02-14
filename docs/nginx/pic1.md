## pic.conf

    server {
        listen       80;
        server_name  pic1.vincentguo.cn pic2.vincentguo.cn pic3.vincentguo.cn;

        if ( $http_host ~* "^(.*?)\.vincentguo\.cn$"){
              set $domain $1;
        }

        root  /data/www/$domain;

        set $need_crop 0;

        if (  $request_filename ~* .(gif|jpg|jpeg|png)$ ) {
            set $need_crop 1;
        }

        if ( $http_user_agent ~* "qiniu-" ) {
            set $need_crop 1;
        }

        if ( $need_crop = 1 ) {
            rewrite ^/(.*)$ /index.php?filename=/$1 last;
        }

        location ~ \.php$ {
            fastcgi_index  index.php;
            include   fastcgi_params;
            fastcgi_pass   127.0.0.1:9000;
            fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
        }
    }
