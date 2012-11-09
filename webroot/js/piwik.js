try {
	var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", trackingId);
	piwikTracker.trackPageView();
	piwikTracker.enableLinkTracking();
} catch( err ) {}