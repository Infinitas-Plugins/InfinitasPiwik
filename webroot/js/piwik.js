try {
	var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", trackingId);

	if (typeof piwikSearch !== 'undefined') {
		piwikTracker.trackSiteSearch( 
			piwikSearch.keyword,
			piwikSearch.category,
			piwikSearch.results
		);
		piwikTracker.trackPageView();
		piwikTracker.enableLinkTracking();
	} else {
		if(typeof customVariables !== 'undefined') {
			$.each(customVariables.page, function(k, v) {
				piwikTracker.setCustomVariable(parseInt(v.id), v.name, v.value, v.scope);
			});
			$.each(customVariables.visit, function(k, v) {
				piwikTracker.setCustomVariable(parseInt(v.id), v.name, v.value, v.scope);
			});
		}
		piwikTracker.trackPageView();
		piwikTracker.enableLinkTracking();
	}
} catch(err) {}