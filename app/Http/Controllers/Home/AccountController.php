<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Company;
use App\Models\Consolidation;
use App\Models\Contract;
use App\Models\Contractor;
use App\Models\DailyReport;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home.accounts.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = Company::pluck('name', 'id');
        $contractors = Contractor::all();

        return view('home.accounts.create', compact('companies', 'contractors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $balanceRule = 'required|numeric|between:';
        // if ($request->is_deficitary) {
        //     $balanceRule .= '0,99999999999999.99';
        // } else {
        //     $balanceRule .= '-99999999999999.9,99999999999999.9';
        // 
        $request->validate([
            'name' => [
                Rule::unique('accounts')
                    ->where('company_id', $request->company_id)
                    ->where('name', $request->name)
            ],
            'budget' => 'required|numeric|between:0 , 100000000000.00',

        ]);

        $account = Account::create([
            'name' => $request->name,
            'is_deficitary' => $request->is_deficitary,
            'budget' => $request->budget,
            'balance' => $request->budget,
            'company_id' => $request->company_id,
        ]);

        if ($request->contractors) {
            $account->contractors()->attach($request->contractors);
        }

        return redirect()->route('home.accounts.index')->with('info', 'La cuenta se agregó correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Account $account)
    {
        return view('home.accounts.show', compact('account'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Account $account)
    {
        // $contractors = Contractor::pluck('name', 'id'); 

        //return view('home.accounts.edit', compact('account', 'companies', 'contractors', 'total'));
        return view('home.accounts.edit', compact('account'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Account $account)
    {
        $diff = $request->budget - $account->budget;

        $request->balance += $diff;
        $reserved = $account->totalReserved();
        
        $balanceRule = 'required|numeric|between:';
        if ($request->is_deficitary) {
            $balanceRule .= '100,99999999999999.9';
            
        } else {
            $balanceRule .= $account->budget - ($account->balance - $reserved) .',99999999999999.99';
            /*
            if ($diff < 0 && (-1 * $diff) > $account->balance) {

            } else {
                $balanceRule .= $account->totalReserved().',99999999999999.99';
            }
            */
        }

        // dd($request);

        $request->validate([
            'name' => [
                'required',
                Rule::unique('accounts')
                    ->where('company_id', $request->company_id)
                    ->where('name', $request->name)
                    ->ignore($account->id,)

            ],
            'budget' => $balanceRule,
            /*'balance' => $balanceRule,*/
        ]);
       // $msg = 'La cuenta ';

        /*
        if (!$request->is_deficitary) {

            if ($account->totalReserved() < $request->balance) {

                $account->update([
                    'name' => $request->name,
                    'is_deficitary' => $request->is_deficitary,
                    'budget' => $request->budget,
                    'balance' => $request->balance,
                ]);
                $msg .= 'se actualizó correctamente.';
            } else {

                $msg .= 'no se pudo actualizar porque posee reservas superiores al nuevo saldo.';
            }
        } else {
            $account->update([
                'name' => $request->name,
                'is_deficitary' => $request->is_deficitary,
                'budget' => $request->budget,
                'balance' => $request->balance,
            ]);
            $msg .= 'se actualizó correctamente.';
        }
        */

        $account->update([
            'name' => $request->name,
            'is_deficitary' => $request->is_deficitary,
            'budget' => $request->budget,
            'balance' => $request->balance,
        ]);

      
        $account->contractors()->detach();
        if ($request->contractors) {
            $account->contractors()->sync($request->contractors);
        }

        return redirect()->route('home.accounts.index')->with('info', 'La cuenta se actualizó correctamente.');
    }

    public function destroy(Account $account)
    {
        $account->delete();

        return redirect()->route('home.accounts.index')
            ->with('info', 'La cuenta se eliminó correctamente');
    }
}
