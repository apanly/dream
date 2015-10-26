<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
<?php if($data):?>
<?php foreach($data as $_item):?>
<url>
    <loc><?=$_item['loc'];?></loc>
    <priority><?=$_item['priority'];?></priority>
    <lastmod><?=$_item['lastmod'];?></lastmod>
    <changefreq><?=$_item['changefreq'];?></changefreq>
</url>
<?php endforeach;?>
<?php endif;?>
</urlset>
