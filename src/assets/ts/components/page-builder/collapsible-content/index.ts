function toggleCollapse(id: string) {
    const content = document.getElementById(`collapse-${id}`);

    if (content.style.maxHeight && content.style.maxHeight !== '0px') {
        content.style.maxHeight = '0';
    } else {
        content.style.maxHeight = content.scrollHeight + 'px';
    }
}

document.querySelectorAll('[data-block="collapsible-content"]').forEach(block => {
    block.querySelectorAll('.collapse__item--js').forEach(item => {
        const toggle = item.querySelector('.collapse__toggle--js')

        toggle.addEventListener('click', () => {
            toggleCollapse(item.id)
        })
    })
})
