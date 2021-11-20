import Swal from 'sweetalert2'
window.Swal = Swal;

const Toast = Swal.mixin({
    toast: false,
    position: 'top-start',
    showConfirmButton: false,
    timer: 1500,
    timerProgressBar: true,
    // width: 600,
    // padding: '3em',
    // background: '#eee url(/img/logo.png)',
    // backdrop: `rgba(0,0,123,0.4)url("/images/bg/1.jpeg")left topno-repeat`,
    // didOpen: (toast) => {
    //     toast.addEventListener('mouseenter', Swal.stopTimer)
    //     toast.addEventListener('mouseleave', Swal.resumeTimer)
    // }
})
window.Toast = Toast
