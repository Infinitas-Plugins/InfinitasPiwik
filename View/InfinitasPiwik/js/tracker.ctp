<?php
	list($visit, $page) = array_values($this->Piwik->customVariables());
?>
var trackingSite = '<?php echo $infinitasPiwik['site']; ?>',
	trackingId = <?php echo $infinitasPiwik['site_id']; ?>,
	protocol = 'http',
	customVariables = {
		page: <?php echo json_encode($page); ?>,
		visit: <?php echo json_encode($visit); ?>
	};

if(document.location.protocol == "https:") {
	protocol = 'https';
}

var pkBaseURL = protocol + '://' + trackingSite + '/';
document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));