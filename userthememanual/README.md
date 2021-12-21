## Руководство по пользовательским темам
Данное руководство не является исчерпывающим, как минимум потому, что в нём не представленны классы и, соответственно, их роли. Вместо этого, пользователю предоставляется возможность самому исследовать мир идентификаторов и классов, тем более, что большинство современных браузеров предоставляют такую возможность в "Инспекторе" (F12). Здесь же даны выкладки по условиям оформления, обязательным стилям и pull-реквесту.

### Правила оформления темы
Итак, преступим к главной части руководства. Команда разработчиков решила не ограничивать дизайнера-верстальщика в полёте фантазии, это объясняет нестрогость требований. Так или иначе данные выполнение следующие требования являеются обязательми и их соблюдене строго контролируется 

Первое, и по совместительству, самое главное  — это сохранить полностью функционал Twitter23 и создать для пользователя новый опыт использования сайта.

Второе правило обязывает верстальщика внести в свой css-файл код, который указан ниже (см. Обязательный CSS-код).

В-третьих, используйте CSS-сброс стилей. Вы можете использовать любой какой вам удобен.

В-четвёртых, в вашей теме должны быть все цветовые схемы Twitter23 (Фиолетовый, Красный, Голубой, Зелёный, Коричневый (глина), Оранжевый, Розовый и Жёлтый).

**Запрещается как-либо изменять чужие темы**
### Обязательный CSS-код
Вставьте следующий листинг в ваш CSS-файл
```css
#postform-img {
	display: none;
}
button:hover {
	cursor: pointer;
}
```
### Подготовка к написанию темы
Для того, чтобы создать нужную тему оформления необходимо создать несколько дополнительных файлов и внести коррективы в другие. Строго придерживайтесь алгоритма, представленного ниже. Здесь (и дальше) будет использоваться обоначение `{theme}`, вместо него подставляйте название вашей темы.

1. Разверните twitter23 на вашей машине, как это сделать написано в файле README.md
2. Создайте файл `{theme}Asset.php` (`{theme}` с заглавой буквы) в директории /frontend/assets и вставьте в новый файл код из файла ExampleAsset.php в директории руководства
3. Отредактируйте файл /frontend/components/ThemeWidget.php добавив в него несколько строчек кода. Вставьте следующий фрагмент кода после последнего `case` оператора `switch`

                case '{theme}':
                    \frontend\assets\{theme}Asset::register($this->page); return 0;

4. Добавьте в файл /frontend/views/user/settings.php, найдите строку "Тема оформления"  и класс `set_input`, отыщите вызов метода `$form->field()->dropDownList` и вставьте код на следующей строке: `'{theme}' => '{theme}',`
5. Создайте файл {theme}.css в /frontend/web/css

Поздравляю, теперь вы можете выбрать вновь созданную тему и приступать к разработке!

### Подготовка к pull-реквесту
Подробная инструкция как сделать pull-реквест на github'е:
https://techrocks.ru/2020/02/09/first-pull-request-on-github/

### Ждите...
Pull-реквесты принимаются не сразу, для начала нам надо их протестировать и выявить недостатки, в данном случае мы сообщий о них вам.