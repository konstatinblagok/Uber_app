burger = document.querySelector('.burger')
navlink = document.querySelector('.nav_links')
navigation = document.querySelector('.navigation')



burger.addEventListener('click', ()=>{
    navlink.classList.toggle('v-class');
    navigation.classList.toggle('h-nav');
})