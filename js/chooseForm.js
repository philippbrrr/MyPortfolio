function chooseForm(element){
    let eins = document.getElementsByClassName("eins")[0];
    let zwei = document.getElementsByClassName("zwei")[0];
    console.log('moin')
    if(element == "eins" && document.getElementsByClassName('right')[0].classList.contains('active')){
        eins.style.display = 'flex';
        zwei.style.display = 'none';

        document.getElementsByClassName('left')[0].classList.add('active')
        document.getElementsByClassName('right')[0].classList.remove('active');
    } else if(element == 'zwei' && document.getElementsByClassName('left')[0].classList.contains('active')){
        eins.style.display = 'none';
        zwei.style.display = 'flex';

        
        document.getElementsByClassName('left')[0].classList.remove('active')
        document.getElementsByClassName('right')[0].classList.add('active');
    }
}