document.addEventListener('DOMContentLoaded', () => {
    // tooltip
    $('[data-toggle="tooltip"]').tooltip({
        trigger: 'hover focus active',
        html: true,
    })

    // toggle password
    let btnsShowPassword = document.querySelectorAll('.btn-show-password span')
    btnsShowPassword.forEach(btn => {
        let input = btn.parentNode.parentNode.parentNode.querySelector('input')
        btn.addEventListener('click', e => {
            e.preventDefault()
            e.target.classList.toggle('fa-eye-slash')
            e.target.classList.toggle('fa-eye')
            input.type = input.type == 'password' ? 'text' : 'password'
            e.target.title = e.target.title == 'tampilkan' ? 'sembunyikan' : 'tampilkan'
        })
    })

    // modal delete
    // $('.modal-delete').on('shown.bs.modal', function (event) {
    //     $('.modal-delete .form-input input').focus();
    // })
})