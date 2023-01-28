<?php

return [
	'providers' => [
		'open_weather' => [
			'api_key' => env('OPEN_WEATHER_MAP_API_KEY')
		]
	],
	'integrator' => [
		'whatagraph' => [
			'api_key' => env('WG_API_KEY'),
			'external_app_id' => env('WG_EXTERNAL_APP_ID')
		]
	]
];