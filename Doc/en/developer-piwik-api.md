The Piwik plugin includes libs for generating API request urls. The lib sets up default parameters and validates some of the fields making sure that only valid requests are made.

#### Presets

The PiwikApi lib includes a number of preset API calls that makes it easy to get started.

#### Report chart images

Part of the Piwik API includes rendering basic charts as images. The plugin includes a helper (`PiwikImageHelper`) for rendering most of the images. Some of the reports can be seen below:

##### Visit frequency

Callling the helper method:

	$this->PiwikImage->visitsFrequency();

Resulting url (will be wrapped in image tags when using this method)

	http://piwik.example.com/index.php?module=API&method=ImageGraph.get&apiModule=VisitFrequency&idSite=4&apiAction=get&token_auth=anonymous&graphType=evolution&column=nb_visits&period=day&date=previous30&width=920&height=200

[![](http://assets.infinitas-cms.org/docs/Plugins/InfinitasPiwik/report-visit-frequency.png "Visit frequency")](http://assets.infinitas-cms.org/docs/Plugins/InfinitasPiwik/report-visit-frequency.png)

##### Visit frequency

Callling the helper method:

	$this->PiwikImage->userBrowserPlugins();

Resulting url (will be wrapped in image tags when using this method)

	http://piwik.example.com/index.php?module=API&method=ImageGraph.get&apiModule=UserSettings&idSite=4&apiAction=getPlugin&token_auth=anonymous&graphType=verticalBar&column=nb_visits&period=day&date=previous30&width=920&height=200

[![](http://assets.infinitas-cms.org/docs/Plugins/InfinitasPiwik/report-browser-plugins.png "Browser plugins")](http://assets.infinitas-cms.org/docs/Plugins/InfinitasPiwik/report-browser-plugins.png)

There are a number of other preset methods available, and you can easily call other methods that have not been preset.

	$this->PiwikImage->chart($params, $options);


#### Piwik API

The docs for the Piwik API are available [here](http://piwik.org/docs/analytics-api/reference/). This explains all the params that can be used when building your own reports.