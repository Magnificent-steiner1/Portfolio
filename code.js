
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

