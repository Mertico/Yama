<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Яма</title>
    <!--<script src="http://api-maps.yandex.ru/2.1/?lang=ru-RU&key=ANgTdVcBAAAAlPAOYAIAh1mQRFOp4jTEirfE1TveLDyBD3cAAAAAAAAAAABBAkpTxoQtFBH3GPYQ_CpqgWxEBA==" type="text/javascript"></script> -->
    <script src="http://api-maps.yandex.ru/2.1/?lang=ru-RU" type="text/javascript"></script>
    <script src="http://yandex.st/jquery/2.1.0/jquery.min.js" type="text/javascript"></script>
    <script src="js/map.js" type="text/javascript"></script>
    <script src="js/click.js" type="text/javascript"></script>
	<script type="text/javascript">

  $(function(){
      var wrapper = $( ".file_upload" ),
          inp = wrapper.find( "input" ),
          btn = wrapper.find( "button" ),
          lbl = wrapper.find( "div" );

      btn.focus(function(){
          inp.focus()
      });
      // Crutches for the :focus style:
      inp.focus(function(){
          wrapper.addClass( "focus" );
      }).blur(function(){
          wrapper.removeClass( "focus" );
      });

      var file_api = ( window.File && window.FileReader && window.FileList && window.Blob ) ? true : false;

      inp.change(function(){
          var file_name;
          if( file_api && inp[ 0 ].files[ 0 ] )
              file_name = inp[ 0 ].files[ 0 ].name;
          else
              file_name = inp.val().replace( "C:\\fakepath\\", '' );

          if( ! file_name.length )
              return;

          if( lbl.is( ":visible" ) ){
              lbl.text( file_name );
              btn.text( "Выбрать" );
          }else
              btn.text( file_name );
      }).change();

  });
  $( window ).resize(function(){
      $( ".file_upload input" ).triggerHandler( "change" );
  });


	var map_click_load = 0;
	setInterval( function() {
	if(document.getElementById('modal-toggle').checked==true)
		if(map_click_load++ == 0) ymaps.ready(init_click)
	} , 1000)
	</script>
  </head>
  <link href="css/stylesheet.css" rel="stylesheet">
  <link href="css/modalstyle.css" rel="stylesheet">
  <body>
    <header>

      <a href="#home"><img src="img/logo.png" alt="LOGO"></a>

      <a class="pit">
      <div class="modal-container">
      <input id="modal-toggle" type="checkbox">
      Добавить яму
      <div class="modal-backdrop">
        <div class="modal-content">
          <label class="modal-close" for="modal-toggle">x</label>
          <div class="admin_form"><h2>Добавление ямы</h2>
          <form action="AddMark.php" method="post" enctype="multipart/form-data">
            <input type="text" placeholder="Введите адрес" class="add_adress-textbox" id="add_adress-textbox" name="address">
            <br />
            <textarea placeholder="Описание" name="about"></textarea>
            <br />

            <div class="file_upload">
                <button type="button">Открыть</button>
                <div>Выберите картинку</div>
                <input type="file" name="image_field" size="32">
            </div>
            <br />
            <input type="hidden" id="coords" name="coords">
            <div id="map_click" style="height: 20rem; width: 100%;"></div>

            <input type="submit" value="Добавить" class="add-button" name="Submit">
            <br />
          </form>
          </div>
        </div>
      </div>
      </div>
      </a>

      <a href="#about">О нас</a><span><b>&middot;</b></span>
      <a href="#pit">Добавления</a><span><b>&middot;</b></span>
      <a href="#mapid">Карта ям</a>

    </header>
    <section id="home">
      <div class="h1_home-wrapper">
        <h1><div class="ulyanovsk-h1">Ульяновские</div> дорожные&nbsp;&nbsp;ямы</h1>
        <p>
          Ямы на дорогах - это прямое нарушение закона. Собственники должны следить за состоянием дорожного полотна, но они не всегда выполняют свои обязанности. Наш проект создан для того, чтобы вы могли контролировать работу дорожных служб и добиваться ремонта ям в нашем городе.
        </p>
      </div>
      <div class="h2_home-wrapper">
      <h2 id="mapid">Карта&nbsp;&nbsp;дорожных&nbsp;&nbsp;ям&nbsp;&nbsp;города</h2>
      <div class="map-wrapper" id="map">

      </div>
      <!--<div class="add_new_pit-block-wrapper">
      <div class="add_new_pit-block">
        <div onclick="document.getElementById('modal-toggle').checked=true" class="modal-container-map">
          <button>Добавить яму</button>
        </div>
        <p>На карте отсутствует яма? <br />Добавь ее в нашу базу данных, просто кликнув <br />по кнопке справа - поддержи наш проект!
          </p>
      </div>
      </div>-->
      </div>
    </section>
    <section id="pit">
      <h1>Последние добавления:</h1>

