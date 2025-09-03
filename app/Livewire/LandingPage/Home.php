<?php

declare(strict_types=1);

namespace App\Livewire\LandingPage;

use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Title('Beranda')]
#[Layout('components.layouts.landing-page')]
class Home extends Component
{
    public function render()
    {
        return view('livewire.landing-page.home');
    }
}
