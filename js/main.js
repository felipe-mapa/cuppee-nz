//NAVIGATION BAR
$(window).scroll(function() {
    if($(this).scrollTop() > 470)
    {
        $('.navigation-transparent').addClass('navigation__solid-color');
    } else {
        $('.navigation-transparent').removeClass('navigation__solid-color');
    }
});

//AOS FUNCTION TO ANIMATE IMAGES IN
$(function() {
    AOS.init({
        offset: 200,
        duration: 600,
        easing: 'ease-in-out',
        delay: 100,
    });
});