<? require_once('LastMark.php'); ?>

       <table cellspacing="0">
  <tr>
    <td colspan="4" rowspan="2" class="main event">
        <div class="img_block">
            <div class="over_block" style="background: url('img_pit/pit_<?=$array[0][0]?>.jpg') center center; background-size: cover;"></div>
            <a onclick="OpenMark(<?=$array[0][0]?>)" href="#mapid"><span><p><?=date('m.d.Y H:i', strtotime($array[0][2]))?></p>
            <p><?=$array[0][5]?></p></span></a>
    </div>
    </td>
    <td colspan="5" class="twomain event">
      <div class="img_block">
            <div class="over_block" style="background: url('img_pit/pit_<?=$array[1][0]?>.jpg') center center; background-size: cover;"></div>
            <a onclick="OpenMark(<?=$array[1][0]?>)" href="#mapid"><span><p><?=date('m.d.Y H:i', strtotime($array[1][2]))?></p>
            <p><?=$array[1][5]?></p></span></a>
    </div></td>
    <td colspan="2" class="threemain event"><div class="img_block">
            <div class="over_block" style="background: url('img_pit/pit_<?=$array[2][0]?>.jpg') center center; background-size: cover;"></div>
            <a onclick="OpenMark(<?=$array[2][0]?>)" href="#mapid"><span><p><?=date('m.d.Y H:i', strtotime($array[2][2]))?></p>
            <p><?=$array[2][5]?></p></span></a>
    </div></td>
  </tr>
  <tr>
    <td colspan="3" class="oneless event"><div class="img_block">
            <div class="over_block" style="background: url('img_pit/pit_<?=$array[3][0]?>.jpg') center center; background-size: cover;"></div>
            <a onclick="OpenMark(<?=$array[3][0]?>)" href="#mapid"><span><p><?=date('m.d.Y H:i', strtotime($array[3][2]))?></p>
            <p><?=$array[3][5]?></p></span></a>
    </div></td>
    <td colspan="4" class="twoless event"><div class="img_block">
            <div class="over_block" style="background: url('img_pit/pit_<?=$array[4][0]?>.jpg') center center; background-size: cover;"></div>
            <a onclick="OpenMark(<?=$array[4][0]?>)" href="#mapid"><span><p><?=date('m.d.Y H:i', strtotime($array[4][2]))?></p>
            <p><?=$array[4][5]?></p></span></a>
    </div></td>
  </tr>
      </table>
      <div class="repeater_uzors_black"></div>
    </section>
    <section id="about">
      <h1>Данный проект был подготовлен</h1>



      <div class="infoblocks-wrapper">
       <div class="personal-infoblock_left">
         <div class="float-left" ></div>
         <p>
          Пестряков Александр Сергеевич<br />

          Студент УлГТУ, 2 курс, ФИСТ, гр.ИСТбд-22
         <br /><br />
          Специализация: back-end
         </p>
       </div>
       <hr />
       <div class="personal-infoblock_right">
         <div class="float-right"></div>
         <p>
          Шигабутдинова Роза Шамилевна<br />

          Студентка УлГТУ, 2 курс, ФИСТ, гр.ИСТбд-22
          <br /><br />
          Специализация: front-end
         </p>
       </div>
       <hr />
       <div class="personal-infoblock_left">
         <div class="float-left second"></div>
         <p>
          Алиякберова Алина Наилевна<br />

          Студентка УлГТУ, 2 курс, ФИСТ, гр.ИСТбд-22
         <br /><br />
          Специализация: дизайн
         </p>
       </div>
      </div>
      <footer>
        <div class="text-in-footer">
        &copy; 2016 | УльЯма - информационный сайт о дефектах дорожного покрытия города. Разработан студентами УлГТУ.
        </div>
      </footer>
    </section>
  </body>
</html>
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700&subset=latin,cyrillic" rel="stylesheet" type="text/css">
<script src="http://localhost:35729/livereload.js"></script>
