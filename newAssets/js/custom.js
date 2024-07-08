

// Owl for client logo carousel js  

$('.owl-carousel').owlCarousel({
    loop:true,
    autoplay:true,
    nav:true,
    margin:40,
    responsiveClass:true,
    responsive:{
        0:{
            items:1,
            nav:false
        },
        600:{
            items:3,
            nav:false
        },
        1000:{
            items:4,
            nav:false,
            loop:true
        }
    }
});


// Get content of div using single modal

        $('.pop_modal').click(function(event){
            var title = $(this).find('.c_title').text();
            var desc = $(this).find('.d_desc').text();
            
            $('#modal_title').text(title);
            $('#modal_content').text(desc);
            
        });        
    




