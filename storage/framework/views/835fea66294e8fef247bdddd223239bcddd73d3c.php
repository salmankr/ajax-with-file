<!DOCTYPE html>
<html>
<head>
	<title>Profile</title>
</head>
<body>
	<h2>NAME:</h2><p><?php echo e($data->name); ?></p>
	<h2>ROLL:</h2><p><?php echo e($data->roll_no); ?></p>
	<h2>CREATED:</h2><p><?php echo e($data->created_at->diffForHumans()); ?></p>
	<h2>UPDATED:</h2><p><?php echo e($data->updated_at->diffForHumans()); ?></p>
	<img src="/images/<?php echo e($data->img_name); ?>" height="400px" width="400px">
</body>
</html>