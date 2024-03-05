
// document.addEventListener('DOMContentLoaded', function () {
//     const menuButton = document.querySelector('.menu-button');
//     const sideNav = document.querySelector('.sidebar');
  
//     menuButton.addEventListener('click', function () {
//       sideNav.style.display = sideNav.style.display === 'none' ? 'flex' : 'none';
//     });
//   });
  
document.addEventListener('DOMContentLoaded', function () {
  const menuButton = document.querySelector('.menu-button');
  const sideNav = document.querySelector('.sidebar');

  menuButton.addEventListener('click', function () {
    sideNav.style.display = sideNav.style.display === 'none' || sideNav.style.display === '' ? 'flex' : 'none';
  });
});

document.addEventListener('DOMContentLoaded', function () {
  const navLinks = document.querySelectorAll('.nav-link');
  const navbarHeight = document.querySelector('.header').offsetHeight; // Adjust this selector to match your navbar

  navLinks.forEach(link => {
      link.addEventListener('click', function (event) {
          event.preventDefault();
          const targetId = this.getAttribute('href').substring(1);
          const targetSection = document.getElementById(targetId);
          const targetOffset = targetSection.getBoundingClientRect().top + window.scrollY - navbarHeight;
          window.scrollTo({ top: targetOffset, behavior: 'smooth' });
      });
  });
});




document.addEventListener('DOMContentLoaded', function () {
  const filterButtons = document.querySelectorAll('.photo-filter-btn');
  const photos = document.querySelectorAll('.photo');
  filterButtons.forEach(button => {
      button.addEventListener('click', function () {
          filterButtons.forEach(btn => {
              btn.classList.remove('active');
          });
          this.classList.add('active');

          const filter = this.getAttribute('photo-filter');
          
          photos.forEach(photo => {
              if (filter === 'all' || photo.classList.contains(filter)) {
                  photo.style.display = 'block';
              } else {
                  photo.style.display = 'none';
              }
          });
      });
  });
});



document.getElementById("send-button").addEventListener("click",function(){

var name= document.getElementById("name").value;
var email= document.getElementById("email").value;
var message= document.getElementById("message").value;

fetch("index.php",{
  method: "POST",
  headers:{
    "Content-Type": "application/x-www-form-urlencoded"
  },
  body: "name=" + encodeURIComponent(name)+ "&email="+ encodeURIComponent(email) + "&message=" + encodeURIComponent(message)
})
.then(response=>{
  if(!response.ok){
    throw new Error("Network response was not ok");
  }
  return response.text();
})
.then(data=>{
  console.log(data);
  alert("Message sent successfully!");
  
  document.getElementById("name").value = "";
  document.getElementById("email").value = "";
  document.getElementById("message").value = "";
})
.catch(error=>{
  console.error("There was a problem with the fetch operation",error);
});

});

