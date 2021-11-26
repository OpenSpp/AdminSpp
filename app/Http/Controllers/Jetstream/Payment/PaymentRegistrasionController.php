<?php

namespace App\Http\Controllers\Jetstream\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Payment\PaymentRegistrasionRequest;
use App\Models\Payment;
use Inertia\Inertia;

class PaymentRegistrasionController extends Controller
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
        return Inertia::render('Payment/Daftar/Index', [
            'payments' => Payment::with(['user', 'user.student', 'user.student.room'])
                ->applyFilters($request->only($queries))
                ->whereTypeIn(['daftar-ulang'])
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
        return Inertia::render('Payment/Daftar/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PaymentRegistrasionRequest $request)
    {
        Payment::createPayment($request);

        return redirect()->route('registrations.index')->with('success', 'Success');
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
    public function edit(Payment $registration)
    {
        $registration->load([
            'user',
            'user.student',
            'user.student.room'
        ]);
        return Inertia::render('Payment/Daftar/Edit', [
            'payment' => $registration
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PaymentRegistrasionRequest $request, Payment $registration)
    {
        $registration->updatePayment($request);
        return redirect()->route('registrations.index')->with('success', 'Success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $registration)
    {
        if($registration->delete()) {
            return redirect()->route('registrations.index')->with('success', 'Success Delete');
        }
    }
}
