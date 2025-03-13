document.getElementById("loginForm").addEventListener("submit", function (event) {
    event.preventDefault();
  
    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;
  
    const validUsername = "admin";
    const validPassword = "password123";
  
    const errorMessage = document.getElementById("error-message");
  
    if (username === validUsername && password === validPassword) {
      window.location.href = "success.html"; 
    } else {
      errorMessage.textContent = "Invalid username or password. Please try again.";
      errorMessage.style.display = "block";
    }
  });
  