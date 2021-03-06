<!doctype html>
<html>
	<head>
		<title>AttwFramework</title>
		
		<link rel="stylesheet" href="Application/Public/css/main.css" type="text/css" />
		<link rel="favicon" href="Application/Public/images/logo2.ico" />
	</head>
	<body>
		<header>
			<div class="logo">
				<img src="Application/Public/images/AF-logo1.png" width="250px" />
			</div>
			<div class="right">
				
			</div>
		</header>
		<div class="content">
			<div class="message"><span style="font-size: 50px">Welcome to your project with <b>AttwFramework</b>!</span><br /><br /><br />
			<a href="#start" class="btn btn-default" style="font-size: 32px;">Start</a>
			</div>
			<div class="start-configs"><a id="start"></a>
				<div class="title"><span style="font-size: 32px;">Starting configurations</span></div>
				<div class="content-configs">
					<div id="database" class="section">
						<div class="title"><span style="font-size: 26px;">Database configurations</span></div>
						<div class="description">To configurate the database, define a default connection in <span style="font-family: monospace; white-space: pre;">Application/Configurations/db_connections.php</span>.</div>
						<div class="title" style="margin-top: 10px;"><span style="font-size: 22px;">Exmaple</span></div>
						<pre class="php">
	use Attw\DB\Connection\MySQLConnectorConfig;
	use Attw\DB\Connection\PDOConnector;
	use Attw\DB\Collection;
							
	$connector_config = new MySQLConnectorConfig( 'localhost', 'test', 'root', '' );
	$connector = new PDOConnector( $connector_config );
							
	Collection::add( 'Default', $connector );
						</pre>
					</div>
					<div class="section" id="others">
						<div class="title"><span style="font-size: 26px;">Other configurations</span></div>
						<div class="description">To other configurations, go to <span style="font-family: monospace; white-space: pre;">Application/Configurations.php</span>.</div>
					</div>
				</div>
			</div>
			<div class="smarty-example">
				{$message}
			</div>
		</div>
		<footer>
			<div class="links">
				<a href="http://github.com/AttwFramework" class="link1" target="_blank"><img src="Application/Public/images/github-icon.png" width="64px" style="border-radius: 50px;" /></a>
				<a href="http://facebook.com/gabriel.forca" class="link1" target="_blank"><img src="Application/Public/images/facebook-icon.png" width="64px" style="border-radius: 50px;" /></a>
				<a href="http://twitter.com/GabrielJMJ" class="link1" target="_blank"><img src="Application/Public/images/twitter-icon.png" width="64px" style="border-radius: 50px;" /></a>
			</div>
		</footer>
	</body>
</html>