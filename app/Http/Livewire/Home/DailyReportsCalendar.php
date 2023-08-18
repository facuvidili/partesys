<?php

namespace App\Http\Livewire\Home;

use App\Models\Crew;
use App\Models\DailyReport;
use App\Models\Holiday;
use Asantibanez\LivewireCalendar\LivewireCalendar;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class DailyReportsCalendar extends LivewireCalendar
{
    public $dailyReports;
    public $events;
    public $lastConsolidationMonth;
    public $lastConsolidationYear;
    public $crew;

    protected $listeners = [
        'showDailyReports',

    ];

    public function events(): Collection
    {
        //POR SI EVENTS ES NULL
        if ($this->events) {
            return $this->events;
        } else {
            return collect([[
                'id' => '1',
                'title' => '',
                'description' => '',
                'date' => "1990-01-01",
            ]]);
        }
    }

    public function showDailyReports(Crew $crew, $reportIds, $lastConsolidationMonth, $lastConsolidationYear)
    {
        //FECHA DE ULTIMA CONSOLIDACION 
        $this->lastConsolidationMonth = $lastConsolidationMonth;
        $this->lastConsolidationYear = $lastConsolidationYear;
        $this->dailyReports = null;
        $this->events = null;
        $this->crew = $crew;
        // dd($reportIds);

        //OBTENGO LOS PARTES SEGUN IDS
        if ($reportIds) {

            //   $accountsIds=[];
            // foreach (Auth::user()->company->accounts as $account) {
            //     $accountsIds[]=$account->id;
            // }
            $this->dailyReports = DailyReport::findMany($reportIds);

            $dailyReportsDisabled = collect();
            foreach ($this->dailyReports as $key => $report) {
                if (!Auth::user()->company->accounts->contains('id', $report->account_id)) {
                    $dailyReportsDisabled->add($report);
                    unset($this->dailyReports[$key]);
                }
            }
            //PASO A EVENTO LOS REPORTES DESHABILITADOS

            $reportsDiabledEvents = $dailyReportsDisabled->map(function (DailyReport $report) {
                return [
                    'id' => 'Parte en otra Compañía',
                    'title' => 'Parte en otra Compañía',
                    'description' => 'Clasificado',
                    'date' => Carbon::parse(date('Y-m-d h:m:s', strtotime($report->work_start_date))),
                ];
            });


            //PASO A EVENTOS LOS REPORTES
            $reportsEvents = $this->dailyReports->map(function (DailyReport $report) {
                return [
                    'id' => $report->id,
                    'title' => 'Parte N°: ' . $report->id,
                    'description' => 'Total: ' . ' $' . number_format($report->total, 2, '.', ','),
                    'date' => Carbon::parse(date('Y-m-d h:m:s', strtotime($report->work_start_date))),
                ];
            });
        }
        //OBTENGO LOS FERIADOS
        $holidays = Holiday::all();
        if ($holidays) {
            //PASO A EVENTO LOS FERIADOS
            $holidaysEvents = $holidays->map(function (Holiday $holiday) {
                return [
                    'id' => 'feriado',
                    'title' => 'FERIADO',
                    'description' => $holiday->description,
                    'date' => Carbon::parse(date('Y-m-d h:m:s', strtotime($holiday->date))),
                ];
            });
        }
        // dd($holidaysEvents);
        // dd($reportsEvents);
        //dd($this->events);

        //JUNTO LOS EVENTOS DE PARTES Y FERIADOS
        if (!$reportsEvents->isEmpty() && $holidays && !$reportsDiabledEvents->isEmpty()) {
            $this->events = $reportsEvents->merge($holidaysEvents)->merge($reportsDiabledEvents);
        } elseif (!$reportsEvents->isEmpty() && !$reportsDiabledEvents->isEmpty()) {
            $this->events = $reportsEvents->merge($reportsDiabledEvents);
        } elseif (!$reportsEvents->isEmpty() && $holidays) {
            $this->events = $reportsEvents->merge($holidaysEvents);
        } elseif ($holidays && !$reportsDiabledEvents->isEmpty()) {
            $this->events = $holidaysEvents->merge($reportsDiabledEvents);
        } elseif (!$reportsEvents->isEmpty()) {
            $this->events = $reportsEvents;
        } elseif ($holidays) {
            $this->events = $holidaysEvents;
        } elseif (!$reportsDiabledEvents->isEmpty()) {
            $this->events = $reportsDiabledEvents;
        }

        // dd($this->events);

        // dd($this->events);
    }

    public function onDayClick($year, $month, $day)
    {

        //HAY PARTE O FERIADO
        $hay = false;
        $nextDay = false;
        $consol = false;
        $lastReport = null;
        $nextReport = null;

        // dd($this->crew);
        //SI EL DIA COINCIDE CON ALGUN PARTE
        if ($this->crew->dailyReports) {

            foreach ($this->crew->dailyReports as $report) {

                // dd(date_format(Carbon::createFromDate($year , $month , $day),'d-m-Y'));
                // dd(date_format(Carbon::createFromDate($report->work_start_date),'d-m-Y'));

                if ((date_format(Carbon::createFromDate($year, $month, $day), 'd-m-Y')) == (date_format(Carbon::createFromDate($report->work_start_date), 'd-m-Y'))) {
                    $hay = true;
                }
                if ((date_format((Carbon::createFromDate($year, $month, $day)->addDays(1)), 'd-m-Y')) == (date_format((Carbon::createFromDate($report->work_start_date)), 'd-m-Y'))) {
                    if ($report) {
                        $nextReport = $report;
                    } else {
                        $nextReport = null;
                    }
                }
                if ((date_format((Carbon::createFromDate($year, $month, $day)->subDays(1)), 'd-m-Y')) == (date_format((Carbon::createFromDate($report->work_start_date)), 'd-m-Y')) && $report->work_start_date != $report->work_end_date) {
                    if ($report) {
                        $lastReport = $report;
                    } else {
                        $lastReport = null;
                    }
                }
            }
        }
        // VERIFICA LA ULTIUMA CONSOLIDACION
        if ($this->lastConsolidationYear) {
            if ($year < $this->lastConsolidationYear) {
                $consol = true;
            } else if ($year == $this->lastConsolidationYear && $month <= $this->lastConsolidationMonth) {
                if ($year < $this->lastConsolidationYear) {
                    $consol = true;
                } else if ($year == $this->lastConsolidationYear && $month <= $this->lastConsolidationMonth) {
                    $consol = true;
                }
            }
            //  VERIFICA QUE NO SEA UN DIA DESPUES DE HOY
            //  VERIFICA QUE NO SEA UN DIA DESPUES DE HOY
            if (($month == Carbon::now()->month && $year == Carbon::now()->year && $day > Carbon::now()->day) || ($year == Carbon::now()->year && $month > Carbon::now()->month) || ($year > Carbon::now()->year)) {
                $nextDay = true;
            }


            //SI ALGUNO COINCIDE
            if ($hay || $nextDay || $consol) {
                if ($nextDay) {
                    $this->dispatchBrowserEvent('alertReport', ['message' => 'El día no puede ser posterior al día de hoy']);
                }
                if ($hay) {
                    $this->dispatchBrowserEvent('alertReport', ['message' => 'Ya existe un parte para esta cuadrilla en este día']);
                }
                if ($consol) {
                    $this->dispatchBrowserEvent('alertReport', ['message' => 'Ya cerró la consolidación para los partes de este mes']);
                }
            } else {

                $this->emit('showHours', $year, $month, $day, $nextReport, $lastReport);
            }
        }
    }

    public function onEventClick($eventId)
    {
        if (!($eventId == 'feriado') && !($eventId == 'Parte en otra Compañía')) {


            $this->emit('showEvent', $eventId);
        } elseif ($eventId == 'Parte en otra Compañía') {
            // $this->dispatchBrowserEvent('alertReport', ['message' => 'Clasificado!']);
        } else {

            $this->dispatchBrowserEvent('alertReport', ['message' => 'Es Feriado! A descansar!']);
        }
    }
}
