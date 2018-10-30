
  <div class="swipes">
    <div class="carousel-cell">
      <div style="flex: 2">
        <img style="width:300; margin-top:-30px; margin-bottom:-30px" src="./img/meal1.png" />
      </div>
      <div style="flex: 2">
        <div style="color: #fff; font-size: 40; text-align: center">Italian Chicken Tenders with White Rice<br><small style="position: relative; top: -5px;"><s>$10</s></small> $6.99</div>
        <div style="flex-direction: row; justify-content: center"><br>
          <div style="color: #fff; font-size: 20; text-align: center"><b>Pickup Day and Location:</b><br><a id="dateLocStand" href="https://www.google.com/maps/place/Lower+Sproul+Plaza/@37.8691297,-122.2605928,19.23z/data=!4m8!1m2!2m1!1ssproul+plaza!3m4!1s0x80857c26064003d7:0x103b6908aeacf56a!8m2!3d37.8691454!4d-122.2602313" target=_blank><i class="fa fa-map-marker"></i> Sproul Plaza, Nov 1st @ 12-2:00 p.m.</a></div><br>
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
            <a><button onclick="checkLogin()" id="reserveButtonVegan" style="font-size: 25; font-family:'Times New Roman', Times, serif">Reserve Now! (Vegan)</button></a>
            <div style="flex-direction: row; justify-content: center">
              <a ><button disabled class="astext" onclick="cancelReservation(true)" id="cancelReservationButtonVegan" style="margin-top:25; color: #00f; font-size: 15;">Cancel Reservation</button></a>
            </div>
          </div>

    </div>
  </div>

  <script>
      reservationDate = "10/11";

      function callReservationPrompt(mealName) {
        var amountInput = prompt("Please enter number of reservations for "+readCookie("userDisplayName")+":", "max. 5");
        if(amountInput != null) {
          checkAmountInput(amountInput, mealName);
        }
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
          window.alert("Please enter a valid number (MAX. 5).");
          callReservationPrompt(mealName);
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
