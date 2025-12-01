<?php

namespace App\Http\Controllers;

use App\Models\Earning;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    /**
     * Muestra los planes
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function index()
    {
        $plans = Subscription::all();
        return view('subscriptions.index', compact('plans'));
    }

    /**
     * Registra una nueva suscripción y el pago
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:subscriptions,id',
        ]);

        $user = Auth::user();

        $plan = Subscription::findOrFail($request->plan_id);

        Earning::create([
            'amount' => $plan->cost,
            'state'  => 'pagado',
            'at'     => now(),
        ]);

        $user->is_suscribed = true;
        $user->save();

        return redirect()->route('dashboard.user')->with('success', '¡Bienvenido a Melodic Premium!');
    }
}
