<div id="countdown" class="countdown">
  <h1><i>Reserve until Wednesday</i></h1>
  <ul>
    <li><span id="hours"></span>Hours</li>
    <li><span id="minutes"></span>Minutes</li>
    <li><span id="seconds"></span>Seconds</li>
  </ul>
</div>
<br>
  <div class="swipes">
    <div class="static-banner static-banner1">The Airbnb of Food</div>
    <div class="carousel-cell">
    <a class="modal__trigger" data-modal="#modal">
      <div style="flex: 2">
        <center><img style="width:300; margin-top:-30px; margin-bottom:-30px" src="./img/meal1.png" /></center>
      </div>
    </a>
      <div style="flex: 2">
        <div style="color: #fff; font-size: 40; text-align: center">Homemade Thursday Special<br><small style="position: relative; top: -5px;"><s>$11.99</s></small> $7.99</div>
        <div style="flex-direction: row; justify-content: center"><br>
          <div style="color: #fff; font-size: 20; text-align: center"><b>Pickup Date:</b> Thursday, Nov 1st, 12-2pm <i class="fa fa-clock-o"></i><br><b>Pickup Location:</b> <a id="dateLocStand" href="https://goo.gl/maps/RANQjggP3aM2" target="_blank"> Sproul Plaza, UCB <i class="fa fa-map-marker"></i></a></div><br>
        </div>
      </div>
      <div style="flex: 2">
        <a class="bt1"><button id="reserveButton" onclick="checkLogin()">Reserve Now!</button></a>
            <div style="flex-direction: row; justify-content: center">
              <a ><button disabled class="astext" onclick="cancelReservation(false)" id="cancelReservationButton" style="margin-top:25; color: #00f; font-size: 15;">Cancel Reservation</button></a>
            </div>
      </div>
    </div>
    <div class="carousel-cell">
      <img style="width:300; margin-top:-30px; margin-bottom:-30px" src="./img/meal1.png" />

          <div style="flex: 2">
            <a><button onclick="checkLogin()" id="reserveButtonVegan" style="font-size: 25;>Reserve Now! (Vegan)</button></a>
            <div style="flex-direction: row; justify-content: center">
              <a ><button disabled class="astext" onclick="cancelReservation(true)" id="cancelReservationButtonVegan" style="margin-top:25; color: #00f; font-size: 15;">Cancel Reservation</button></a>
            </div>
          </div>

    </div>

  <br><br><br><br>

  <div class="funfact countdown" style="max-width:450px;">
    <h2>Did You Know...?</h2>
    <p>The average price a Cal student pay for a meal is $11.<br>We are here to make food Affordable!</p><br>
  </div>

  <br><br><br>

  <div class="funfact" style="padding:10px">
    <h2 style="font-size: 2em; color:#fff">Follow Us on Social Media: <a href="https://www.facebook.com/Mealy.me/" target="_blank"><img src="https://d1jgln4w9al398.cloudfront.net/site/2.1.238-20181023.22/css/images/ico_facebook.png" width="32"></a></h2>
  </div>

