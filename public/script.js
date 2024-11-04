document.querySelector('form').addEventListener('submit', function(event) {
    const username = document.querySelector('input[name="username"]').value;
    const password = document.querySelector('input[name="password"]').value;

    if (username === '' || password === '') {
        alert('Mohon isi semua kolom!');
        event.preventDefault();
    }
});

document.querySelectorAll('.menu-link').forEach(item => {
    item.addEventListener('click', () => {
        alert('Menu ini akan diarahkan ke halaman terkait.');
    });
});
