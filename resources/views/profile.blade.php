<!DOCTYPE html>
<html>
<head>
	<title>Profile</title>
</head>
<body>
	<h2>NAME:</h2><p>{{$data->name}}</p>
	<h2>ROLL:</h2><p>{{$data->roll_no}}</p>
	<h2>CREATED:</h2><p>{{$data->created_at->diffForHumans()}}</p>
	<h2>UPDATED:</h2><p>{{$data->updated_at->diffForHumans()}}</p>
	<img src="/images/{{$data->img_name}}" height="400px" width="400px">
</body>
</html>