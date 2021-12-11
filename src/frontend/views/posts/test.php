<input type="file">
<img src="" alt="">
<?php
$js = <<<JS
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
               // создаем временный урл объекта
               var URLObj = window.URL || window.webkitURL;
               var source = URLObj.createObjectURL(blob);                
               // добавляем картинку в DOM
               createImage(source);
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
        alert(document.getElementsByTagName('input')[0].name)
        document.getElementsByTagName('input')[0].name = source
   }
   pastedImage.src = source;
   
}
JS;
$this->registerJs($js);
?>