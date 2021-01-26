<?php

/*
*       Event Scheduling Helper Class
*       Purpose: take some functionality away from models and controllers that don't quite belong there
*           and put it into a reusable helper class
*/

namespace App\Helpers\Events;

use Carbon\Carbon;

class SlotMachine
{
    protected $date = null;
    protected $start = null;
    protected $end = null;
    protected $interval = null;
    protected $value = null;

    // A list of programmed timings 
    public static $validIntervals = [
        '30 minutes',
        '1 hour',
        '2 hours',

        // LAST ELEMENT MUST BE A FULL LENGTH INTERVAL
        'Full Event'
    ];

    protected static $intervalMappings = [
        '30 minutes' => .5,
        '1 hour' => 1,
        '2 hours' => 2,
        // 'Full Event' has special functionality
    ];

    // constructor
    public function __construct(Carbon $date, float $start_hour, float $end_hour, string $interval, float $value_per_slot)
    {
        // make sure the slot machine can accept the values
        if(!self::validate($start_hour,$end_hour, $interval)) {
            throw new SlotMachineException('Invalid currency inserted into slot machine!');
        } else if ($value_per_slot <= 0) {
            throw new SlotMachineException('Slot machines require cash to spin!');
        }

        // stage the slot machine
        $this->date = $date->format('Y-m-d');
        $this->start = $start_hour;
        $this->end = $end_hour;
        $this->interval = $interval;
        $this->value = $value_per_slot;
    }

    // activate slot machine
    // return array of "slots" with start and end times as Carbon objects
    public function run()
    {
        if ($this->interval == end(self::$validIntervals)) {
            return array($this->spit($this->numToTimeString($this->start), $this->numToTimeString($this->end)));
        } else {
            return $this->spin();
        }
    }

    // run when interval is not full event
    protected function spin()
    {
        $reward = [];
        $time = floatval($this->start);
        
        while ($time < $this->end) {
            $start_timestring = $this->numToTimeString($time);
            $time += self::$intervalMappings[$this->interval];
            $end_timestring = $this->numToTimeString($time);

            $reward[] = $this->spit($start_timestring, $end_timestring);
        }

        return $reward;
    }

    // create return array
    protected function spit($start_timestring, $end_timestring) {
        return [
            'starting_at' => Carbon::parse($this->date . ' ' . $start_timestring), 
            'ending_at' => Carbon::parse($this->date . ' ' . $end_timestring),
            'capacity' => $this->value,
        ];
    }

    // turn integer into a timestring (i.e. '15:00:00')
    protected function numToTimeString($num)
    {
        $hour = floor($num);
        $minutes = fmod($num, $hour) * 60;
        return str_pad(strval($hour), 2, "0", STR_PAD_LEFT) . ':' . str_pad(strval($minutes), 2, "0", STR_PAD_LEFT) . ':00';
    }

    // make sure that the slot machine can use the values given
    protected static function validate(float $start, float $end, string $interval) {
        if($end <= $start) {
            return false;
        } else if ($interval == end(self::$validIntervals)) {
            return true;
        } else if(!isset(self::$intervalMappings[$interval])) {
            return false;
        } else {
            $interval_value = self::$intervalMappings[$interval];
            $hanging_time = fmod(($end - $start), $interval_value);
            return !($hanging_time > 0);
        }
    }
}