<?php

namespace Tests\Feature;

use App\Http\Livewire\ContactForm;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Mail::fake();
    }

    /**
     * A basic feature test example.
     */
    public function testContactPageIsAvailable(): void
    {
        $response = $this->get(route('contact'));

        $response->assertStatus(200);
    }

    public function testLivewireComponentIsUsed(): void
    {
        $this
            ->get(route('contact'))
            ->assertSeeLivewire(ContactForm::class);
    }

    public function testContactFormSuccesfullyIsSended(): void
    {
        $componentState = Livewire::test(ContactForm::class, [
            'name' => 'First Name',
            'email' => 'test@test.ru',
            'message' => 'Message',
        ]);

        $componentState->call('send');

        Mail::assertSent(function (ContactFormMail $mail) {
            return $mail->assertHasSubject('New contact form received') &&
                $mail->assertSeeInText('First Name') &&
                $mail->assertSeeInText('test@test.ru') &&
                $mail->assertSeeInText('Message');
        });

        $componentState->assertHasNoErrors();

        $componentState->assertSee('Your message has been sent!');
    }

    public function testNameFieldValidationWorks(): void
    {
        // Name is required
        $componentState = Livewire::test(ContactForm::class, [
            'email' => 'test@test.ru',
            'message' => 'Message',
        ]);

        $componentState->call('send');

        $componentState->assertHasErrors('name');

        // Name is too short
        $componentState = $componentState->set('name', 'Test');

        $componentState->call('send');

        $componentState->assertHasErrors('name');
    }

    public function testEmailFieldValidationWorks(): void
    {
        // Email is required
        $componentState = Livewire::test(ContactForm::class, [
            'name' => 'First Name',
            'message' => 'Message',
        ]);

        $componentState->call('send');

        $componentState->assertHasErrors('email');

        // Email is not valid
        $componentState = $componentState->set('email', 'test.ru');

        $componentState->call('send');

        $componentState->assertHasErrors('email');
    }

    public function testMessageFieldValidationWorks(): void
    {
        // Message is required
        $componentState = Livewire::test(ContactForm::class, [
            'name' => 'First Name',
            'email' => 'test@test.ru',
        ]);

        $componentState->call('send');

        $componentState->assertHasErrors('message');

        // Message is too short
        $componentState = $componentState->set('message', 'Test');

        $componentState->call('send');

        $componentState->assertHasErrors('message');
    }
}
