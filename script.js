function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
  document.getElementById("main").style.marginLeft = "250px";
  document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
  document.getElementById("main").style.marginLeft= "0";
  document.body.style.backgroundColor = "white";
}

document.getElementById('movieImageInput').addEventListener('change', function(event) {
  const file = event.target.files[0]; // Get the selected file
  if (file) {
      const reader = new FileReader(); // Create a FileReader object
      reader.onload = function(e) {
          const imgPreview = document.getElementById('movieImagePreview'); // Get the image element
          imgPreview.src = e.target.result; // Set the image source to the file's data URL
      };
      reader.readAsDataURL(file); // Read the file as a data URL
  }
});