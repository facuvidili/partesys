<?php 
namespace App\Models;
use App\Models\Crew;
use App\Models\DailyReport;
use App\Http\Controllers\Home\PurchaseOrderController;
use Illuminate\Support\Facades\DB;
class Consolidation {
    private $purchaseOrders = [];

    public function purchaseOrders(Crew $crew,$monthYear){
        $month = substr($monthYear,0,2);
        $year = substr($monthYear,3,6);
        $dailyReports = DailyReport::where('crew_id', $crew->id)->where(DB::raw('MONTH(work_start_date)'), $month)->where(DB::raw('YEAR(work_start_date)'), $year)->get();
        // return $dailyReports;
        // return $dailyReports[0]->concepts;

        

        foreach ($dailyReports as $dailyReport) {

            $purchaseOrder = new PurchaseOrder($dailyReport->account->company->id);
            $account = new Account($dailyReport->account->id);
            // $idCompany = $dailyReport->account->company->id;
            // $idAccount = $dailyReport->account->id;
            foreach ($dailyReport->concepts as $concept) {
                // $totalNormalHour = 0;
                // $totalFiftyHour = 0;
                // $totalHundredHour = 0;
                // $totalFood = 0;
                if ($concept->id == 1) {
                    // $totalNormalHour = $concept->pivot->amount * $concept->pivot->sub_total;
                    $totalNormalHour = $concept->pivot->sub_total;
                } elseif ($concept->id == 2) {

                    // $totalFiftyHour = $concept->pivot->amount * $concept->pivot->sub_total;
                    $totalFiftyHour = $concept->pivot->sub_total;
                } elseif ($concept->id == 3) {

                    // $totalHundredHour = $concept->pivot->amount * $concept->pivot->sub_total;
                    $totalHundredHour = $concept->pivot->sub_total;
                } elseif ($concept->id == 4) {

                    // $totalFood = $concept->pivot->amount * $concept->pivot->sub_total;
                    $totalFood = $concept->pivot->sub_total;
                }



                if (!array_key_exists($purchaseOrder->getCompany_id(), $this->purchaseOrders)) {
                    

                    $purchaseOrders['companies'][$idCompany] = [
                        'accounts' => []
                    ];

                    $purchaseOrders['companies'][$idCompany]['accounts'][$idAccount] = [
                        'totalNormalHour' => $totalNormalHour,
                        'totalFiftyHour' => $totalFiftyHour,
                        'totalHundredHour' => $totalHundredHour,
                        'totalFood' => $totalFood,
                    ];
                } elseif (array_key_exists($idAccount, $purchaseOrders['companies'][$idCompany]['accounts'])) {

                    $purchaseOrders['companies'][$idCompany]['accounts'][$idAccount]['totalNormalHour'] += $totalNormalHour;
                    $purchaseOrders['companies'][$idCompany]['accounts'][$idAccount]['totalFiftyHour'] += $totalFiftyHour;
                    $purchaseOrders['companies'][$idCompany]['accounts'][$idAccount]['totalHundredHour'] += $totalHundredHour;
                    $purchaseOrders['companies'][$idCompany]['accounts'][$idAccount]['totalFood'] += $totalFood;
                } elseif (!array_key_exists($idAccount, $purchaseOrders['companies'][$idCompany]['accounts'])) {

                    $purchaseOrders['companies'][$idCompany]['accounts'][$idAccount] = [
                        'totalNormalHour' => $totalNormalHour,
                        'totalFiftyHour' => $totalFiftyHour,
                        'totalHundredHour' => $totalHundredHour,
                        'totalFood' => $totalFood,
                    ];
                }
                /* foreach (array_keys($accounts) as $idAccount) {
                
            } */
            }
        }
        return $purchaseOrders;
    }

	/**
	 * @return mixed
	 */
	public function getPurchaseOrders() {
		return $this->purchaseOrders;
	}
	
	/**
	 * @param mixed $purchaseOrders 
	 * @return self
	 */
	public function setPurchaseOrders($purchaseOrders): self {
		$this->purchaseOrders = $purchaseOrders;
		return $this;
	}
}
