const supportsNativeSmoothScroll = 'scrollBehavior' in document.documentElement.style;
window.addEventListener('scroll',modifyHeadline);

function smoothScroll(element){
    if(window.innerHeight<window.innerWidth && innerWidth>1024){
        

       if(supportsNativeSmoothScroll){
        desktopSmoothScroll(element)
       } else desktopSmoothScrollMicrosoft(element);

        //console.log('been here')
        modifyHeadline()
        
    } else {
      console.log('mobile')
      mobileSmoothScroll(element)
    }

    
}



function modifyHeadline(){
 
 if(innerWidth>1024){
  

  let fixedElementWidth = document.getElementsByClassName('intro-nav-wrapper')[0].getBoundingClientRect().right;

    if(document.getElementsByClassName('two')[0].getBoundingClientRect().left>fixedElementWidth){
      document.getElementById('welcome').style.display='block';
      document.getElementById('text-about').style.display='none';
      document.getElementById('text-projects').style.display='none';
      document.getElementById('text-contact').style.display='none';

    } else if(document.getElementsByClassName('three')[0].getBoundingClientRect().left>fixedElementWidth){
      document.getElementById('welcome').style.display='none';
      document.getElementById('text-about').style.display='inline';
      document.getElementById('text-projects').style.display='none';
      document.getElementById('text-contact').style.display='none';
    } else if(document.getElementsByClassName('four')[0].getBoundingClientRect().left>fixedElementWidth+1){
      document.getElementById('welcome').style.display='none';
      document.getElementById('text-about').style.display='none';
      document.getElementById('text-projects').style.display='inline';
      document.getElementById('text-contact').style.display='none';
    } else if(document.getElementsByClassName('four')[0].getBoundingClientRect().left<=fixedElementWidth+1){
      document.getElementById('welcome').style.display='none';
      document.getElementById('text-about').style.display='none';
      document.getElementById('text-projects').style.display='none';
      document.getElementById('text-contact').style.display='inline';
    }
  }


}

function mobileSmoothScroll(element){
  
    
    switch(element){
        case 'home': window.scrollTo({
            top: 0,
            left: 0,
            behavior: "smooth"
          }); 
          break;
        case 'about me': window.scrollTo({
            top: document.getElementsByClassName('two')[0].getBoundingClientRect().top+screenY,
            left: 0,
            behavior: 'smooth'
          });
          break;
        case 'projects': window.scrollTo({
            top: document.getElementsByClassName('three')[0].getBoundingClientRect().top+scrollY,
            left: 0,
            behavior: 'smooth'
          });
          break;
        case 'contact': window.scrollTo({
            top: document.getElementsByClassName('four')[0].getBoundingClientRect().top+scrollY,
            left: 0,
            behavior: 'smooth'
          }); 
          break;
    }
}


function desktopSmoothScroll(element){
    switch(element){
        case 'home': window.scrollTo({
            top: 0,
            left: 0,
            behavior: 'smooth'
          }); 
          break;
        case 'about me': window.scrollTo({
            top: 0,
            left: innerWidth-document.getElementsByClassName('intro-nav-wrapper')[0].getBoundingClientRect().right+1,
            behavior: 'smooth'
          });
          break;
        case 'projects': window.scrollTo({
            top: 0,
            left: 2*(innerWidth-document.getElementsByClassName('intro-nav-wrapper')[0].getBoundingClientRect().right)+1,
            behavior: 'smooth'
          });
          break;
        case 'contact': window.scrollTo({
            top: 0,
            left: 3*(innerWidth-document.getElementsByClassName('intro-nav-wrapper')[0].getBoundingClientRect().right)+1,
            behavior: 'smooth'
          }); 
          break;
    }
}

function desktopSmoothScrollMicrosoft(element){

    switch(element){
      case 'home': window.scrollTo(0,0); 
        break;
      case 'about me': window.scrollTo(innerWidth-innerWidth*0.3,0);
        break;
      case 'projects': window.scrollTo((innerWidth*2)-2*innerWidth*0.3,0);
        break;
      case 'contact': window.scrollTo((innerWidth*3)-3*innerWidth*0.3,0); 
        break;
  }
}