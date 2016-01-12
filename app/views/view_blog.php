<?php
  $_SESSION['titlename'] = $_SESSION['FIO'];
  $rowset = null;
  if(isset($_REQUEST['id'])){
    $cnn = new Cnn();
    $rowset = $cnn->post_show();
  }
  Fn::debugToLog("rowset", json_encode($rowset));
?>
<script type="text/javascript">
$(document).ready(function() {
	
  // свойства диалогового окна
  $("#error_dialog").dialog({
    autoOpen: false, modal: true, width: 600,
    buttons: [{text: "ok", click: function () { $(this).dialog("close");}}],
    show: {effect: "clip", duration: 200},
    hide: {effect: "clip", duration: 200}
  });


  // обработка нажатия на "Опубликовать"
  $("#btn_public").click(function() {
    
    // проверка: если пользователь не ввел заголовок поста - появится соответствующее сообщение об ошибке
    if($("#post_title").val().length < 1) {
      $("#error_dialog_text").html("Ошибка при добавлении поста!<br>Пожалуйста, введите заголовок поста!");
      $("#error_dialog").dialog("open");
      return;
    }
    
    // проверка: если пользователь не ввел содержимое поста - появится соответствующее сообщение об ошибке
    if($("#post_description").val().length < 1) {
      $("#error_dialog_text").html("Ошибка при добавлении поста!<br>Пожалуйста, введите содержимое поста!");
      $("#error_dialog").dialog("open");
      return;
    }

    // если id не задан, oper = add
    id = $(this).parent().parent().parent().attr('id');
    if (id == '') {oper = 'add'}else{oper = 'edit'};
      console.log(id == '');
      // if (oper == 'edit') {
      //   $("#"+id).find(".title").html($("#post_title").val());
      //   $("#"+id).find(".description").html($("#post_description").val());
      // }

      $.post("/engine/post_"+oper, {
          username: '<?php echo $_REQUEST['id']; ?>',
          postid: id,
          title: $("#post_title").val(),
          description: $("#post_description").val()
        }, function(data){
        console.log(data);
        if (data.success){
          console.log("postID = "+data.postid);
          if(oper == 'add'){
            div = $("#post_template").clone();
            $(div).removeClass("hide");
            $(div).attr('id',data.postid);
            $(div).find('#template_title').html(data.title).attr('id','');
            $(div).find('#template_description').html(data.description).attr('id','');
            $(div).find('#template_dt_create').html("Дата публикации: " + data.dt_create).attr('id','');
            $(div).find('#template_dt_mode').html("Дата изменения: " + data.dt_mode).attr('id','');
            $("#posts").prepend(div);
            // div.id = data.postid;
            console.log(data.postid);
          }
      
            $("#error_dialog_text").html(data.message);
            $(".ui-widget-header").css({background:"#93E68D"});
            $("#error_dialog").dialog("open");
            $("#post_description").val("");
            $("#post_title").val("");
          }else{
            $("#error_dialog_text").html("Ошибка! " + data.message);
            $("#error_dialog").dialog("open");
          }
      });
});

btn_edit = function(el){
  console.log(el, $(this));
  console.log(el, $(this).parent());
  console.log(el, $(this).parent().parent());
  console.log(el, $(this).parent().parent().parent());
  console.log(el, $(this).parent().parent().parent().parent());
  id = $(this).parent().parent().parent().parent().attr('id');
  console.log(id);
    $("#post_title").val($("#"+id).find(".title").html());
    $("#post_description").html($("#"+id).find(".description").html());
    $("#btn_public").html("Сохранить изменения");
    window.scroll(200,200);
    $("#post_title").focus();

}

// обработка событий на кнопках в постах
$("#posts button").click(function(e){
  id = $(this).parent().parent().parent().parent().attr('id');
      console.log(id, $(this).attr('oper'));
return;
  if($(this).attr('oper') == "edit"){
    $("#post_title").val($("#"+id).find(".title").html());
    $("#post_description").html($("#"+id).find(".description").html());
    $("#btn_public").html("Сохранить изменения");
    window.scroll(200,200);
    $("#post_title").focus();
    return;
  }

  if($(this).attr('oper') == "del"){
    $("#"+id).remove();
  }
  
  $.post("/engine/post_"+$(this).attr('oper'), {
   username: '<?php echo $_REQUEST['id']; ?>', 
   postid: id, 
 }, function(data){ // функция - ответ от сервера
   console.log(data);
   if (data.success){
      $("#error_dialog_text").html(data.message);
      $("#error_dialog").dialog("open");
   }else{
     $("#error_dialog_text").html("Ошибка! " + data.message);
      $("#error_dialog").dialog("open");
   }
 });
});

// скрытие хидера при скролле страницы
window.onscroll = function() {
  scrolled = window.pageYOffset || document.documentElement.scrollTop;
  if( scrolled > 45){
    $("#main_header").hide(400);
  }else{
    $("#main_header").show(400);
  }
}

// репост
repost = function(postid){
  $.post("/engine/post_copy", {postid: postid}, function(data){
      console.log(data);
       if (data.success){
          $("#error_dialog_text").html(data.message);
          $("#error_dialog").dialog("open");
       }else{
          $("#error_dialog_text").html("Ошибка! " + data.message);
          $("#error_dialog").dialog("open");
       }
  });
}

});
</script>


