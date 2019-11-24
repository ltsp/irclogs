<!DOCTYPE html>
<html lang="en-US">
<head>

	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<title>IRC Logs - LTSP</title>
	<link rel="shortcut icon" href="https://ltsp.org/favicon.ico" type="image/x-icon">
	<!-- Set the viewport width to device width for mobile -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>About | LTSP</title>
	<meta property="og:title" content="IRC Logs" />
	<meta property="og:locale" content="en_US" />
	<meta name="description" content="Linux Terminal Server Project" />
	<meta property="og:description" content="Linux Terminal Server Project" />
	<link rel="canonical" href="http://irclogs.ltsp.org/" />
	<meta property="og:url" content="http://irclogs.ltsp.org/" />
	<meta property="og:site_name" content="LTSP" /> 
	<!-- what this for?...
	<script type="application/ld+json"> 
		{"@type":"WebSite","headline":"About","url":"https://ltsp.org/","publisher":{"@type":"Organization","logo":{"@type":"ImageObject","url":"https://ltsp.org/logo.png"}},"name":"LTSP","description":"Linux Terminal Server Project","@context":"http://schema.org"}
		</script>
	-->
	<!-- Included CSS Files -->
	<link rel="stylesheet" href="/stylesheets/foundation.css">
	<link rel="stylesheet" href="/stylesheets/app.css">
	<link rel="stylesheet" href="/stylesheets/navfooter.css">

</head>
<body>

	<!-- container -->
	<div class="container">

		<div class="row">

	    	<!-- header -->
			<div class="twelve columns" style="display: flex; align-items: center">
				<div><a href="https://ltsp.org/"><img class="logo" src="logo.png" alt="Linux Terminal Server Project - LTSP" /></a></div>
			</div>
			<div>
				<h1>IRC chat logs for #ltsp on irc.freenode.net (<A CLASS="webchatlink" TARGET="_blank" HREF="<?php echo $this->link_webchat; ?>">webchat</A>)</h1>
			</div>
	   
			<FORM ACTION="" METHOD="get">
				<DIV CLASS="searchbox" STYLE="width: 220px; float: left;">
				  Request log from specific day: <BR>
				  <?php $this->formatDateSelector(); ?>
				</DIV>
				<DIV CLASS="searchbox" STYLE="float: left;">
				  Search all logs by username and/or keyword (will take a few minutes): <BR>
				  <INPUT TYPE="text" NAME="u" CLASS="username novalue" ONFOCUS="if (this.value == 'username') {this.value = ''; this.className = 'username';}" VALUE="username"><INPUT TYPE="text" NAME="k" CLASS="keyword novalue" ONFOCUS="if (this.value == 'keyword') {this.value = ''; this.className = 'keyword';}" VALUE="keyword"><INPUT TYPE="submit" VALUE="Go">
				</DIV>
			</FORM>
			<BR STYLE="clear: both;">
			
			<DIV CLASS="irclogs">
