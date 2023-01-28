<?php

namespace Tests\Unit\Formatters;

use App\Formatters\OpenWeatherFormatter;
use Tests\TestCase;

class OpenWeatherFormatterUnitTest extends TestCase
{
    public function tests_correctly_formats_data()
    {
        $openWeatherStub = json_decode(
            file_get_contents(base_path() . "/tests/stubs/open_weather.json"),
            associative: true
        );

        $formatted = OpenWeatherFormatter::format($openWeatherStub);
        $this->assertCount(7, $formatted);
        $temperatureData = $formatted->first();
        $this->assertObjectHasAttribute("city", $temperatureData);
        $this->assertObjectHasAttribute("minTemp", $temperatureData);
        $this->assertObjectHasAttribute("maxTemp", $temperatureData);
        $this->assertObjectHasAttribute("date", $temperatureData);
        $this->assertObjectHasAttribute("averageTemp", $temperatureData);
    }
}
