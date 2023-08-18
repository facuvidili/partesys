<?php

namespace App\Http\Livewire\Home;

use App\Models\Crew;
use App\Models\DailyReport;
use Carbon\Carbon;
use Code16\CarbonBusiness\BusinessDays;
use Livewire\Component;
use Livewire\WithPagination;

class ConsolidationsUnresolvedIndex extends Component

{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search;
    public $sort = 'id';
    public $direction = 'desc';
    public $monthYear;
    public $crewId;

    protected $listeners = ['continue'];

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function render()
    {
        $unresolved_consolidations = DailyReport::selectRaw('crew_id, date_format(work_start_date,"%m-%Y") as monthYear,sum(total) as total')
            ->where('crew_id', 'LIKE', '%' . $this->search . '%')->whereNull('consolidation_id')
            ->orWhereHas('crew',function($q){$q->whereHas('contractor',function($q){$q->where('name','LIKE','%'. $this->search.'%');});})->whereNull('consolidation_id')
            ->groupBy('crew_id', 'monthYear')
            ->orderBy($this->sort, $this->direction)->paginate(10);
        return view('livewire.home.consolidations-unresolved-index', compact('unresolved_consolidations'));
    }

    public function order($sort)
    {
        if ($this->sort == $sort) {

        if ($this->direction == 'asc') {
            $this->direction = 'desc';
        } else {
            $this->direction = 'asc';
        }
    }else{
            $this->sort = $sort;
            $this->direction = 'desc';
        }
    }

    public function alertContract($crewId, $monthYear)
    {
        $this->crewId = $crewId;
        $this->monthYear = $monthYear;
        $crew = Crew::find($crewId);

        if (!$crew->hour_price) {


            $month = substr($monthYear, 0, 2);
            $year = substr($monthYear, 3, 6);

            $date = new BusinessDays();
            $days = $date->daysBetween(
                Carbon::createFromDate($year, $month, 1), // This is a Monday
                Carbon::createFromDate($year, $month, Carbon::createFromDate($year . '-' . $month . '-01')->daysInMonth)
            );

            if (count($crew->dailyReportsIds()) >= $days) {

                $this->continue();
            } else {

                $this->dispatchBrowserEvent('alertContract');
            }
        } else {
            $this->continue();
        }
    }
    

    public function continue()
    {
        return redirect()->route('consolidations.new', ['crewId' => $this->crewId, 'monthYear' => $this->monthYear]);
    }
}
