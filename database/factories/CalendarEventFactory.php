<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\CalendarEvent;
use Faker\Generator as Faker;

$factory->define(CalendarEvent::class, function (Faker $faker) {
    return [
        'name'       => $faker->realText(255),
        'month'      => $faker->numberBetween(1, 12),
        'year'  	 => $faker->numberBetween(2020, 2022),
        'days'		 => $faker->randomElement([
        	'monday', 
        	'tuesday', 
        	'wednesday', 
        	'thursday', 
        	'friday', 
        	'saturday', 
        	'sunday'
        ]),
    ];
});
