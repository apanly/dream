###快速操作步骤
* git clone git@github.com:apanly/dream.git
* php init
    * init 配置管理脚本，脚本也是php写的，就是复制environments对应环境的文件到对应目录
* 修改数据库配置
    * 数据库配置路径 common/config/main-local.php

* web服务器配置
    * 本人测试域名分别是 blog.dr.local.com  admin.dr.local.com api.dr.local.com
    * nginx 配置

            server {
                listen       80;
                server_name  *.dr.local.com;

                if ( $http_host ~* "^(.*?)\.dr.local\.com"){
                      set $domain $1;
                }

                root  /home/www/dream/$domain/web;
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

