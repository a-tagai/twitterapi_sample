<?php

require_once(__DIR__ . '/../lib/Core/head.php');

$app = new App\Controller\Index();
$app->run();
?>
<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Home Page</title>

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="assets/bootstrap/dist/css/bootstrap.min.css">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->

		<link rel="stylesheet" href="assets/font-awesome/css/font-awesome.css">
		<link rel="stylesheet" href="assets/bootstrap-social/bootstrap-social.css">

	</head>
	<body>
	<?php require_once(__DIR__ . '/common/header.php'); ?>
	<div class="container">
		<h1 class="text-center">Home</h1>
		<?php if($app->hasErrors()): ?>
			<div class="alert alert-danger">
			<p><?= h($app->getErrors('message'));?></p>
			</div>
		<?php endif; ?>
		<div class="row">
			<h2>ユーザー一覧 <span class="badge"><?= count($app->getValues()->users) ?></span></h2>
			<table class="table table-condensed">
			<thead>
			<tr>
				<th>id</th>
				<th>ユーザー名</th>
				<th>登録日</th>
			</tr>
			</thead>
			<tbody>
			<?php foreach ($app->getValues()->users as $user): ?>
			<tr>
				<td><?= h($user->id); ?></td>
				<td><?= h($user->name); ?></td>
				<td><?= h($user->created); ?></td>
			</tr>
			<?php endforeach; ?>
			</tbody>
			</table>
		</div>
	</div>


	<!-- jQuery -->
	<script src="assets/jquery/dist/jquery.min.js"></script>
	<!-- Bootstrap JavaScript -->
	<script src="assets/bootstrap/dist/js/bootstrap.min.js"></script>
	</body>
</html>
