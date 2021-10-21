function openLoginForm(){
  document.getElementById("omonoia").classList.add("omonoia");
  document.getElementById("blurring").classList.remove("blurring");

}
function myFunction(ev){
  document.getElementById("omonoia").classList.remove("omonoia");
  document.getElementById("blurring").classList.add("blurring");
  ev.preventDefault();// will stop the form submission

}
const togglePassword = document.querySelector('#togglePassword');
const password = document.querySelector('#password');
togglePassword.addEventListener('click', function (e) {
// toggle the type attribute
const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
password.setAttribute('type', type);
// toggle the eye slash icon
this.classList.toggle('fa-eye-slash');
});
