<h1 align="center"> image-optimization</h1>
<p align="center">
    <b>Скрипт для оптимизации изображений в формате jpeg и jpg</b>
</p>
<p
    Скрипт пробегает по всем папкам и подпапкам и оптимизирует изображения, путем небольшого уменьшения качества и <b>ресайза</b> изображения 
   <br>
    <code> $all_files = rsearch("./[Путь к вашей папке]/","/^.*\.(jpg|png)$/"); </code>
</p>
<p>
<b align="center">Работает вместе с библиотекой Imagine. </b>
   <br>
  <code> php composer.phar require imagine/imagine </code>
</p>