<!-- Modal -->
  <div id="modal" class="modal modal__bg" role="dialog" aria-hidden="true">
    <div class="modal__dialog">
      <div class="modal__content">
        <img src="https://i.imgur.com/A5pqvJe.png" class="img-responsive">
        <h1>Homemade Thursday Special</h1>
        <p>Lemon and pepper chicken breast, vegetables on the wok in a combo with rice. Your perfect daily option.</p>
        
        <!-- modal close button -->
        <a href="" class="modal__close demo-close">
          <svg class="" viewBox="0 0 24 24"><path d="M19 6.41l-1.41-1.41-5.59 5.59-5.59-5.59-1.41 1.41 5.59 5.59-5.59 5.59 1.41 1.41 5.59-5.59 5.59 5.59 1.41-1.41-5.59-5.59z"/><path d="M0 0h24v24h-24z" fill="none"/></svg>
        </a>
        
      </div>
    </div>
  </div>


  <script type="text/javascript">

  const second = 1000,
        minute = second * 60,
        hour = minute * 60,
        day = hour * 24;

  let countDown = new Date('Oct 31, 2018 18:00:00').getTime(),
      x = setInterval(function() {

        let now = new Date().getTime(),
            distance = countDown - now;

          document.getElementById('hours').innerText = Math.floor(distance / (hour)),
          document.getElementById('minutes').innerText = Math.floor((distance % (hour)) / (minute)),
          document.getElementById('seconds').innerText = Math.floor((distance % (minute)) / second);
        
        //do something later when date is reached
        //if (distance < 0) {
        //  clearInterval(x);
        //  'IT'S MY BIRTHDAY!;
        //}

      }, second);

      reservationDate = "10/11";

      function callReservationPrompt(mealName) {
        swal({
          title: 'Please enter how many Meals:',
          content: {
            element: "input",
            attributes: {
              placeholder: "Type a number",
              type: "number",
              max: "5",
            },
          },
          icon: "success",
          button: {
            text: "Next",
          },
        })
        .then(amountInput => {
          if (!amountInput) throw null;
         
          if(amountInput != null) {
            checkAmountInput(amountInput, mealName);
          }
        })
      }

      function checkLogin() {
        if(readCookie("userDisplayName") == null) {
          eraseCookie("loggedIn");  
        }
        if(readCookie("loggedIn") == null || readCookie("loggedIn") == false) {
          signInGoogle();
        }
        else {
          var mealName = (window.event.target.id == "reserveButton") ? "Beef With Rice" : "Falafel With Vegetables";
          callReservationPrompt(mealName);
        }
      }

      function checkAmountInput(input, mealName) {
        if(!isNaN(parseInt(input)) && parseInt(input) > 0 && parseInt(input) <= 5) {
          //Redirect to Checkout Screen
          //Save to firebase!!!!
          createCookie("reservationAmount", input, 1);
          createCookie("mealPrice", 7, 1);
          createCookie("mealName", mealName, 1);
          document.location.href = "./?ly=checkout";
        }

        else {
          swal({text: "Please enter a valid number (MAXIMUM OF 5)", icon: "error"}).then(results => {callReservationPrompt(mealName)});
        }

      }
      window.onload = function() {
        //document.getElementById("dateLocStand").innerText = "Sproul Plaza, " + reservationDate + " @ 12:00 P.M " ;
        $("#cancelReservationButton").fadeOut('fast');
        $("#cancelReservationButtonVegan").fadeOut('fast');
        if(readCookie("loggedIn") == "true") {
          firebase.database().ref("Client Reservations/" + readCookie("userDisplayName") + "/Beef With Rice").once("value", function(snapshot) {
            if(snapshot.exists()) {
              changeReserveButton($("#reserveButton"), $("#cancelReservationButton"), true);
            }
          });
          firebase.database().ref("Client Reservations/" + readCookie("userDisplayName") + "/Falafel With Vegetables").once("value", function(snapshot) {
            if(snapshot.exists()) {
              changeReserveButton($("#reserveButtonVegan"), $("#cancelReservationButtonVegan"), true);
            }
          });
        }
      };

      function cancelReservation(isVegan) {
        var mealName = isVegan ? "Falafel With Vegetables" : "Beef With Rice";
        firebase.database().ref("Client Reservations/" + readCookie("userDisplayName") + "/" + mealName).once("value", function(snapshot) {
            if(snapshot.exists() && snapshot.val().paymentMethod == "Cash (collect)") {
              var confirm = window.confirm("Are you sure you want to cancel your current reservation?");
              if (confirm) {
                firebase.database().ref("Client Reservations/" + readCookie("userDisplayName") + "/" + mealName).remove();
                alert("Your reservation was cancelled.");
                if(mealName == "Beef With Rice") {
                  changeReserveButton($("#reserveButton"), $("#cancelReservationButton"), false);  
                }
                else {
                  changeReserveButton($("#reserveButtonVegan"), $("#cancelReservationButtonVegan"), false);  
                }
              }
            }
            else {
              alert("You chose PayPal as the payment method. Please contact us if you really wish to cancel your reservation.");
            }
          });
      }

      function changeReserveButton(reserveButton, cancelButton, changeToDetails) {
        if(changeToDetails) {
          reserveButton.fadeOut('fast');
          //$("#reserveButton").fadeOut('fast');
          cancelButton.fadeOut('fast');
          var firstName = readCookie("userDisplayName").split(' ')[0];
          reserveButton[0].setAttribute("style", "font-size: 15");
          reserveButton[0].innerHTML = "Your meal will be ready in <br> in 00:00:00";
          reserveButton.attr("onclick","displayDetails(\"Beef With Rice\")"); //"displayDetails(\"Beef With Rice\")");
          cancelButton[0].disabled=false;

          wait(1000);
          reserveButton.fadeIn('fast');
          //$("#reserveButton").fadeIn('fast');
          cancelButton.fadeIn('fast');

          var countDownDate = new Date("Nov 1, 2018 12:00:00").getTime();
          var x = setInterval(function() {
            if(document.getElementById("reserveButton").innerHTML=="Reserve Now!") {
              clearInterval(x);
            }
            else {
              // Get todays date and time
              var now = new Date().getTime();

              // Find the distance between now and the count down date
              var distance = countDownDate - now;

              // Time calculations for days, hours, minutes and seconds
              var days = Math.floor(distance / (1000 * 60 * 60 * 24));
              var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
              hours+=days*24;
              var strHours = (hours < 10) ? "0"+hours : ""+hours;
              var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
              var strMinutes = (minutes < 10) ? "0"+minutes : ""+minutes;
              var seconds = Math.floor((distance % (1000 * 60)) / 1000);
              var strSeconds = (seconds < 10) ? "0"+seconds : ""+seconds;

              // Display the result in the element with id="demo"
              document.getElementById("reserveButton").innerHTML = "Your meal will be ready in <br>" + strHours + "h " + strMinutes + "m " + strSeconds + "s";

              // If the count down is finished, write some text 
              if (distance < 0) {
                clearInterval(x);
                document.getElementById("reserveButton").innerHTML = "YOUR RESERVATION IS READY FOR PICKUP!";
              }
            }
          }, 1000);
          //setTime(reserveButton);
        }
        else {
          reserveButton.fadeOut('fast');
          cancelButton.fadeOut('fast');
          reserveButton[0].innerHTML =  "Reserve Now!";
          reserveButton.attr("onclick","checkLogin()");
          cancelButton[0].disabled=true;
          wait(1000);
          reserveButton.fadeIn('fast');
        }
      }

      function displayDetails(mealName) {
        firebase.database().ref("Client Reservations/" + readCookie("userDisplayName") +"/" + mealName).once("value", function(snapshot) {
            if(snapshot.exists()) {
              let dateReservation = snapshot.val().dateReservation;
              let reservationAmount = snapshot.val().numberReservations;
              let paymentMethod = snapshot.val().paymentMethod;
              window.alert("Reservation Details:\n\nDate of Reservation: " +  dateReservation+ "\nNumber of meals Requested: " + reservationAmount + "\nPayment Method: "+ paymentMethod)
            }
          });
      }

      function wait(ms){
        var start = new Date().getTime();
        var end = start;
        while(end < start + ms) {
          end = new Date().getTime();
        }
      }

  </script>
  <script type="text/javascript" src="./js/modal.js"></script>