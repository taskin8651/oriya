document.querySelectorAll('[data-password-toggle]').forEach(button => {
    const field = document.getElementById(button.getAttribute('aria-controls'));

    function updateLabel() {
        const action = field.type === 'password' ? button.dataset.show : button.dataset.hide;
        button.textContent = action;
        button.setAttribute('aria-label', `${action} ${button.dataset.fieldLabel}`);
    }

    button.addEventListener('click', () => {
        field.type = field.type === 'password' ? 'text' : 'password';
        updateLabel();
    });

    updateLabel();
    button.hidden = false;
});
