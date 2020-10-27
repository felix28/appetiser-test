<?php

namespace Tests\Feature;

use App\Http\Controllers\CalendarEventController;
use App\CalendarEvent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CalenderEventTest extends TestCase
{
	use RefreshDatabase;
    
    protected function setUp(): void
    {
        parent::setUp();

        $this->apiURL = 'api/calendar-events';

        $calendarEvent = factory('App\CalendarEvent')->make([
        	'year'  => 2020,
        	'month' => 10,//october
        	'days'  => ['monday'],
        ]);

        $this->data = $calendarEvent->toArray();

        $this->jsonStructure = [
            'data' => [
                [
                    'id', 
                    'name',
                    'month',
                    'year',
                    'event_date',
                ]
            ]
        ];
    }

    public function testGetAllMonday()
    {
    	$calendarEventController = new CalendarEventController;
    	$days = $calendarEventController->getDays(
    		$this->data['month'], 
    		$this->data['year'], 
    		$this->data['days']
    	);

    	$this->assertEquals('2020-10-05', $days[0]);
    	$this->assertEquals('2020-10-12', $days[1]);
    	$this->assertEquals('2020-10-19', $days[2]);
    	$this->assertEquals('2020-10-26', $days[3]);
    }

    public function testSave()
    {        
        $this->json('POST', $this->apiURL, $this->data)
            ->assertStatus(201)
            ->assertJsonStructure($this->jsonStructure);

        $this->assertEquals(4, CalendarEvent::count());
    }

    public function testDelete()
    {
        $this->testSave();

        $calendarEventController = new CalendarEventController;
        $calendarEventController->destroy($this->data['month'], $this->data['year']);

        $this->assertEquals(0, CalendarEvent::count());
    }

    public function testDisplayEvents()
    {
        $this->testSave();

        $month = $this->data['month'];
        $year = $this->data['year'];
        $url = $this->apiURL.'?filter[month]='.$month.'&filter[year]='.$year;

        $this->json('GET', $url)
            ->assertStatus(200)
            ->assertJsonStructure($this->jsonStructure);
    }
}
