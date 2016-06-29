<style type="text/css">
	/*.home-template {*/
		/*background-color: #fff;*/
	/*}*/

	/*.main-navigation{*/
		/*border-bottom: none;*/
	/*}*/

	.timeline {
		list-style: none;
		padding: 20px 0 20px;
		position: relative;
	}

	.timeline:before {
		top: 0;
		bottom: 0;
		position: absolute;
		content: " ";
		width: 3px;
		background-color: #eeeeee;
		left: 50%;
		margin-left: -1.5px;
	}

	.timeline > li {
		margin-bottom: 20px;
		position: relative;
	}

	.timeline > li:before,
	.timeline > li:after {
		content: " ";
		display: table;
	}

	.timeline > li:after {
		clear: both;
	}

	.timeline > li:before,
	.timeline > li:after {
		content: " ";
		display: table;
	}

	.timeline > li:after {
		clear: both;
	}

	.timeline > li > .timeline-panel {
		width: 46%;
		float: left;
		border: 1px solid #d4d4d4;
		border-radius: 2px;
		padding: 20px;
		position: relative;
		-webkit-box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);
		box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);
	}

	.timeline > li > .timeline-panel:before {
		position: absolute;
		top: 26px;
		right: -15px;
		display: inline-block;
		border-top: 15px solid transparent;
		border-left: 15px solid #ccc;
		border-right: 0 solid #ccc;
		border-bottom: 15px solid transparent;
		content: " ";
	}

	.timeline > li > .timeline-panel:after {
		position: absolute;
		top: 27px;
		right: -14px;
		display: inline-block;
		border-top: 14px solid transparent;
		border-left: 14px solid #fff;
		border-right: 0 solid #fff;
		border-bottom: 14px solid transparent;
		content: " ";
	}

	.timeline > li > .timeline-badge {
		color: #fff;
		width: 50px;
		height: 50px;
		line-height: 50px;
		font-size: 1.4em;
		text-align: center;
		position: absolute;
		top: 16px;
		left: 50%;
		margin-left: -25px;
		background-color: #999999;
		z-index: 100;
		border-top-right-radius: 50%;
		border-top-left-radius: 50%;
		border-bottom-right-radius: 50%;
		border-bottom-left-radius: 50%;
	}

	.timeline > li.timeline-inverted > .timeline-panel {
		float: right;
	}

	.timeline > li.timeline-inverted > .timeline-panel:before {
		border-left-width: 0;
		border-right-width: 15px;
		left: -15px;
		right: auto;
	}

	.timeline > li.timeline-inverted > .timeline-panel:after {
		border-left-width: 0;
		border-right-width: 14px;
		left: -14px;
		right: auto;
	}

	.timeline-badge.primary {
		background-color: #2e6da4 !important;
	}

	.timeline-badge.success {
		background-color: #3f903f !important;
	}

	.timeline-badge.warning {
		background-color: #f0ad4e !important;
	}

	.timeline-badge.danger {
		background-color: #d9534f !important;
	}

	.timeline-badge.info {
		background-color: #5bc0de !important;
	}

	.timeline-title {
		margin-top: 0;
		color: inherit;
	}

	.timeline-body > p,
	.timeline-body > ul {
		margin-bottom: 0;
	}

	.timeline-body > p + p {
		margin-top: 5px;
	}

	@media (max-width: 767px) {
		ul.timeline:before {
			left: 40px;
		}

		ul.timeline > li > .timeline-panel {
			width: calc(100% - 90px);
			width: -moz-calc(100% - 90px);
			width: -webkit-calc(100% - 90px);
		}

		ul.timeline > li > .timeline-badge {
			left: 15px;
			margin-left: 0;
			top: 16px;
		}

		ul.timeline > li > .timeline-panel {
			float: right;
		}

		ul.timeline > li > .timeline-panel:before {
			border-left-width: 0;
			border-right-width: 15px;
			left: -15px;
			right: auto;
		}

		ul.timeline > li > .timeline-panel:after {
			border-left-width: 0;
			border-right-width: 14px;
			left: -14px;
			right: auto;
		}
	}
</style>
<main class="col-md-12 main-content" style="background-color: #fff;">
	<div class="container">
		<div class="page-header">
			<h1 id="timeline">更新日志</h1>
		</div>
		<ul class="timeline">
			<?php foreach( $list as $_idx => $_info ):?>
			<li  <?php if( $_idx % 2 == 0 ) :?> class="timeline-inverted" <?php endif;?>>
				<div class="timeline-badge success">
					<i class="glyphicon glyphicon-thumbs-up"></i>
				</div>
				<div class="timeline-panel">
					<div class="timeline-heading">
						<h4 class="timeline-title"><?=$_info['title'];?></h4>
					</div>
					<div class="timeline-body">
						<p><?=$_info['content'];?></p>
						<hr/>
						<strong>上线时间：<?=$_info['date'];?></strong>
					</div>
				</div>
			</li>
			<?php endforeach;?>
		</ul>
	</div>
</main>