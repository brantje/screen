<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Screenshot</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet">
<link href="//netdna.bootstrapcdn.com/bootswatch/2.3.2/spacelab/bootstrap.min.css" rel="stylesheet">
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</head>

<body>
<div class="container">
<form target="shot"  action="shot.php"  id="form" method="post">
	<fieldset>
		<legend>Take a screenshot</legend>
		<div class="form-group">
			<label for="url">URL for screenshot</label>
			<input type="text" class="form-control" name="url" placeholder="Enter URL">
		</div>
    <div class="form-group">
      <label for="h">Resolution</label>
       <select name="resolution">
         <option value="768x1024">768x1024</option>
         <option value="800x600">800x600</option>
         <option value="1024x768">1024x768</option>
         <option value="1024x600">1024x600</option>
         <option value="1093x614">1093x614</option>
         <option value="1152x864">1152x864</option>
         <option value="1280x800">1280x800</option>
         <option value="1280x1024">1280x1024</option>
         <option value="1280x720">1280x720</option>
         <option value="1280x768">1280x768</option>
         <option value="1280x960">1280x960</option>
         <option value="1360x768">1360x768</option>
         <option value="1366x768">1366x768</option>
         <option value="1400x1050">1400x1050</option>
         <option value="1440x900">1440x900</option>
         <option value="1536x864">1536x864</option>
         <option value="1600x900">1600x900</option>
         <option value="1600x1200">1600x1200</option>
         <option value="1680x1050">1680x1050</option>
         <option value="1920x1080">1920x1080</option>
         <option value="1920x1200">1920x1200</option>
         <option value="2048x1152">2048x1152</option>
         <option value="2560x1440">2560x1440</option>
         <option value="2560x1600">2560x1600</option>
       </select>
       <div id="r">[x]</div>
    </div>
     <div class="form-group">
      <label for="quality">Quality</label>
       <input type="range" min="0" max="100" name="quality">
    </div>

		<button type="submit" class="btn btn-default">Submit</button>
	</fieldset>
</form>
</div>
<iframe src="shot.php" name="shot" id="shot" width="100%" height="1000" frameborder="0"></iframe>
</body>
<script>
  $(document).ready(function(){
    $('#r').click(function(){
      $(this).parent().remove();
    });

  })
</script>
</html>
