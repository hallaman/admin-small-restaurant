var contact_form_toggle = false;
var xmlhttp;
var validate = true;

function toggle_contact_form(state) {
  
   var show = '';
   var button = '-';
   if (state == null) {
      contact_form_toggle = !contact_form_toggle;
   }
   else {
      contact_form_toggle = state;
   }
   if (!contact_form_toggle) {
      show = 'none';
      button = '+';
      document.getElementById("contact_header").style.backgroundImage = "url(images/closed.png)";
   }
   else {
      document.getElementById("contact_header").style.backgroundImage = "url(images/open.png)";
   }

   document.getElementById("contact_form").style.display = show;
}
   
   function browser_not_supported() {
      alert ("Can't send mail!  Browser does not support HTTP Request");
   }
   
   function validate_form() {

      var bad_email = false;
      var bad_name = false;

      if (!validate) {
         validate = true;
         return false;
      }
   
      if (document.contact_form.email.value=='') {
         bad_email = true;
         document.getElementById("req_email").src = "images/invalid.png";
      }
      else {
         document.getElementById("req_email").src = "images/valid.png";
      }
      
      if (document.contact_form.first_name.value=='') {
         bad_name = true;
         document.getElementById("req_name").src = "images/invalid.png";
      }
      else {
         document.getElementById("req_name").src = "images/valid.png";
      }
      
      if (bad_email || bad_name) {
         document.getElementById("incomplete").style.display='block';
         document.getElementById("form_errors").style.display='block';
         returnToTop();
         return false;
      }
      else {
         document.getElementById("incomplete").style.display='none';
         document.getElementById("form_errors").style.display='none';
         process_mail();
      }

      returnToTop();
      return true;
   
   }

function browser_not_supported() {
   alert ("Browser does not support HTTP Request");
}

function process_mail() {

   xmlhttp = GetXmlHttpObject();
   if (xmlhttp == null) {
      alert ("Browser does not support HTTP Request");
      return;
   }

   var url = "http/process-mail.php";
   url = url + "?email=" + document.contact_form.email.value;
   url = url + "&first_name=" + document.contact_form.first_name.value;
   url = url + "&last_name=" + document.contact_form.last_name.value;
   url = url + "&day_phone=" + document.contact_form.day_phone.value;
   url = url + "&night_phone=" + document.contact_form.night_phone.value;
   url = url + "&food_questions=" + document.contact_form.food_questions.checked;
   url = url + "&food_suggestions=" + document.contact_form.food_suggestions.checked;
   url = url + "&food_comments=" + document.contact_form.food_comments.checked;
   url = url + "&catering_inquiry=" + document.contact_form.catering_inquiry.checked;
   url = url + "&job_inquiry=" + document.contact_form.job_inquiry.checked;
   url = url + "&vendor_opportunities=" + document.contact_form.vendor_opportunities.checked;
   url = url + "&website_issues=" + document.contact_form.website_issues.checked;
   url = url + "&other=" + document.contact_form.other.checked;
   url = url + "&message=" + document.contact_form.message.value;
   url = url + "&copy=" + document.contact_form.copy.checked;
   url = url + "&sid=" + Math.random();

   xmlhttp.onreadystatechange = process_mail_complete;
   xmlhttp.open("GET", url, true);
   xmlhttp.send(null);

}

function process_mail_complete() {

   if (xmlhttp.readyState == 4) {
      reset_form();
      document.getElementById("email_confirmation").innerHTML = xmlhttp.responseText;
      document.getElementById("email_confirmation").style.display='block';
   }

}

function reset_form() {
      validate = false;
      document.contact_form.reset();
      document.getElementById("req_email").src = "images/valid.png";
      document.getElementById("req_name").src = "images/valid.png";
      document.getElementById("incomplete").style.display='none';
      document.getElementById("form_errors").style.display='none';
      document.getElementById("email_confirmation").style.display='none';
      validate = true;
      returnToTop();
}

function GetXmlHttpObject() {

   if (window.XMLHttpRequest) {
      // code for IE7+, Firefox, Chrome, Opera, Safari
      return new XMLHttpRequest();
   }
   
   if (window.ActiveXObject) {
      // code for IE6, IE5
      return new ActiveXObject("Microsoft.XMLHTTP");
   }
   
   return null;

}