<div class="container-fluid" id="user_block">
    <div class="block-ava">
      <img src="/image/Under000.jpg" style="width:200px;height:150px" class="img-thumbnail">
    </div>
    <div class="block-user-info">
      <h2>Егор Миргородский</h2>
      <p>Здесь будет статус...</p>
      <p>
      4 публикаций |
      12 подписчиков |
      14 подписок</p>
  </div>
</div>



<!-- Если вы находитесь не на своей странице и авторизованы - вывести форму опубликации постов -->
<?php if($_SESSION['UserName'] == $_REQUEST['id'] && $_SESSION['access'] == true){?>
<div class="container post_input" id="">
  <div class="form-group form-group-lg">
    <div id="forinput"><a class="story-img" href="#"><img src="/image/Under000.jpg" style="width:70px;height:50px" class="img-circle"></a></div>
    <div class="col-sm-10">
      <input class="form-control" type="text" id="post_title" placeholder="Введите заголовок">
      <textarea class="form-control mt5" rows="5" id="post_description" placeholder="Введите содержание"></textarea>
      <button type="button" class="form-control btn btn-info mt5" id="btn_public">Опубликовать</button>
    </div>
  </div>
</div>
<?php
}
?>
<!--<div class="container">
  <div class="row">
    <div class="col-md-12"> 
      <div class="panel">-->
        <div class="panel-body" id="posts">
<?php 
  if(is_null($rowset)) return;
  foreach ($rowset as $row) {
?>
		  <div class="row" id="<?php echo $row['PostID'];?>">
            <br>
            <div class="col-md-2 col-sm-3 text-center">
              <a class="story-img" href="#"><img src="/image/Under000.jpg" style="width:150px;height:100px" class=""></a>
            </div>
            <div class="col-md-10 col-sm-9">
              <h3 class="title"><?php echo $row['Title'];?></h3>
              <div class="row">
                <div class="col-xs-9">
                  <p class="description"><?php echo $row['Description'];?></p>
                  <?php if($_REQUEST['id'] == $_SESSION['UserName']){ ?>
                  <button type="button" class="btn btn-info btn-right" data_id="<?php echo $row['PostID'];?>" onclick="btn_edit(this);">Редактировать</button>
                  <button type="button" class="btn btn-info btn-right" data_id="<?php echo $row['PostID'];?>" onclick="btn_del(this);">Удалить</button>
                  <?php }?>
                  <ul class="list-inline">
                    <li>Дата публикации: <?php echo $row['DT_create']; ?></li>
                    <br><li>Дата изменения: <?php echo $row['DT_mode']; ?></li><br>
                    <!-- <li><a href="#"><i class="glyphicon glyphicon-share"></i> 5 репостов</a></li><br> -->

                    <?php if($_SESSION['access'] == true && $_REQUEST['id'] != $_SESSION['UserName']){?>
                    <li><a href="javascript:repost(<?php echo $row['PostID'];?>);"><i class="glyphicon glyphicon-share-alt"></i> Поделиться</a></li>
                    <?php } ?>
                  </ul>
                </div>
                <div class="col-xs-3"></div>
              </div>
              <br><br>
            </div>
          </div>
          <hr>
<?php
}
?>    

