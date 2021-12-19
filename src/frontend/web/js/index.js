for (i = 0; i < $(".post_content_text").length; i++) {
   if ($(".post_content_text")[i].innerHTML.match(/(https?:\/\/)?([\w-]{1,32}\.[\w-]{1,32})[^\s@]*/ig))
	   $(".post_content_text")[i].innerHTML = $(".post_content_text")[i].innerText.replace(/(https?:\/\/)?([\w-]{1,32}\.[\w-]{1,32})([^\s@]*)/ig, "<a href='$1$2$3'>$1$2$3</a>")
}
for (i = 0; i < $(".post_content_text").length; i++) {
   if ($(".post_content_text")[i].innerHTML.match(/#(\w*)/ig))
	   $(".post_content_text")[i].innerHTML = $(".post_content_text")[i].innerHTML.replace(/#(\w*)/ig, "<a href='/search?search=$1'>#$1</a>")
}
$('.posts').on('click', '.like', function(e) {
	var postid = $(this).attr("data-id")
	var it = e.target;
	$.ajax({
		method: 'GET', 
		url: '/posts/like?id=' + postid,
	}).done(function(data) {
		$.ajax({
			method: 'GET',
			url: '/notifications/add-like?postid=' + postid
		});
		it.innerHTML = it.innerHTML.match(/\d+/g) * 1 + data * 1
		it.innerHTML = "Нравится (" + it.innerHTML + ")"
		console.log(it.innerHTML.match(/\d+/g))
	});
});
$('.posts').on('click', '.delete', function(e) {
	var postid = $(this).attr("data-id")
	var it = e.target;
	$.ajax({
		method: 'GET', 
		url: '/posts/delete?id=' + postid,
	}).done(function(data) {
		location.reload();
	});
});
$("#postform-img").change(function() {
  filename = this.files[0].name
  $("#img-label a").html(filename)
  console.log(filename);
});

if (!window.Clipboard) {
   var pasteCatcher = document.createElement("div");
    
   // Firefox вставляет все изображения в элементы с contenteditable
   pasteCatcher.setAttribute("contenteditable", "");
    
   pasteCatcher.style.display = "none";
   document.body.appendChild(pasteCatcher);
 
   // элемент должен быть в фокусе
   pasteCatcher.focus();
   document.addEventListener("click", function() { pasteCatcher.focus(); });
} 
// добавляем обработчик событию
window.addEventListener("paste", pasteHandler);
 
function pasteHandler(e) {
// если поддерживается event.clipboardData (Chrome)
      if (e.clipboardData) {
      // получаем все содержимое буфера
      var items = e.clipboardData.items;
      if (items) {
         // находим изображение
         for (var i = 0; i < items.length; i++) {
            if (items[i].type.indexOf("image") !== -1) {
               // представляем изображение в виде файла
               var blob = items[i].getAsFile();
			   document.getElementById('postform-img').files = e.clipboardData.files
               filename = document.getElementById('postform-img').files[0].name
               //$("#img-label a").html(filename)
               // создаем временный урл объекта
               var URLObj = window.URL || window.webkitURL;
               var source = URLObj.createObjectURL(blob);
               $("#img-label a").html(source)
               // добавляем картинку в DOM
               //createImage(source);
            }
         }
      }
   // для Firefox проверяем элемент с атрибутом contenteditable
   } else {      
      setTimeout(checkInput, 1);
   }
}
 
function checkInput() {
    var child = pasteCatcher.childNodes[0];   
   pasteCatcher.innerHTML = "";    
   if (child) {
// если пользователь вставил изображение – создаем изображение
      if (child.tagName === "IMG") {
         createImage(child.src);
      }
   }
}
 
function createImage(source) {
   var pastedImage = new Image();
   pastedImage.onload = function() {
	   // вставить в DOM
   }
   pastedImage.src = source;
   
}
var timeOut;
function goUp() {
   var top = Math.max(document.body.scrollTop,document.documentElement.scrollTop);
   if(top > 0) {
      window.scrollBy(0,-100);
      timeOut = setTimeout('goUp()', 5);
   } else clearTimeout(timeOut);
}
$('.top').click(function () {
   goUp()
})