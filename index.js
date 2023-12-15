const isLoggedIn =  sessionStorage.getItem('isLoggedIn') === 'true';
console.log(isLoggedIn)
const isAdmin =  sessionStorage.getItem('role') == '1';
console.log("isAdmin:: ", isAdmin);
const loginLink = document.getElementById('loginLink');
const signupLink = document.getElementById('signupLink');
const profileLink = document.getElementById('profileLink');
const logoutLink = document.getElementById('logoutLink');
const adminLink = document.getElementById('adminLink');


if (isAdmin){
  adminLink.style.display = 'block';
}
if (isLoggedIn) {
  loginLink.style.display = 'none';
  signupLink.style.display = 'none';
  profileLink.style.display = 'block';
  logoutLink.style.display = 'block';
} else {
  loginLink.style.display = 'block';
  signupLink.style.display = 'block';
  profileLink.style.display = 'none';
  logoutLink.style.display = 'none';
}
function logout() {
    sessionStorage.removeItem('isLoggedIn');
    window.location.href = './login/login.html';
}

document.getElementById('trainingLink').addEventListener('click', function (event) {
  event.preventDefault(); 

  // Check if the user is logged in (you can replace this with your actual session check)
  var isLoggedIn = sessionStorage.getItem('isLoggedIn');

  if (isLoggedIn) {
      
      window.location.href = './training/training.html';
  } else {
      // If the user is not logged in, redirect to the login page
      window.location.href = './login/login.html';
  }
})
document.getElementById('bookingLink').addEventListener('click', function (event) {
  event.preventDefault(); 

  // Check if the user is logged in (you can replace this with your actual session check)
  var isLoggedIn = sessionStorage.getItem('isLoggedIn');

  if (isLoggedIn) {
      
      window.location.href = './booking/booking.html';
  } else {
      // If the user is not logged in, redirect to the login page
      window.location.href = './login/login.html';
  }
});