<div class="hide row" id="post_template">
  <br>
  <div class="col-md-2 col-sm-3 text-center">
    <a class="story-img" href="#"><img src="/image/Under000.jpg" style="width:150px;height:100px" class=""></a>
  </div>
  <div class="col-md-10 col-sm-9">
    <h3 class="title" id="template_title"></h3>
    <div class="row">
      <div class="col-xs-9">
        <p class="description" id="template_description"></p>
        <button type="button" class="btn btn-info btn-right" data_id="" onclick="btn_edit(this);">Редактировать</button>
        <button type="button" class="btn btn-info btn-right" data_id="" onclick="btn_del(this);">Удалить</button>
        <ul class="list-inline"><li id="template_dt_create">Дата публикации: </li><br><li id="template_dt_mode">Дата изменения: </li></ul>
      </div>
      <div class="col-xs-3"></div>
    </div>
    <br><br>
  </div>
<hr>
</div>
<!-- <h3 style="text-align:center;" id="empty_posts">У Вас нет ни одного поста...</h3> -->
        </div>
<!--      </div>                                            
   	</div>
  </div>
</div>                                                                                -->
<hr>

<div class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-dialog-buttons" 
    style="position: relative; left:50%; top:15%; margin-left:-255px; display: block; "
    tabindex="-1" id="error_dialog">
    <h3 id="error_dialog_text"></h3>
</div>





<style>
#user_block {
  background: url(/image/background.jpg);
  background-size: cover;
}

.navbar-form input, .form-inline input {
  width:auto;
}

body {
  padding-top:30px;
  /*background: #FAFAFA*/
}

footer {
  margin-top:40px;
  padding-top:40px;
  padding-bottom:40px;
  background-color:#ededed;
}


#masthead {
  min-height:199px;
}

#masthead h1 {
  font-size: 55px;
  line-height: 1;
  margin-top:50px;
}

#masthead .well {
  margin-top:31px;
  min-height:127px;
}

.navbar.affix {
  position:fixed;
  top:0;
  width:100%;
}

.story-img {
  margin-top:25%;
  display:block;
}

a,a:hover {
  color:#223344;
  text-decoration:none;
}

.icon-bar {
  background-color:#fff;
}

@media screen and (min-width: 768px) {
  #masthead h1 {
    font-size: 80px;
  }
}

.dropdown-menu {
  min-width: 250px;
}

.panel {
  border-color:transparent;
  border-radius:0;
}

.thumbnail {
  margin-bottom:8px;
}

.img-container {
  overflow:hidden;
  height:170px;
}

.img-container img {
  min-width:280px;
  min-height:180px;
  max-width:380px;
  max-height:280px;
}

.txt-container {
  overflow:hidden;
  height:100px;
}

.panel .lead {
  overflow:hidden;
  height:90px;
}

.label-float{
  margin:0 auto;
  position: absolute;
  top: 0;
  z-index: 1;
  width:100%;
  opacity:.9;
  padding:6px;
  color:#fff;
}
.container-fluid{
  background: #FAFAFA;
  height: 250px;
}
#ava{
  display: block;
  margin-top: 45px;
  padding-left: 50px;
}
#name{
  /*margin-top: -6px;*/
  /*padding-right: 530px;*/
}
#sub{
  margin-left: 20px;
}

#smallname{
  font-size: 22px;
  color: #000;
}
#status{
  font-size: 15px;
  font-weight: bold;
  margin-top:-110px;
  margin-left: 300px;
  color:#4b4f54;
}
.count{
  display: inline-block;
  margin-left: 45px;
  margin-top: 8px;
  color: #4b4f54;
  font-size: 16px;
}
#countposts{
  margin-left: 235px; 
}
.navbar-default{
  /*background: #fff;*/
}
#logout{
  font-size: 17px;
  font-weight: bold; 
  color:#125688;
}
a{
  color:#125688;
}
#head{
  color:#125688; 
}
#head:hover{
  color:#223344;
}
#forinput{
float:left;
display: inline-block;
margin-top: -16px;
}

.post_input {
  margin-top: 3em;
}

.block-ava, .block-user-info {
  display:inline-block;
}
</style>