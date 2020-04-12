//ANIMATE IMAGES
(function($) {

var $slides = $('.slide'),
    max = $slides.length - 1,
    center = 1,
    classNames = '',
    animating = false;

$('#gallery').on('click', function(e) {
    // Wait for the animation to finish so we dont get a weird warped animation
    if (animating) return;
    
    // Was a btn clicked?
    if (e.target.parentNode.className === 'btn') {
    animating = true;
    
    // Update center position depending on which button was pressed
    switch (e.target.parentNode.id) {
        case 'btn-left':
        center = rotate(center - 1, max);
        $slides.parent().attr('class', 'sliding-left');
        break;
        case 'btn-right':
        center = rotate(center + 1, max);
        $slides.parent().attr('class', 'sliding-right');
        break;
    }
    
    // Update each slides class names
    $slides.each(function(i) {
        classNames = 'slide';
        switch (i) {
        case rotate(center - 1, max):
            classNames += ' section-ultilities__slides--1';
            break;
        case rotate(center, max):
            classNames += ' section-ultilities__slides--2';
            break;
        case rotate(center + 1, max):
            classNames += ' section-ultilities__slides--3';
            break;
        }
        this.className = classNames;
    })
    
    .on('transitionend', function() {
        animating = false;
    });
    }
});

function rotate(i, max) {
    if (i < 0) return max;
    if (i > max) return 0;
    return i;
}

}(jQuery));