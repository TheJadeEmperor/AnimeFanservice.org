$( document ).ready(function() {
    $("body").keydown(function(e) {
    if(e.keyCode == 37) { // left
      plusSlides(-1); console.log('plusSlides(-1);');
    }
    else if(e.keyCode == 39) { // right
      plusSlides(1); console.log('plusSlides(1);');
    }
    else if(e.keyCode == 27) { //esc
      closeModal(); console.log('closeModal();');
    }
  });
  });
 
  function openModal() {
      document.getElementById("myModal").style.display = "block";
  }
  
  function closeModal() {
      document.getElementById("myModal").style.display = "none";
  }
  
  var slideIndex = 1;
  showSlides(slideIndex);
  
  function plusSlides(n) {
      showSlides(slideIndex += n);
  }
  
  function currentSlide(n) {
      showSlides(slideIndex = n);
  }
  
  function showSlides(n) {
      var i;
      var slides = document.getElementsByClassName("mySlides");
      var dots = document.getElementsByClassName("demo");
      var captionText = document.getElementById("caption");
      
      if (n > slides.length) {slideIndex = 1} //last slide
      if (n < 1) {slideIndex = slides.length} //no slides 
      for (i = 0; i < slides.length; i++) {
          slides[i].style.display = "none";
      }
      for (i = 0; i < dots.length; i++) {
          dots[i].className = dots[i].className.replace(" active", "");
      }
      slides[slideIndex-1].style.display = "block";
      dots[slideIndex-1].className += " active";
      captionText.innerHTML = dots[slideIndex-1].alt;
      console.log('n: '+n+' slideIndex: '+slideIndex+'');
  }