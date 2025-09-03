<?php

declare(strict_types=1);

namespace App\Livewire\LandingPage\Component\Home;

use Livewire\Component;

class Customer extends Component
{
    public $rating1 = 4;
    public $rating2 = 3;
    public $rating3 = 5;

    public function render()
    {
        return view('livewire.landing-page.component.home.customer');
    }
}
