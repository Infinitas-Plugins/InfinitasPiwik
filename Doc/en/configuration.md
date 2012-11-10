To get piwik up and running you will need to enter a few configuration details. Most importantly is where the Piwik tracker is and the site id.

### Configs

#### Tracking

##### piwik `required`

This is the url to the Piwik install. The protocol (`http` or `https`) is not required as this if taken from the site being tracked. So if your site is running ssl it will automatically use `https`. There should be **no** trailing slash either.

##### site\_id `required`

This is the id of your site **in Piwik**. An invalid site id specified here may result in tracking being saved to the incorrect site or not at all.

##### tracker\_cache

This is the time that will be sent as the cache header. The default is `1 week` when debug is disabled. If debug is enabled the cache will be set to `-1 day`, in other words already expired.

##### track\_admin

By default this option is set to false and will not track admin usage. Setting to true will allow admin tracking.

#### Reporting

##### report.site\_id

This can be left if you are reporting and tracking the same site. If you would like to report on a different site this can be set here.

##### report.auth\_token

This is the authorisation token required to get data from piwik. The default is `anonymous` which will fetch data from Piwik sites that are `public`. You will need to enter the authorisation token for any private sites that are being tracked.

> If none of the reports are displaying its a good chance that the auth token is missing, invalid or the site is not marked as public in Piwik.

If the required options are not configured **errors** will be displayed in the backend.