<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<div class="error-page">
	<h2 class="headline text-info"> 404</h2>
	<div class="error-content">
		<h3><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h3>

		<p>
			We could not find the page you were looking for.
			Meanwhile, you may
			<?php if(Session::has('alpha_id')): ?>
				<a href="<?php echo e(url('/prashaasak/home')); ?>">
					<?php elseif(Session::has('alphauserid')): ?>
						<a href="<?php echo e(url('/dashboard')); ?>">
							<?php else: ?>
								<a href="<?php echo e(url('/')); ?>">
									<?php endif; ?>
									return to dashboard</a>

								or try using the search form.<?php echo e($data); ?>

		</p>
	</div>
</div>
</body>
<script>
    var data = '<?php echo e($data); ?>';
    console.log(data);
</script>
</html>