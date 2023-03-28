// find all elements with wire:snapshot
// go through each, pull out the string of data
// turn that string into an actual JS object
document.querySelectorAll('[wire\\:snapshot]').forEach(el => {
    el.__livewire = JSON.parse(el.getAttribute('wire:snapshot'))

    initWireClick(el)
})

function initWireClick(el) {
    el.addEventListener('click', e => {
        if (! e.target.hasAttribute('wire:click')) return

        let method = e.target.getAttribute('wire:click')

        sendRequest(el, { method })
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
        })
}
