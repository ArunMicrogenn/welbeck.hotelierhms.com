<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Frontoffice</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <!-- <link rel="stylesheet" href="Sign-in.css" /> -->

</head>
<style>
    *{
    box-sizing: border-box;
}
button:active {
  transform: translateY(2px);   
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.card{
    display: flex;
    flex-direction: row;
    margin-top: 8%;
    background-color: #0D2845;
    border-radius: 8px;
    border: transparent;
    /* width: 80vw;
    height: 60vh; */
    align-items: center;
    filter: drop-shadow( 16px 16px 8px #000000cb);
    box-shadow: 
    inset 16px 16px 24px #0450a1e6,
    inset -16px -16px 24px #000d1ae6;

}
.one,
.two{
    display: flex;
    flex-direction: column;
    font-family: 'Montserrat', sans-serif;
    color: white;
    font-size: 16px;
    font-weight: 300;
}
.mail,
.pass{
    padding: 8px;
    background-color: transparent;
    border: 1px solid white;
    border-radius: 8px;
    max-height: 40px;
    /* width: 400px; */
    font-family: 'Montserrat', sans-serif;
    font-size: 18px;
    font-weight: 400;
    color: white;
}
.txtbt{
    background-color: transparent;
    border: transparent;
    font-family: 'Montserrat', sans-serif;
    font-size: 12px;
    font-weight: 300;
    color: white;
}

.filled{
    background-color: #A8943E;
    border: transparent;
    border-radius: 8px;
    padding: 8px 40px;
    font-family: 'Montserrat', sans-serif;
    font-size: 16px;
    font-weight: 500;
    color: white;
    filter: drop-shadow( 2px 2px 4px #00000094);
    box-shadow: 
    inset 2px 2px 8px #e3ba03,
    inset -2px -2px 8px #2e2600;
}
.duo{
    /* padding: 16px; */
    display: flex;
    flex-direction: row;
    align-items: center;
}
.one-five,
.two-five{
    font-family: 'Montserrat', sans-serif;
    font-size: 14px;
    font-weight: 300;
    color: white;
    align-items: center;
}
.clrtxt{
    background-color: transparent;
    border: transparent;
    border-radius: none;
    padding: none;
    font-family: 'Montserrat', sans-serif;
    font-size: 14px;
    font-weight: 400;
    /* align-items: center; */
    color: #A8943E;
}
/* .context{
    display: flex;
    flex-direction: column;
    align-items: inherit;
    gap: 16px;
} */
               /* ------------------------over-All Row padding------------------------ */
.odrow{
    display: flex;
    flex-direction: row;
    gap: 0;
    align-items: center;
    padding: 40px;
}
.were{
    display: flex;
    flex-direction: column;
}
@media (max-width: 768px) {
  .filled {
    padding: 8px 24px;
    font-size: 14px;
  }
}
@media (max-width: 576px) {
  .mail, .pass {
    font-size: 14px;
    padding: 6px;
  }

  .filled {
    padding: 6px 20px;
  }
}

</style>
<body>

  <!-- ----------------------------------------------------- Bootstrap cdn---------------------------------------------------------------- -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

  <div class="container card p-4 p-sm-2">
    
    <div class="row align-items-center odrow">
      <!------------------------------------------------------ Logo Section ----------------------------------------------------------------->
     
      <div class="col-12 col-md-6 p-4 p-sm-2 text-center imga">
      <!-- <img src="hms logo.png" class="img-fluid" alt="Logo"> -->
      <img src="<?php echo scs_skin?>images/hms_logo.png" class="img-fluid" alt="Logo"/>
      </div>

      <!----------------------------------------------------- Form Section -------------------------------------------------------------------->
      
      <div class="col-12 col-md-6 p-3 text-center  context">
      <form action="<?php echo scs_index?>login"  method="post">
       
        <div class="row align-items-center were">

          <div class="col-12 col-lg-8 col-md-10 col-sm-12  mb-3 text-start one">
            <label for="username">Username</label>
            <input type="text" class="mail" id="username" name="username" placeholder="Enter your Username">
          </div>

          <div class="col-12 col-lg-8 col-md-10 col-sm-12 mb-0 text-start two">
            <label for="password">Password</label>
            <input type="password" class="pass" id="password" name="password" placeholder="Password">
          </div>

          <div class="col-12 col-lg-8 col-md-10 col-sm-12 mb-4 text-end">
            <button type="button" class="txtbt">Forgot Password?</button>
          </div>

          <div class="col-8 col-md-8 mb-4 text-center">
            <button type="submit" class="filled">Sign In</button>
          </div>

          
          <div class="col-12 col-md-12 d-flex justify-content-center align-items-center duo">
            <span class="one-five">Don't have an account?</span>
            <button type="button" class="clrtxt">Create one</button>
          </div>

        </div>
        </form>

      </div>

    </div>

  </div>

</body>
</html>
