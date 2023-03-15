<?php

namespace App\Http\Livewire;

use App\Mail\ContactFormMail;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class ContactForm extends Component
{
    public string $name = '';
    public string $email = '';
    public string $message = '';
    public ?string $successMessage = null;

    protected array $rules = [
        'name' => 'required|string|min:5',
        'email' => 'required|email',
        'message' => 'required|string|min:6',
    ];

    /**
     * @throws ValidationException
     */
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render(): View
    {
        return view('livewire.contact-form');
    }

    public function send(): void
    {
        $formData = $this->validate();

        sleep(1);

        Mail::send(new ContactFormMail($formData));

        $this->successMessage = __('Your message has been sent!');

        $this->resetExcept('successMessage');
    }
}
