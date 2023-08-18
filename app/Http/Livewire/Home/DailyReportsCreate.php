<?php

namespace App\Http\Livewire\Home;

use App\Models\Account;
use App\Models\Crew;
use App\Models\DailyReport;
use App\Models\Holiday;
use App\Models\Task;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;



class DailyReportsCreate extends Component
{

    use WithPagination;

    public $dailyReportShow;

    public $openFir = false;
    public $openHours = false;
    public $openTasks = false;
    public $openObs = false;
    public $openAccounts = false;

    public $startTimeMin = null;
    public $endTimeMax = null;

    public $taskDescription;
    public $taskDuration;

    public $totalHours;
    public $totalTasksHrs;
    public $fiftHours;
    public $hundHours;
    public $normalHours;
    public $fiftHoursPrice;
    public $hundHoursPrice;
    public $normalHoursPrice;
    public $foodQuan;
    public $food;

    public $crew;
    public $startDate;
    public $startTime;
    public $endTime;
    public $endDate;
    public $total;
    public $account;
    public $tasks;
    public $observation;

    protected $listeners = [
        'showHours', 'showCalendar', 'removeTask', 'selectAccount',
    ];

    public $rules = [
        'total' => 'required',
        'tasks' => 'required'
    ];

    public function render()
    {
        return view('livewire.home.daily-reports-create');
    }

    //LE DICE A CALENDAR Q MUESTRE EL CALENDARIO CON FILTROS
    public function showCalendar($id)
    {
        //TRAE LA CUADRILLA POR EL ID
        $this->crew = Crew::find($id);

        if ($this->crew->lastConsolidationDate()) {
            $lastConsolidationMonth = $this->crew->lastConsolidationDate()[0];
            $lastConsolidationYear = $this->crew->lastConsolidationDate()[1];
        } else {
            $lastConsolidationMonth = false;
            $lastConsolidationYear = false;
        }

        $dailyReportsIds = $this->crew->dailyReportsIds();
        

        $this->emit('showDailyReports', $this->crew, $dailyReportsIds, $lastConsolidationMonth, $lastConsolidationYear);

        $this->openFir = true;
    }

    public function showHours($year, $month, $day, $nextReport, $lastReport)
    {
        $this->openFir = false;
        $this->openHours = true;
        $this->startDate = $year . '-' . (strlen((string)$month) == 1 ? '0' . $month : $month) . '-' . (strlen((string)$day) == 1 ? '0' . $day : $day);
        $this->endDate = $this->startDate;



        $this->reset(
            'startTime',
            'endTime',
            'total',
            'normalHours',
            'fiftHours',
            'hundHours',
            'foodQuan',
            'normalHoursPrice',
            'fiftHoursPrice',
            'hundHoursPrice',
            'food'
        );

        //RESTRINGE LOS HORARIOS MINIMOS Y MAXIMOS SEGUN LOS PARTES EXISTENTES
        if ($lastReport ? $lastReport['work_start_date'] == $lastReport['work_start_date'] : false) {
            $this->startTimeMin = $lastReport['work_end_time'];
        } else {
            $this->startTimeMin = null;
        }

        if ($nextReport) {

            $this->endTimeMax = $nextReport['work_start_time'];
        } else {
            $this->endTimeMax = null;
        }
    }

    public function modalToggle($modal)
    {
        switch ($modal) {
            case 'calendar':
                $this->openHours = false;
                $this->openFir = true;
                break;
            case 'hours':
                $this->openAccounts = false;
                $this->openTasks = false;
                $this->openHours = true;
                break;
            case 'accounts':
                $this->validate([
                    'total' => 'required',
                ]);
                $this->emit('crew', $this->crew->id);
                $this->emit('contractor', $this->crew->contractor->id);
                $this->openHours = false;
                $this->openTasks = false;
                $this->openAccounts = true;
                break;
            case 'tasks':
                $this->openObs = false;
                $this->openTasks = true;
                break;
            case 'obs':
                // dd($this->totalTasksHrs, $this->totalHours);
                $this->validate([
                    'tasks' => 'required',
                    'totalTasksHrs' => Rule::in([$this->totalHours]),

                ]);
                $this->openTasks = false;
                $this->openObs = true;
                break;

            default:

                break;
        }
    }

    public function dayName($date)
    {
        $dayName = date('D', strtotime($date));;
        foreach (Holiday::all() as $holiday) {

            if ($holiday->date == $date) {

                $dayName = 'Sun';
            }
        }

        return $dayName;
    }

