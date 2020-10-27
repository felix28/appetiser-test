<?php

namespace App\Http\Controllers;

use App\Http\Resources\CalendarEventResource;
use App\Http\Requests\AddCalendarEventRequest;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Carbon\Carbon;
use App\CalendarEvent;
use Illuminate\Http\Request;

class CalendarEventController extends Controller
{
    const MAX_DAYS = 31;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        $calendarEvents = $this->getData();

        if ($calendarEvents) {
            return CalendarEventResource::collection($calendarEvents);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddCalendarEventRequest $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');

        $this->destroy($month, $year);

        $calendarEvents = $this->setData($request);        
        $result = $this->batchInsert($calendarEvents);

        if ($result !== false) {
            $events = CalendarEvent::where('month', $month)->where('year', $year)->get();

            if ($events) {
                return response()->json(['data' => $events], 201);   
            }
        }
    }

    private function getData()
    {
        $rowsPerPage = self::MAX_DAYS;
        
        $calendarEvents = QueryBuilder::for(CalendarEvent::class)   
                ->allowedFilters([
                    AllowedFilter::exact('month'),
                    AllowedFilter::exact('year')
                ])
                ->paginate($rowsPerPage);

        if ($calendarEvents) {
            return $calendarEvents;
        }
    }

    private function setData($request)
    {
        $name  = $request->input('name');
        $month = $request->input('month');
        $year  = $request->input('year');
        $days  = $request->input('days');

        CalendarEvent::where('month', $month)
            ->where('year', $year)
            ->delete();

        $dateDays = $this->getDays($month, $year, $days);

        $calendarEvents = [];

        if (count($dateDays)) {
            foreach ($dateDays as $date) {
                $calendarEvents[] = [
                    'name'       => $name,
                    'month'      => $month,
                    'year'       => $year,
                    'event_date' => $date,
                ];
            }

            return $calendarEvents;
        }
    }

    private function batchInsert($calendarEvents = [])
    {
        $calendarEvent = new CalendarEvent;
        $columns = ['name', 'month', 'year', 'event_date'];
        $values = $calendarEvents;
        $batchSize = self::MAX_DAYS; 

        $result = batch()->insert($calendarEvent, $columns, $values, $batchSize);

        return $result;
    }

    public function getDays(Int $month, Int $year, $selectedDays = [])
    {   
        $dateDays = [];
        $dateDay = new Carbon($year.'-'.$month.'-01');
        $year = $dateDay->year;
        $month = $dateDay->month;
        $days = $dateDay->daysInMonth;

        foreach (range(1, $days) as $day) {
            $date = Carbon::createFromDate($year, $month, $day);

            if ($date->isMonday() === true && in_array('monday', $selectedDays)) {
                $dateDays[] = (
                    $year.'-'.$this->leadZero($month).'-'.$this->leadZero($date->day)
                );
            }

            if ($date->isTuesday() === true && in_array('tuesday', $selectedDays)) {
                $dateDays[] = (
                    $year.'-'.$this->leadZero($month).'-'.$this->leadZero($date->day)
                );
            }

            if ($date->isWednesday() === true && in_array('wednesday', $selectedDays)) {
                $dateDays[] = (
                    $year.'-'.$this->leadZero($month).'-'.$this->leadZero($date->day)
                );
            }

            if ($date->isThursday() === true && in_array('thursday', $selectedDays)) {
                $dateDays[] = (
                    $year.'-'.$this->leadZero($month).'-'.$this->leadZero($date->day)
                );
            }

            if ($date->isFriday() === true && in_array('friday', $selectedDays)) {
                $dateDays[] = (
                    $year.'-'.$this->leadZero($month).'-'.$this->leadZero($date->day)
                );
            }

            if ($date->isSaturday() === true && in_array('saturday', $selectedDays)) {
                $dateDays[] = (
                    $year.'-'.$this->leadZero($month).'-'.$this->leadZero($date->day)
                );
            }

            if ($date->isSunday() === true && in_array('sunday', $selectedDays)) {
                $dateDays[] = (
                    $year.'-'.$this->leadZero($month).'-'.$this->leadZero($date->day)
                );
            }
        }

        return $dateDays;
    }

    private function leadZero(Int $monthOrDay)
    {
        $length = 2;

        return str_pad($monthOrDay, $length, '0', STR_PAD_LEFT);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CalendarEvent  $calendarEvent
     * @return \Illuminate\Http\Response
     */
    public function show(CalendarEvent $calendarEvent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CalendarEvent  $calendarEvent
     * @return \Illuminate\Http\Response
     */
    public function edit(CalendarEvent $calendarEvent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CalendarEvent  $calendarEvent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CalendarEvent $calendarEvent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CalendarEvent  $calendarEvent
     * @return \Illuminate\Http\Response
     */
    public function destroy(Int $month, Int $year)
    {
        CalendarEvent::where('month', $month)->where('year', $year)->delete();
    }
}
