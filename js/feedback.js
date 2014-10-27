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
         
   var url = "http/process-feedback.php";
   url = url + "?email=" + document.contact_form.email.value;
   url = url + "&first_name=" + document.contact_form.first_name.value;
   url = url + "&last_name=" + document.contact_form.last_name.value;
   url = url + "&day_phone=" + document.contact_form.day_phone.value;
   url = url + "&night_phone=" + document.contact_form.night_phone.value;
   url = url + "&frequency_sunflower=" + document.contact_form.frequency_sunflower.value;
   url = url + "&frequency_other=" + document.contact_form.frequency_other.value;
   url = url + "&diet_type=" + document.contact_form.diet_type.value;
   url = url + "&diet_length=" + document.contact_form.diet_length.value;
   url = url + "&avoid_nuts=" + document.contact_form.avoid_nuts.checked;
   url = url + "&avoid_gluten=" + document.contact_form.avoid_gluten.checked;
   url = url + "&avoid_soy=" + document.contact_form.avoid_soy.checked;
   url = url + "&avoid_dairy=" + document.contact_form.avoid_dairy.checked;
   url = url + "&avoid_garlic=" + document.contact_form.avoid_garlic.checked;
   url = url + "&avoid_mushrooms=" + document.contact_form.avoid_mushrooms.checked;
   url = url + "&avoid_corn=" + document.contact_form.avoid_corn.checked;
   url = url + "&avoid_all_grains=" + document.contact_form.avoid_all_grains.checked;
   url = url + "&avoid_sugar=" + document.contact_form.avoid_sugar.checked;
   url = url + "&avoid_spicy_food=" + document.contact_form.avoid_spicy_food.checked;
   url = url + "&avoid_other_things=" + document.contact_form.avoid_other_things.value;
   url = url + "&food_rating=" + document.contact_form.food_rating.value;
   url = url + "&food_comments=" + document.contact_form.food_comments.value;
   url = url + "&service_rating=" + document.contact_form.service_rating.value;
   url = url + "&service_comments=" + document.contact_form.service_comments.value;
   url = url + "&most_favorite=" + document.contact_form.most_favorite.value;
   url = url + "&least_favorite=" + document.contact_form.least_favorite.value;
   url = url + "&what_you_want=" + document.contact_form.what_you_want.value;
   url = url + "&general_comments=" + document.contact_form.general_comments.value;
   url = url + "&privacy=" + document.contact_form.privacy.value;   
   url = url + "&copy=" + document.contact_form.copy.checked;
   url = url + "&sid=" + Math.random();

   xmlhttp.onreadystatechange = process_feedback_complete;
   xmlhttp.open("GET", url, true);
   xmlhttp.send(null);

}

function process_feedback_complete() {

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
