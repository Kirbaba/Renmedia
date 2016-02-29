$(document).ready(function() {

    $('#back_call').on('click', function(){
        var modalName = $('#modalName').val();
        var modalPhone = $('#modalPhone').val();
        $.ajax({
            url: myajax.act, //url, к которому обращаемся
            type: "POST",
            data: "action=sendBC&name=" + modalName + "&phone=" + modalPhone ,
            success: function (data) {
                alert("Запрос отправлен.");
                $('#myModal').modal('hide');
            }
        });
        return false;
    });
 
  $("#owl-demo").owlCarousel({
 
      navigation : true, // Show next and prev buttons
      slideSpeed : 300,
      paginationSpeed : 400,
      singleItem:true,
      pagination:false,
      navigationText:false
 
      // "singleItem:true" is a shortcut for:
      // items : 1, 
      // itemsDesktop : false,
      // itemsDesktopSmall : false,
      // itemsTablet: false,
      // itemsMobile : false
 
  });
 
});

$(function() {

    $(window).scroll(function() {
        if($(this).scrollTop() != 0) {
            $('#toTop').fadeIn();
        } else {
            $('#toTop').fadeOut();
        }
    });
    $('#toTop').click(function() {
        $('body,html').animate({scrollTop: 0}, 1000);
    });

    $('.smoothScroll').click(function(event) {
        event.preventDefault();
        var href=$(this).attr('href');
        var target=$(href);
        var top=target.offset().top;
        $('html,body').animate({
            scrollTop: top
        }, 1000);
    });
});

ymaps.ready(init);

function init () {
    var log = document.getElementById('log'),
        myMap = new ymaps.Map("map", {
            center: [55.76, 37.64],
            zoom: 12,
            controls: ['zoomControl']
        }),
        myCircle = new ymaps.Circle([myMap.getCenter(), 3000], {
            balloonContentBody: 'Балун',
            hintContent: 'Хинт'
        }, {
            draggable: true
        });

    myMap.geoObjects.add(myCircle);
}