    public function reportCalculate()
    {

        $this->reset('normalHours', 'normalHoursPrice', 'fiftHours', 'fiftHoursPrice', 'hundHours', 'hundHoursPrice', 'food', 'foodQuan', 'total', 'totalHours', 'totalTasksHrs');
        $this->validate([
            'startTime' => 'required',
            'endTime' => 'required',
            'endDate' => 'required'
        ]);

        if ($this->crew->hour_price == null) {

            $hour_price = ($this->crew->activeContract()[0]->total_price / $this->crew->activeContract()[0]->months_duration) / 198;
        } else {
            $hour_price = $this->crew->hour_price;
        }

        if ($this->startDate == $this->endDate) {

            if ($this->startTime < $this->endTime) {

                if ($this->startTimeMin ? $this->startTime >= $this->startTimeMin : 'true') {

                    $costs = DB::select("CALL reportCalculate('" . $this->startTime . "','" . $this->endTime . "','" . $this->dayName($this->startDate) . "')");

                    if (!$this->crew->hour_price == null) {
                        $this->normalHours = $costs[0]->hours_per_concept;
                        $this->normalHoursPrice = $this->normalHours * $hour_price;
                    } else {
                        $this->normalHours = 0;
                        $this->normalHoursPrice = 0;
                    }

                    $this->fiftHours = $costs[1]->hours_per_concept;
                    $this->fiftHoursPrice = $this->fiftHours * $hour_price;

                    $this->hundHours = $costs[2]->hours_per_concept;
                    $this->hundHoursPrice = $this->hundHours * $hour_price;


                    if (($this->hundHours / 2 + $this->fiftHours / 1.5 + $this->normalHours) <= 9.9) {
                        $this->food = $costs[3]->value * $this->crew->amount_members;
                        $this->foodQuan = $this->crew->amount_members;
                    } else {
                        $this->food = $costs[3]->value * $this->crew->amount_members * 2;
                        $this->foodQuan = 2 * $this->crew->amount_members;
                    }


                    $this->total = $this->food + $this->normalHoursPrice + $this->fiftHoursPrice + $this->hundHoursPrice;
                } else {
                    $this->dispatchBrowserEvent('alertReport', ['message' => 'El horario de inicio no debe ser menor que ' . $this->startTimeMin]);
                }
            } else {
                $this->dispatchBrowserEvent('alertReport', ['message' => 'El horario de inicio no debe ser mayor que el horario de fin para el mismo día']);
            }
        } else {

            if ($this->startTimeMin ? $this->startTime >= $this->startTimeMin : 'true') {

                if ($this->endTimeMax ? $this->endTime <= $this->endTimeMax : 'true') {



                    $costsStart = DB::select("CALL reportCalculate('" . $this->startTime . "','" . '23:59' . "','" . $this->dayName($this->startDate) . "')");
                    $costsEnd = DB::select("CALL reportCalculate('" . '00:00' . "','" . $this->endTime . "','" . $this->dayName($this->endDate) . "')");



                    if (!$this->crew->hour_price == null) {
                        $this->normalHours = ($costsStart[0]->hours_per_concept) + ($costsEnd[0]->hours_per_concept);
                        $this->normalHoursPrice = $this->normalHours * $hour_price;
                    } else {
                        $this->normalHours = 0;
                        $this->normalHoursPrice = 0;
                    }


                    $this->fiftHours = ($costsStart[1]->hours_per_concept) + ($costsEnd[1]->hours_per_concept);
                    $this->fiftHoursPrice = $this->fiftHours * $hour_price;

                    $this->hundHours = ($costsStart[2]->hours_per_concept) + ($costsEnd[2]->hours_per_concept);
                    $this->hundHoursPrice = $this->hundHours * $hour_price;

                    if (($this->hundHours / 2 + $this->fiftHours / 1.5 + $this->normalHours) <= 9.9) {
                        $this->food = ($costsStart[3]->value + $costsEnd[3]->value) * $this->crew->amount_members;
                        $this->foodQuan = $this->crew->amount_members;
                    } else {
                        $this->food = ($costsStart[3]->value + $costsEnd[3]->value) * 2 * $this->crew->amount_members;
                        $this->foodQuan = 2 * $this->crew->amount_members;
                    }

                    $this->total = $this->food + $this->normalHoursPrice + $this->fiftHoursPrice + $this->hundHoursPrice;
                } else {

                    $this->dispatchBrowserEvent('alertReport', ['message' => 'El horario de fin no debe ser mayor que ' . $this->endTimeMax]);
                }
            } else {
                $this->dispatchBrowserEvent('alertReport', ['message' => 'El horario de inicio no debe ser menor que ' . $this->startTimeMin]);
            }
        }
        $this->totalHours=round($this->normalHours+$this->fiftHours/1.5+$this->hundHours/2,2);
        $this->reset('tasks');
        $this->emit('reportTotal', $this->total);
    }

