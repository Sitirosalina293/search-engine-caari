//pemrosesan untuk search image
let timer;
$(document).ready(function() { //hasil
    $(".result").on("click", function() {
        let id = $(this).attr("data-linkId");
        let url = $(this).attr("href");
        if(!id){
            console.log("data not found")
        }
        increaseLinkClicks(id, url);
        return false;
    })
    let grid = $(".imageResults"); //hasil yang diperoleh ditampilkan berupa grid atau kotak-kotak
    grid.on("layoutComplete", function() {
        $(".gridItem img").css("visibility", "visible")
    })
    grid.masonry({
        itemSelected: ".gridItem",
        columnWidth: 200,
        gutter: 5,
        initLayout: false
    });
    $("[data-fancybox]").fancybox({ //fancybox untuk menampilkan single gambar, jika gambar di klik
        caption : function( instance, item ) {
            let caption = $(this).data('caption') || '';
            let siteUrl = $(this).data('siteUrl') || '';
            if ( item.type === 'image' ) {
                caption = (caption.length ? caption + '<br />' : '')
                    + '<a href="' + item.src + '">View image</a><br>'
                    + '<a href="' + siteUrl + '">Visit page</a>';
            }

            return caption;
        }
    });
})
//loading image saat pertama
function loadImage(src, className){
    let image = $("<img>");
    image.on("load", function(){
        $("." +  className + " a").append(image);
        clearTimeout(timer);
        timer = setTimeout(function() {
            $(".imageResults").masonry();
        }, 500);
    });
    image.on("error", function(){
        $("." +  className).remove();
        $.post("ajax/setBroken.php", {src: src});
    });
    image.attr("src", src);
}
//menggunakan fungsi php update clicks
function increaseLinkClicks(linkId, url){
    $.post("ajax/updateLinkCount.php", {linkId: linkId})
        .done(function(result) {
            if(result !== ""){
                alert(result)
                return;
            }
            window.location.href = url;
        })
}
