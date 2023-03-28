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

/*

Morph DOM updating

 */
function morph(from, to) {
    if (typeof to === 'string') {
        let temp = document.createElement('div')
        temp.innerHTML = to
        to = temp.firstElementChild
    }

    if (from.tagName !== to.tagName) {
        from.replaceWith(to.cloneNode(true))
        return
    }

    patchText(from, to)

    patchAttributes(from, to)

    patchChildren(from, to)
}

function patchChildren(from, to) {
    let childFrom = from.firstElementChild
    let childTo = to.firstElementChild

    while (childTo) {
        if (! childFrom) {
            childFrom = from.appendChild(childTo.cloneNode(true))
        } else {
            morph(childFrom, childTo)
        }

        childFrom = childFrom.nextElementSibling
        childTo = childTo.nextElementSibling
    }

    while (childFrom) {
        let removingChildFrom = childFrom
        childFrom = childFrom.nextElementSibling
        removingChildFrom.remove()
    }
}

function patchText(from, to) {
    if (to.children.length > 0) return

    from.textContent = to.textContent
}

function patchAttributes(from, to) {
    for (let { name, value } of to.attributes) {
        from.setAttribute(name, value)
    }

    for (let { name, value } of from.attributes) {
        if (to.hasAttribute(name, value)) {
            continue;
        }

        from.removeAttribute(name)
    }
}
