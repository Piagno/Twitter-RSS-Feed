<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://office.piagno.ch/custom.css">
		<link rel="stylesheet" href="https://piagno.ch/not_w3.css">
		<script>
			generateLink = ()=>{
				const userName = document.getElementById('userName').value
				const link = 'https://tool.piagno.ch/twitter/feed.php?userName='+userName
				const linkElement = document.getElementById('link')
				linkElement.href = link
				linkElement.innerHTML = link
			}
		</script>
		<style>
			#twitt{
				max-width: 30%;
				margin: 0 auto;
			}
			@media(max-width:900px){
				#twitt{max-width:100%}
			}
		</style>
	</head>
	<body class="w3-center w3-black w3-mobile">
		<div id="twitt">
			<h1>Twitter RSS-Feed</h1>
			<label>Enter Username:</label>
			<div class="input"><div><input type="text" id="userName" /></div></div>
			<div><button type="button" onclick="generateLink()">Generate RSS-Link</button></div>
			<a href="#" id="link"></a>
		</div>
	</body>
</html>