// find all elements with wire:snapshot
// go through each, pull out the string of data
// turn that string into an actual JS object
document.querySelectorAll('[wire\\:snapshot]').forEach(el => {
    el.__livewire = JSON.parse(el.getAttribute('wire:snapshot'))

    initWireClick(el)
    initWireModel(el)
})

function initWireClick(el) {
    el.addEventListener('click', e => {
        if (! e.target.hasAttribute('wire:click')) return

        let method = e.target.getAttribute('wire:click')

        sendRequest(el, { method })
    })
}

function initWireModel(el) {
    el.addEventListener('input', e => {
        if (! e.target.hasAttribute('wire:model')) return

        let property = e.target.getAttribute('wire:model')
        let value = e.target.value

        sendRequest(el, { updateProperty: [property, value] })
    })
}

function updateWireModelInputs(el) {
    let data = el.__livewire.data

    el.querySelectorAll('[wire\\:model]').forEach(wireModelEl => {
        let property = wireModelEl.getAttribute('wire:model')

        wireModelEl.value = data[property]
    })
}

function sendRequest(el, payloadAppend) {
    let snapshot = el.__livewire

    fetch('/livewire', {
        method: 'POST',
        headers: { 'Content-Type' : 'application/json' },
        body: JSON.stringify({
            _token: '{{ csrf_token() }}',
            snapshot,
            ...payloadAppend,
        })
    })
        .then(i => i.json())
        .then(response => {
            let { html, snapshot } = response

            el.__livewire = snapshot

            Alpine.morph(el.firstElementChild, html)

            updateWireModelInputs(el)
        })
}
