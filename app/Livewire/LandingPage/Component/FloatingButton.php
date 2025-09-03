<?php

declare(strict_types=1);

namespace App\Livewire\LandingPage\Component;

use App\Class\HelperWhatsApp;
use Livewire\Component;

class FloatingButton extends Component
{
    public function openWhatsApp()
    {
        $message = HelperWhatsApp::generateConsultationMessage();
        $url = HelperWhatsApp::generateCustomWhatsAppUrl($message);
        $this->js("window.open('$url', '_blank')");
    }

    public function render()
    {
        return view('livewire.landing-page.component.floating-button');
    }
}
