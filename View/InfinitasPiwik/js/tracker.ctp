var trackingSite = '<?php echo $infinitasPiwik['site']; ?>',
	trackingId = <?php echo $infinitasPiwik['site_id']; ?>,
	protocol = 'http';

if(document.location.protocol == "https:") {
	protocol = 'https';
}

var pkBaseURL = protocol + '://' + trackingSite + '/';
document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));