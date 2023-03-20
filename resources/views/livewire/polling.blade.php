<div class="overflow-x-auto w-full space-y-8">
    <h1 class="text-3xl font-bold">{{ __('Polling test') }}</h1>

    <div wire:poll.3s.visible="getRevenue">
        Orders Revenue:
        <span class="font-bold">{{ number_format($revenue, 2, '.', ' ') }} ₽</span>
    </div>
</div>
