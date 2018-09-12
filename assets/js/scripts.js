function showDelete() {

  $('i.fa-minus-square').toggleClass('delete');

}

function remAction(id){
  var element = document.getElementById(id);
    element.parentNode.removeChild(element);
}
