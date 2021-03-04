window.addEventListener('load', rotateDevice)
window.addEventListener('resize', rotateDevice)

function is_touch_device() {
    return !!('ontouchstart' in window || navigator.maxTouchPoints);       // works on IE10/11 and Surface
};


function rotateDevice(){
    if(innerWidth>1024 && is_touch_device() && innerWidth>innerHeight){
        document.getElementById('popup').style.display ='flex';
        document.getElementsByTagName('header')[0].style.display ='none'
        document.getElementsByTagName('main')[0].style.display ='none'
    } else{
        document.getElementById('popup').style.display ='none';
        document.getElementsByTagName('header')[0].style.display ='block'
        document.getElementsByTagName('main')[0].style.display ='block'
    }
}

function showDesktop(){
        document.getElementById('popup').style.display ='none';
        document.getElementsByTagName('header')[0].style.display ='block'
        document.getElementsByTagName('main')[0].style.display ='block'
}