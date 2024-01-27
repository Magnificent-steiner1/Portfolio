
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
  