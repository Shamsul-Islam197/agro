<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/loading.css?version=51" />
    <title></title>
</head>
<body onload="pageLoading()">
<div id="cssload-pgloading">
	<div class="cssload-loadingwrap">
		<ul class="cssload-bokeh">
			<li></li>
			<li></li>
			<li></li>
			<li></li>
		</ul>
	</div>
</div>
</body>
</html>
<script type="text/javascript">

var load=document.getElementById("cssload-pgloading");
function pageLoading(){
	setTimeout(function(){ 
		load.style.display="none";	 }, 500);
  
}

</script>