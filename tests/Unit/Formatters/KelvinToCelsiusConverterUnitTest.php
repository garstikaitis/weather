<?php

namespace Tests\Unit\Formatters;

use App\Formatters\KelvinToCelsiusConverter;
use Tests\TestCase;

class KelvinToCelsiusConverterUnitTest extends TestCase
{
    public function tests_correctly_formats_data()
    {
        $temperature = KelvinToCelsiusConverter::convert(300.15);
        $this->assertTrue($temperature === (float) 27.0);
    }
}
