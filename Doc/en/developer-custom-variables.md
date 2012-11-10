You are able to set custom tracking variables via the Events plugin. Piwik has two types of custom variables and a hard limit on both.

- `page` variables change per page such as `product` or `category`.
- `visit` variables are per visit such as `user`

Both types of custom variables have a limit of `5`. In total you can have `10` custom variables (`5` of each).

#### Custom variables

Custom variables are made up of the following fields:

- `id` this is the position of the custom variable, (1 => 5)
- `name` this is the name of the variable and can be any text (short concise names are easier to view in Piwik)
- `value` this is the value of the custom variable
- `scope` This can be either `page` or `visit`

#### Example

The Shop plugin makes use of custom variables to track a number of things such as the currency being used and the product / category being viewed.

[![](http://assets.infinitas-cms.org/docs/Plugins/InfinitasPiwik/custom-variables-reports.png "Custom variable reporting")](http://assets.infinitas-cms.org/docs/Plugins/InfinitasPiwik/custom-variables-reports.png)

[![](http://assets.infinitas-cms.org/docs/Plugins/InfinitasPiwik/custom-variables-overview.png "Custom variable overview")](http://assets.infinitas-cms.org/docs/Plugins/InfinitasPiwik/custom-variables-overview.png)