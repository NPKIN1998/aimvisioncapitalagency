<?php

namespace App\Http\Controllers;

use App\Exceptions\ConcurrentModificationException;
use App\Exceptions\ConflictException;
use App\Exceptions\InsufficientBalanceException;
use App\Exceptions\TransactionFailedException;
use App\Http\Requests\StoreRentRequest;
use App\Models\Property;
use App\Services\ReferralService;
use App\Services\RentPropertyService;
use Exception;
use Illuminate\Support\Facades\Log;

class RentController extends Controller
{
    private $rentService;

    private $referralService;

    public function __construct(
        RentPropertyService $rentService,
        ReferralService $referralService
    ) {
        $this->rentService = $rentService;
        $this->referralService = $referralService;
    }

    public function index()
    {
        $properties = Property::all();

        return view('user.investmentmodel.rent', compact('properties'));
    }

    public function store(StoreRentRequest $request)
    {
        $user = $request->user();

        // dd($request);

        if (! $user) {
            return redirect()->back()->with('toast', [
                'type' => 'error',
                'title' => 'Unauthorized',
                'message' => 'You must be logged in to perform this action.',
            ]);
        }

        try {
            $validated = $request->validated();
            $property = Property::findOrFail($validated['property_id']);
            $capital = $property->capital;

            $this->rentService->purchaseRental($user, $validated['property_id']);
            $this->referralService->processUplineBonus($user, $capital);

            return redirect()->route('release')->with('toast', [
                'type' => 'success',
                'title' => 'Rental Successful',
                'message' => "You have successfully rented '{$property->name}' for KES {$capital}. Enjoy your investment!",
            ]);
        } catch (InsufficientBalanceException $e) {
            Log::error('Your account balance is too low to rent this property. Please top up and try again.');

            return redirect()->back()->withInput()->with('toast', [
                'type' => 'error',
                'title' => 'Insufficient Balance',
                'message' => 'Your account balance is too low to rent this property. Please top up and try again.',
            ]);
        } catch (ConflictException $e) {
            Log::error('This property is currently being rented by another user. Please choose a different property.');

            return redirect()->back()->withInput()->with('toast', [
                'type' => 'error',
                'title' => 'Conflict Detected',
                'message' => 'This property is currently being rented by another user. Please choose a different property.',
            ]);
        } catch (ConcurrentModificationException $e) {
            Log::error('The property data was modified by another process. Please refresh and try again.');

            return redirect()->back()->withInput()->with('toast', [
                'type' => 'error',
                'title' => 'Concurrent Modification',
                'message' => 'The property data was modified by another process. Please refresh and try again.',
            ]);
        } catch (TransactionFailedException $e) {
            return redirect()->back()->withInput()->with('toast', [
                'type' => 'error',
                'title' => 'Transaction Failed',
                'message' => 'The payment process failed. Please check your account and try again.',
            ]);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('toast', [
                'type' => 'error',
                'title' => 'Unexpected Error',
                'message' => 'An unexpected error occurred. Please try again later.',
            ]);
        }
    }
}
