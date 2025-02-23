
<!-- Preloader Wrapper -->
<div id="preloader">
  <span class="loader"></span>
</div>

<style>
/* Preloader container */
#preloader {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(255, 255, 255, 0.8);  /* semi-transparent background */
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 9999;  /* ensures it's on top of everything */
}

/* Loader styles */
.loader {
  width: 64px;
  height: 64px;
  position: relative;
  animation: rotate 1.5s ease-in infinite alternate;
}

.loader::before {
  content: '';
  position: absolute;
  left: 0;
  bottom: 0;
  color:rgb(255, 36, 65);
  background: currentColor;
  width: 64px;
  height: 32px;
  border-radius: 0 0 50px 50px;
}

.loader::after {
  content: '';
  position: absolute;
  left: 50%;
  top: 10%;
  background: rgb(22, 109, 150);
  width: 8px;
  height: 64px;
  animation: rotate 1.2s linear infinite alternate-reverse;
}

/* Rotation animation */
@keyframes rotate {
  100% { 
    transform: rotate(360deg);
  }
}
</style>  
