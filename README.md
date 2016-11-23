# Weather Station Plus

Display weather information for a specific US location.

## How to use

Weather Station Plus uses the <a href="http://openweathermap.org" target="_blank">Open Weather Map</a> api, so before you can display weather data on your site, you need to <a href="http://openweathermap.org" target="_blank">sign up</a> for an account and retrieve an API key.

When you have created an account, your API key can be located on your <a href="https://home.openweathermap.org/api_keys" target="_blank">profile page</a> on the API Keys tab.

Enter the API key on the admin settings page, found in **Settings > Weather Station Plus**.

<hr />

**International Users:** The Weather Station Plus shortcode accepts US zip codes **only**. This is subject to change moving forward, so users can specify a city/country.

<hr />


### Shortcodes

You can generate current weather by using one of the following shortcodes:

`[weather_app zip="#"]`

You should add the zip code of the location you want to display information for.

For example, to display weather information for Philadelphia, PA (19122) you would use the following shortcode:

`[weather_app zip="19122"]`

*Please note, this plugin is still being developed, and has not reached a stable release state. This means that any of the code contained in the plugin, including the shortcodes, are subject to change. When the plugin hits a stable release (ie: 1.0.0) the shortcodes will be finalized and documented here.*


### Widgets

*Coming Soon...*

## To Do:

* [ ] Add option toggle for metric/imperial measurements.
* [ ] Implement animated SVG weather icons.
* [ ] Initial page load will display data based on the users Geolocation.
* [ ] Implement city/country values, instead of zip codes, for international users.
* [ ] Build out additional shortcodes to display other data.
* [ ] Build out Weather Station widgets.
