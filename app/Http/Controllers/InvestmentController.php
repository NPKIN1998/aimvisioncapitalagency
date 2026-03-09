<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvestmentRequest;
use App\Models\Package;
use App\Models\User;
use App\Services\InvestmentService;
use App\Services\ReferralService;
use Exception;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class InvestmentController extends Controller
{
    private $investmentService;
    private $referralService;
    public function __construct(
        InvestmentService $investmentService,
        ReferralService $referralService
    ) {
        $this->investmentService = $investmentService;
        $this->referralService = $referralService;
    }
    public function index(): View
    {
        $packages = Package::all();

        return view('user.investment', compact('packages'));
    }

    public function store(StoreInvestmentRequest $request)
    {

        /** @var User $user */
        $user = Auth::user();

        if (!$user) {
            return Redirect::back()->with('error', 'You must be logged in to perform this action.');
        }

        try {
            $validated = $request->validated();
            $plan = Package::findOrFail($validated['plan_id']);

            $capital = $plan->initial_capital;

            $this->investmentService->createInvestment($user, $plan->id);
            $this->referralService->processUplineBonus($user, $capital);

            $message = sprintf(
                'Your Plan of Kes %s in the "%s" plan was successful. ' .
                    'Your new balance is Kes %s. ' .
                    'You can expect daily returns of %s%% over %s days.',
                number_format($capital, 2),
                $plan->name,
                number_format($user->balance, 2),
                $plan->daily_income_percentage,
                $plan->days
            );
            return Redirect::back()->with([
                'toast' => [
                    'type' => 'success',
                    'title' => 'Application Successful',
                    'message' => $message,
                ],
            ]);
        } catch (Exception $e) {
            $messageError = $e->getMessage();
            return Redirect::back()->with([
                'toast' => [
                    'type' => 'error',
                    'title' => 'Message Error',
                    'message' => $messageError,
                ]
            ]);
        }
    }
}
