$(document).ready(function () {
  $("#loginForm").on("submit", function (e) {
    e.preventDefault(); // Prevent the default form submission
    // alert('hello');
    let email = $("#email").val();
    let password = $("#password").val();

    // AJAX request
    $.ajax({
      url: "login.php",
      type: "POST",
      data: {
        email: email,
        password: password,
      },
      success: function (response) {
        // Parse the JSON response
        let data = JSON.parse(response);

        if (data.status === "success") {
          window.location.href = "./admin/index.php";
        } else {
          alert(data.message); // Show error message
        }
      },
      error: function (xhr, status, error) {
        console.error("AJAX Error: ", status, error);
      },
    });
  });
});