    public function addTask()
    {
        $descriptions = [];
        if ($this->tasks) {

            foreach ($this->tasks as $task) {
                $descriptions[] = $task['description'];
            }
        }
       $this->refreshTaskHrs();
        
       
       
        if ( round($this->totalTasksHrs+((float)substr($this->taskDuration,0,2)+(((float)substr($this->taskDuration,3,2))/60)),2) <= $this->totalHours) {
            $this->validate([
                'taskDescription' => ['required', 'min:1', Rule::notIn($descriptions)],
                'taskDuration' => 'required|not_in:00:00',



            ]);



            $task = new Task();
            $task->description = $this->taskDescription;
            $task->time = $this->taskDuration;

            $this->tasks[] = $task;

            $this->totalTasksHrs+= (float)substr($this->taskDuration,0,2)+(((float)substr($this->taskDuration,3,2))/60);
            $this->totalTasksHrs=round($this->totalTasksHrs,2);
            $this->reset(['taskDescription', 'taskDuration']);
        }else{
            $this->dispatchBrowserEvent('alertReport', ['message' => 'El total de horas de las tareas no debe superar las ' . sprintf('%02d:%02d',(int)$this->totalHours,fmod($this->totalHours, 1) * 60). ' Hs']);
        }
    }

    public function refreshTaskHrs(){
        $this->totalTasksHrs=0;
        if ($this->tasks) {
            
            foreach ($this->tasks as $task) {
                $this->totalTasksHrs += (float)substr($task['time'],0,2)+(((float)substr($task['time'],3,2))/60);
                
            }
        }
    }

    public function removeTask($taskIndex)
    {
        // dd($taskIndex);
        unset($this->tasks[$taskIndex]);
        $this->refreshTaskHrs();
        
    }

    public function selectAccount(Account $account)
    {
        $this->account = $account;
        $this->openAccounts = false;
        $this->openTasks = true;
        // dd($this->account);
    }

    public function cancelReport()
    {

        $this->reset(['crew', 'startDate', 'startTime', 'endTime', 'endDate', 'total', 'account', 'tasks', 'observation']);

        $this->openObs = false;
    }

    public function store()
    {

        $this->validate([
            'observation' => 'required',

        ]);

        $thisReport = DailyReport::create([
            'work_start_date' => $this->startDate,
            'work_start_time' => $this->startTime,
            'work_end_time' => $this->endTime,
            'work_end_date' => $this->endDate,
            'total' => $this->total,
            'observation' => $this->observation,

        ]);

        $thisReport->user()->associate(Auth::user());
        $thisReport->crew()->associate($this->crew);
        $thisReport->account()->associate($this->account);
        $thisReport->save();

        foreach ($this->tasks as $taskIn) {
            $task = Task::create([
                'description' => $taskIn['description'],
                'time' => $taskIn['time']
            ]);

            $task->dailyReport()->associate($thisReport);
            $task->save();
        }

        // $newBalance = $this->account->balance + $this->total;
        // $account = Account::find($this->account->id);
        // $account->balance = $newBalance;
        // $account->save();

        $thisReport->concepts()->sync(
            [
                1 => ['amount' => $this->normalHours ? $this->normalHours : 0, 'sub_total' => $this->normalHoursPrice ? $this->normalHoursPrice : 0],
                2 => ['amount' => $this->fiftHours ? $this->fiftHours / 1.5 : 0, 'sub_total' => $this->fiftHoursPrice ? $this->fiftHoursPrice : 0],
                3 => ['amount' => $this->hundHours ? $this->hundHours / 2 : 0, 'sub_total' => $this->hundHoursPrice ? $this->hundHoursPrice : 0],
                4 => ['amount' => $this->foodQuan ? $this->foodQuan : 0, 'sub_total' => $this->food ? $this->food : 0]
            ]
        );

        $thisReport->save();

        $this->reset(['crew', 'startDate', 'startTime', 'endTime', 'endDate', 'total', 'account', 'tasks', 'observation']);

        $this->dispatchBrowserEvent('createdReport', ['message' => 'El Parte se cargó correctamente']);


        $this->emit('downloadPdf', $thisReport->id);

        $this->openObs = false;
    }
}
