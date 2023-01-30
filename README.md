# Weather data integration with Whatagraph interface

This app will allow you to show data coming from OpenWeather API and push it to Whatagraph API.

## How to start project

1. Add extra configuration keys and values to your .env file

```
OPEN_WEATHER_MAP_API_KEY=
WG_API_KEY=
WG_EXTERNAL_APP_ID=
```

2. Run `composer install`
3. Run `npm install`
4. Run `php artisan prepare-wg`
5. Visit `/api/push-forecast`

## Commands

`php artisan prepare-wg`
This command creates integration metric & integration dimension inside Whatagraph.

`php artisan wipe-wg`
If you ever want to wipe data for given `external_app_id` just run this command. It will get all the data source, dimensions and metrics inside the app, and delete them.
