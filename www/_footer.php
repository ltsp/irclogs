															
</DIV> <!-- this div is inside the row with the rest of header and logs text -->
</div>
<!-- now we are outside div and take up whole width of page -->
	<div class="navfooter">
		<div class="row">

<?php
require 'simple_html_dom.php';
$html = file_get_html('https://ltsp.org/');
echo $html->find('div[class=side-bar]')[0];
?>

		<hr> 
		<footer role="contentinfo" style="padding: 0px 10px;">
			<p class="text-small text-grey-dk-000 mb-0">Copyright &copy; 2000-2019 the <a href="https://github.com/ltsp/ltsp/graphs/contributors">LTSP developers</a></p>
		</footer>
		</div>
	</div>
</div>
