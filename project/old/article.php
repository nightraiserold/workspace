<!DOCTYPE HTML>
<html oncontextmenu="alert('Samrtie!!! dont try to view the code'); return false">
	<head>
		<title>MRCET</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400italic,700|Open+Sans+Condensed:300,700" rel="stylesheet" />
<script src="js/shorcuts.js"></script>
		<script src="js/jquery.min.js"></script>
		<script src="js/skel.min.js"></script>
		<script src="js/skel-panels.min.js"></script>
		<script src="js/init.js"></script>
<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
		<noscript>
			<link rel="stylesheet" href="css/skel-noscript.css" />
			<link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="css/style-desktop.css" />
			<link rel="stylesheet" href="css/style-wide.css" />
		</noscript>
		<!--[if lte IE 9]><link rel="stylesheet" href="css/ie9.css" /><![endif]-->
		<!--[if lte IE 8]><script src="js/html5shiv.js"></script><link rel="stylesheet" href="css/ie8.css" /><![endif]-->
		<!--[if lte IE 7]><link rel="stylesheet" href="css/ie7.css" /><![endif]-->
	</head>
	<!--
		Note: Set the body element's class to "left-sidebar" to position the sidebar on the left.
		Set it to "right-sidebar" to, you guessed it, position it on the right.
	-->
	<body class="left-sidebar" >
<script>
shortcut.add("F12",function() {
	alert("Smartie!! even this key is blocked");
});
shortcut.add("Ctrl+S",function() {
	alert("Smartie!! You cant save the page");
});
</script>

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Content -->
					<div id="content">
						<div id="content-inner">
					
							<!-- Post -->
								<article class="is-post ">
									<header>
										
										

										<?php 

session_start();
$con=mysql_connect('localhost','root','livetolearn');
$db=mysql_select_db('updates');
$qsid=$_SESSION['sid'];
$b=$_GET['dbid'];
$arname = mysql_query("SELECT * FROM dbs WHERE dbid = $b");
$naam = mysql_fetch_assoc($arname);
if($_SESSION['name']=="")
{
header('Location:login.php');
}
echo"
										<h2>$naam[dbname]</h2> ";
echo"<span class='byline'>$_SESSION[name],handle articles here</span>";

?>
<?php
$fi5=mysql_query("SELECT * FROM favs WHERE studid = '$qsid' AND dbid = $b") or die("this is nt working");
if(mysql_num_rows($fi5)>=1)
{
echo'<b>Added to my dashboards</b><img src="images/success.png" height="30px" width="30px">
';
echo "
<form method='get' action='remfav.php'>
<button class='button' value=$b name=dbid>Remove</button>
</form>";
}
else
{
echo "
<form method='get' action='addtofav.php'>
<button class='button' value=$b name=dbid>Subscribe to quick feeds</button>
</form>";

}
?>
<?php
echo"</header>
<form action='articpost.php?dbid=$b' method='post'>
<textarea rows='3' cols='9' name='art' class='span9'> </textarea>
<input type='submit' value='Post' class='button' name='artpost'/></form>
</article>";
?>
<?php




$q=mysql_query("SELECT * FROM articles WHERE dbid LIKE  $b ORDER BY aid DESC") or die("No such dashboards found");
$search=$_POST['search'];
$output='';
$ds = $_GET['dbid'];
if(isset($_POST['search'])&&$search!=="")
{
$q=mysql_query("SELECT * FROM articles WHERE dbid = $ds AND postby LIKE '$search' ORDER BY aid DESC") or die("wrong query");
$search="";

}
if(mysql_num_rows($q)==0)
{
echo " &nbsp;&nbsp;&nbsp;&nbsp;  ".$_SESSION['name'];
echo " <b>NO posts exists yet </b>";

}
else
{
while(($res=mysql_fetch_assoc($q)) !== false)
{
$mn=array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
$date = $res['time'];
$d = date_parse_from_format("Y/m/d H:i:s", $date);


$numb=$d['month']-1;
$nsql=mysql_query("SELECT COUNT(aid) FROM comments WHERE aid LIKE $res[aid] ORDER BY aid DESC") or die("ass array prob");
$nscomb=mysql_fetch_array($nsql);

$output .="
<article class='is-post is-post-excerpt'>
<div class='info'>
<b align='center'>On</b>
<span class='date'><span class='month'><b>$mn[$numb]</b></span> <span class='day'>$d[day]</span><span class='year'>$d[year]</span></span>
<ul class='stats'>
<li>Comment</li>
											<li><a href='fullview.php?aid=$res[aid]' class='fa fa-comment'>$nscomb[0]</a></li>

</ul>

</div>
<hr>
<p>
<b>Post</b>
<p><strong>Hello!</strong>  $res[message]</p>
<hr>
<b>Posted by :: </b> $res[postby]
</article> <hr><br>";

}
echo $output;
}

$messing = $_POST['art'];
$date = date('Y-m-d');


if(isset($_POST['artpost']))
{
$bes=$_SESSION['name'];

$fsub=mysql_query("INSERT INTO articles (dbid,message,postby,time) VALUES ($dbid,'$messing','$bes','$date')") or die("insertion fail");
$cq=mysql_query("SELECT aid FROM comments WHERE aid LIKE '$res[aid]' ORDER BY aid DESC") or die("Gone");
$_SESSION['aid']=$cq;
$z=$_GET['dbid'];
echo"<h1>$_SESSION[aid]</h1>";
header("Location:article.php?'$z'");
header("Location:article.php?'$z'");
}
if(isset($_POST['Logout']))
{

session_destroy();
header('Location:login.php');
}


?>


						</div>
					</div>

				<!-- Sidebar -->
					<div id="sidebar">
					
						<!-- Logo -->
							<div id="logo">
								<h1><a href="index.php">MRCET</a></h1>
							</div>
<!--search-->
					
						<!-- Nav -->
							<nav id="nav">



<section class="search">
								<form method="post" action="article.php?dbid=<?php echo$_GET['dbid']?>">
									<input type="text" class="text" name="search" placeholder="Search here.." />
								</form>
							</section>


								<ul>
									<li ><a href="index.php">About LMS</a></li>
									<li><a href="mydash.php">Quick Fedds</a></li>
									<li ><a href="dash.php">Dash Boards</a></li>
										
									<?php
									
									if($_SESSION['status']=='student')
									{
									echo"<li><a href='student.php'>Latest Updates</a></li>";
									}
									else
									{
									echo"<li><a href='faculty.php'>Post Updates</a></li>";
									}
									?>
									<li><a href="books.php">Library</a></li>
<li><a href="bookrate.php">Rate books</a></li>
<li><a href='feedback.php'>Feed Back</a></li>
									<li><form action="logout.php" method="post" align="center"><input class="button" type="submit" value="Logout" name="Logout"/></form></li>
								</ul>
							</nav>

						
							
					
						<!-- Text -->
							<section class="is-text-style1">
								<div class="inner">
									<p>
										&copy; 2013 MRCET.<br />
										<strong>Designed by:</strong> <a href="https://www.facebook.com/Ramblerssolutions">Ramblers Solutions</a> 
									</p>
								</div>
							</section>
					
					
						<!-- Copyright -->
							

					</div>

			</div>

	</body>
</html>