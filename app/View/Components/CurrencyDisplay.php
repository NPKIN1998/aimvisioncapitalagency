<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CurrencyDisplay extends Component
{
    public float $amount;

    /**
     * Create a new component instance.
     */
    public function __construct(float $amount)
    {
        $this->amount = $amount;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.currency-display', [
            'amount' => $this->amount
        ]);
    }
}
