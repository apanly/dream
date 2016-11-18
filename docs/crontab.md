后台定时任务
============

    10 */1 * * * php /data/www/dream/yii blog/search/build >> /data/logs/jobs/build.log
    10 3 * * * php /data/www/dream/yii blog/dbmz/run >> /data/logs/jobs/douban.log
    */5 * * * * php /data/www/dream/yii blog/spider/robot >> /data/logs/jobs/robot.log
    */5 * * * * php /data/www/dream/yii blog/rich_media/run >> /data/logs/jobs/rich_media.log
    #*/1 * * * * sh /data/www/dream/console/bin/release.sh
    
    10 5 * * * php /data/www/dream/yii backup/mysql
    
    #sync blog
    */20 * * * * php /data/www/dream/yii blog/sync_blog/run >> /data/logs/jobs/sync_blog.log
    
    #recommond
    30 3 * * * php /data/www/dream/yii blog/recommend/daily >> /data/logs/jobs/recommend.log 2>&1
    */15 * * * * php /data/www/dream/yii blog/recommend/queue >> /data/logs/jobs/recommend.log 2>&1
    
    #sitemap
    1 3 * * * curl -i http://www.vincentguo.cn/search/sitemap?type=m >> /data/logs/jobs/sitemap.log 2>&1
    1 3 * * * curl -i http://www.vincentguo.cn/search/sitemap >> /data/logs/jobs/sitemap.log 2>&1
    
    10 3 * * * php  /data/www/dream/yii  blog/stat_daily/blog >> /data/logs/jobs/stat_daily_blog.log 2>&1
    54 * * * * php  /data/www/dream/yii  blog/stat_daily/access >> /data/logs/jobs/stat_daily_access.log 2>&1
    
    #stat
    59 * * * * php  /data/www/dream/yii  report/stat_daily/uuid >> /data/logs/jobs/report_stat_daily_uuid.log 2>&1
    59 * * * * php  /data/www/dream/yii  report/stat_daily/source >> /data/logs/jobs/report_stat_daily_source.log 2>&1
    59 * * * * php  /data/www/dream/yii  report/stat_daily/os >> /data/logs/jobs/report_stat_daily_os.log 2>&1
    59 * * * * php  /data/www/dream/yii  report/stat_daily/browser >> /data/logs/jobs/report_stat_daily_browser.log 2>&1
    59 * * * * php  /data/www/dream/yii  report/stat_daily/device >> /data/logs/jobs/report_stat_daily_device.log 2>&1