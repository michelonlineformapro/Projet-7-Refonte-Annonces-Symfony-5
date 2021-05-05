

//Nom de la classe bootrap <input type file="custom-file-input"/>
$(".custom-file-input").on('change', function (){
    let fileName = $(this).val().split('\\').pop();
    $(this).siblings('.custom-file-label').addClass('selected').html(fileName);
})

/*
let input = document.querySelector(".custom-file-input");
input.addEventListener('change', function (){
    let fileName = input.getAttribute('value').split('\\').pop()
    var label = document.getElementById('annonces_imageAnnonces').nextSibling
})

 */