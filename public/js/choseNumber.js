document.querySelectorAll('.number-label').forEach(label => {
    label.addEventListener('click', () => {
        const number = label.getAttribute('data-number');
        const input = document.querySelector(`#number-${number}`);

        

        if (!input.checked) {
            label.classList.add('bg-green-500', 'text-white');
            label.classList.remove('bg-blue-100', 'text-blue-500');
        } else {
            label.classList.remove('bg-green-500', 'text-white');
            label.classList.add('bg-blue-100', 'text-blue-500');
        }
    });
});
