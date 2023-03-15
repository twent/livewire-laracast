<x-mail::message>
# {{ __('New contact form received') }}

    {{ __('Name:') }} {{ $formData['name'] }}

    {{ __('Email:') }} {{ $formData['email'] }}

    {{ __('Message:') }} {{ $formData['message'] }}
</x-mail::message>
