<?php

namespace App\Http\Controllers\Jetstream\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Payment\PaymentSppRequest;
use App\Models\Payment;
use Inertia\Inertia;

class PaymentSppController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = (int) $request->get('per_page') > 0 ? (int) $request->get('per_page') : 15;
        $page = (int) $request->get('page') > 0 ? (int) $request->get('page') : 1;
        $queries = ['search', 'page'];
        return Inertia::render('Payment/Spp/Index', [
            'payments' => Payment::with(['user', 'user.student', 'user.student.room'])
                ->applyFilters($request->only($queries))
                ->whereTypeIn(['spp'])
                ->paginateData($limit),
            'filtersPayments' => $request->all($queries),
            'start' => $limit * ($page - 1),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Payment/Spp/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PaymentSppRequest $request)
    {
        Payment::createPayment($request);

        return redirect()->route('spps.index')->with('success', 'Success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $spp)
    {
        $spp->load([
            'user',
            'user.student',
            'user.student.room'
        ]);
        return Inertia::render('Payment/Spp/Edit', [
            'payment' => $spp
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PaymentSppRequest $request, Payment $spp)
    {
        $spp->updatePayment($request);
        return redirect()->route('spps.index')->with('success', 'Success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $spp)
    {
        if($spp->delete()) {
            return redirect()->route('spps.index')->with('success', 'Success Delete');
        }
    }
}
