<nav class="navbar navbar-inverse ">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?= SITE_URL ?>">Sample App</a>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<li class="active"><a href="<?= SITE_URL ?>">Home</a></li>
			</ul>
			<?php if($app->isLoggedIn()): ?>
			<ul class="nav navbar-nav navbar-right">
				<li class="navbar-text"><?= h($app->user()->email) ?></li>
				<li>
					<form action="logout.php" method="post">
					<input type="submit" class="btn btn-default navbar-btn" name="" value="ログアウト">
					<input type="hidden" name="token" value="<?= h($_SESSION['token']);?>">
					</form>
				</li>
			</ul>
			<?php endif; ?>
		</div><!--/.nav-collapse -->
	</div>
</nav>

