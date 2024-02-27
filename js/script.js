let menu = document.querySelector('#menu-btn');
let navbar = document.querySelector('.header .navbar');

menu.onclick = () =>{
   menu.classList.toggle('fa-times');//from (fa-bars)  to (fa-times)
   navbar.classList.toggle('active');
};

window.onscroll = () =>{
   menu.classList.remove('fa-times');
   navbar.classList.remove('active');
};
// /*************************** */
// document.querySelector('#close-edit').onclick = () =>{
//    document.querySelector('.edit-form-container').style.display = 'none';
//    window.location.href = 'admin.php';
// };
let closeX = document.querySelector('#close-edit');//btn of reset update that cancel it 
let updateform = document.querySelector('.edit-form-container');//the form that update
closeX.onclick = () =>{
   updateform.style.display = 'none';
   window.location.href = 'admin.php'; //go back to admin page looks like the header in php
};

<script>
  window.onload = function() {
    var audio = document.getElementById('sound1');
    audio.play();
  };
</script>