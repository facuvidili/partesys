<?php

namespace App\Http\Livewire\Home;

use App\Models\DailyReport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DailyReportsEvent extends Component
{
    public $dailyReportShow;
    public $openEvent;

    protected $listeners = [
        'showEvent', 'downloadPdf'
    ];

    public function render()
    {
        return view('livewire.home.daily-reports-event');
    }

    public function showEvent($eventId)
    {
        //ENCUENTRA EL REPORTE POR ID PARA MOSTRAR
        $this->dailyReportShow = DailyReport::find($eventId);

        $this->openEvent = true;
    }

    public function downloadPdf($id)
    {
        $dailyReportShow = DailyReport::find($id);
        $pdfContent = PDF::loadView('livewire.home.daily-reports-eventPDF', 
        ['dailyReportShow' => $dailyReportShow, 'company'=>Auth::user()->company, 
        'supervisor'=>Auth::user()])->output();
        return response()->streamDownload(
            fn () => print($pdfContent),
            "Parte_N°_" . $dailyReportShow->id . "_Cuadrilla_N°_" . $dailyReportShow->crew_id . "_Fecha_" . $dailyReportShow->work_start_date . ".pdf"
        );
    }
}
