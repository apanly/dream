<main class="col-md-12 main-content">
	<article class="post page">
		<header class="post-head">
			<h1 class="post-title">第三方登录</h1>
		</header>
		<section class="post-content text-center">
			<?php foreach( $auth_urls as $_auth ):?>
				<p><a href="<?=$_auth['url'];?>"><?=$_auth['type'];?></a> </p>
			<?php endforeach;?>
		</section>
	</article>
</main>