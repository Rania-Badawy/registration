<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en"  oncontextmenu="return false">
<head>
<meta charset="utf-8">
<title>Error</title>
<style type="text/css">

@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet");

@import url("https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700");

*{
  margin:0;
  padding:0;
  box-sizing:border-box;
}

body{
 overflow-x: hidden;
  background-color: #f4f6ff;
}

.container{
  width:100vw;
  height:100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  font-family: "Poppins", sans-serif;
  position: relative;
  left:6vmin;
  
}

.cog-wheel1, .cog-wheel2{
  transform:scale(0.7);
}

.cog1, .cog2{
  width:40vmin;
  height:40vmin;
  border-radius:50%;
  border:6vmin solid #f3c623;
  position: relative;
}


.cog2{
  border:6vmin solid #4f8a8b;
}

.top, .down, .left, .right, .left-top, .left-down, .right-top, .right-down{
  width:10vmin;
  height:10vmin;
  background-color: #f3c623;
  position: absolute;
}

.cog2 .top,.cog2  .down,.cog2  .left,.cog2  .right,.cog2  .left-top,.cog2  .left-down,.cog2  .right-top,.cog2  .right-down{
  background-color: #4f8a8b;
}

.top{
  top:-14vmin;
  left:9vmin;
}

.down{
  bottom:-14vmin;
  left:9vmin;
}

.left{
  left:-14vmin;
  top:9vmin;
}

.right{
  right:-14vmin;
  top:9vmin;
}

.left-top{
  transform:rotateZ(-45deg);
  left:-8vmin;
  top:-8vmin;
}

.left-down{
  transform:rotateZ(45deg);
  left:-8vmin;
  top:25vmin;
}

.right-top{
  transform:rotateZ(45deg);
  right:-8vmin;
  top:-8vmin;
}

.right-down{
  transform:rotateZ(-45deg);
  right:-8vmin;
  top:25vmin;
}

.cog2{
  position: relative;
  left:-10.2vmin;
  bottom:10vmin;
}

h1{
  color:#142833;
}

.first-four{
  position: relative;
  left:6vmin;
  font-size:40vmin;
}

.second-four{
  position: relative;
  right:18vmin;
  z-index: -1;
  font-size:40vmin;
}

.wrong-para{
  font-family: "Montserrat", sans-serif;
  position: absolute;
  bottom:15vmin;
  padding:3vmin 12vmin 3vmin 3vmin;
  font-weight:600;
  color:#092532;
}
   .hidden {
        display: none !important;
      }
      
      #container{
          background-color: #f4f6ff;
  width: 100%;
  border: 2px solid #f3c623;
  padding: 50px;
  margin: 20px;
      }
      
      input[type=text] {
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}
input[type=button] {
 
  background-color: #4f8a8b;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
}
</style>
</head>
<body>
<!--  <div class="container">-->
<!--  <h1 class="first-four">4</h1>-->
<!--  <div class="cog-wheel1">-->
<!--      <div class="cog1">-->
<!--        <div class="top"></div>-->
<!--        <div class="down"></div>-->
<!--        <div class="left-top"></div>-->
<!--        <div class="left-down"></div>-->
<!--        <div class="right-top"></div>-->
<!--        <div class="right-down"></div>-->
<!--        <div class="left"></div>-->
<!--        <div class="right"></div>-->
<!--    </div>-->
<!--  </div>-->
  
<!--  <div class="cog-wheel2"> -->
<!--    <div class="cog2">-->
<!--        <div class="top"></div>-->
<!--        <div class="down"></div>-->
<!--        <div class="left-top"></div>-->
<!--        <div class="left-down"></div>-->
<!--        <div class="right-top"></div>-->
<!--        <div class="right-down"></div>-->
<!--        <div class="left"></div>-->
<!--        <div class="right"></div>-->
<!--    </div>-->
<!--  </div>-->
<!-- <h1 class="second-four">4</h1>-->
<!--  <p class="wrong-para">Something went wrong, please try again</p>-->
<!--</div>-->
 <img src="<?php echo base_url(); ?>intro/images/Error.jpg" style="width: 800px;margin: 5% 25%;"/>

<div id="credentials" style="text-align: center;">
   <label for="password">Password:</label>
  <input type="text" id="password" onkeydown="if (event.keyCode == 13) verify()" />
  <input id="button" type="button" value="view error" onclick="verify()" />
</div>
	<div id="container" class="hidden">
		<h1><?php echo $heading; ?></h1>
		<?php  echo $message; ?>
	</div>
	
	
	
	<script>
	    function verify() {
  if (document.getElementById('password').value === 'as1390hj') {
    document.getElementById('container').classList.remove("hidden"); // Using class instead of inline CSS
    document.getElementById('credentials').classList.add("hidden"); // Hide the div containing the credentials
  } else {
    alert('Invalid Password!');
    password.setSelectionRange(0, password.value.length);
  }
  return false;
}
	</script>
</body>
</html>