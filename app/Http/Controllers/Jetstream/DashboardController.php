<?php

namespace App\Http\Controllers\Jetstream;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Retrieve details of an expense receipt from storage.
     *
     * @param   \Crater\Models\Expense $expense
     * @return  \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        $payments = Payment::groupBy('type')
            ->whereYear('created_at', date('Y'))
            ->selectRaw('type, sum(amount) as amount')
            ->get();

        $payment = [];
        foreach($payments as $value) {
            $payment[str_replace("-","_",$value->type)] = $value->amountRupiah;
        }

        return Inertia::render('Dashboard', [
            'payment' => $payment,
            'yearFilter'  => date('Y')
        ]);
    }
}
