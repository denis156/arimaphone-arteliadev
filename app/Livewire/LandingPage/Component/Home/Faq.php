<?php

declare(strict_types=1);

namespace App\Livewire\LandingPage\Component\Home;

use Livewire\Component;

class Faq extends Component
{
    public $faqGroup = null;

    public function render()
    {
        return view('livewire.landing-page.component.home.faq');
    }
}
