<nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
  <a class="navbar-brand mr-auto mr-lg-0" href="/">На главную</a>



  <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
    
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="/view.php">Список видео</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/topusers.php">Список активных пользователей</a>
      </li>
      <?/*
      <li class="nav-item">
        <a class="nav-link" href="/user/settings.php">Настройки</a>
      </li>
      */?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Настройки</a>
        <div class="dropdown-menu" aria-labelledby="dropdown01">
            <?if($_SESSION['logged_user']['channel'] == $simon_prefix){?>
                <form style="height: 32px;margin: 0;" method="POST" action="/user/settings.php">
                    <button class="dropdown-item" name="change_eliseev" type="submit">Переключить на канал Елисеева</button>
                </form>
            <?}else{?>
                <form style="height: 32px;margin: 0;" method="POST" action="/user/settings.php">
                    <button class="dropdown-item" name="change_simon" type="submit">Переключить на канал Саймона</button>
                </form>
            <?}?>
          <a class="dropdown-item" href="/user/settings.php">Общие настройки</a>
        </div>
      </li>
      <?/*
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Settings</a>
        <div class="dropdown-menu" aria-labelledby="dropdown01">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
      */?>
    </ul>
    <?//print_r($_SESSION)?>
    <div class="form-inline mt-2 mt-md-0">
    <?/*&& (date("d.m.Y H:i:s", strtotime($_SESSION['logged_user']['datareg'])) <= date("d.m.Y H:i:s", strtotime('14.08.2019 09:50')))*/?>
        <? if ($is_allow_feedback){?>
            <?if($_SERVER['SCRIPT_NAME'] == '/feedback.php'){?>
                <button type="button" class="btn btn-primary feedback" data-toggle="modal" data-target="#feedback">Написать сообщение</button>
            <?}else{?>
                <a href="/feedback.php" class="btn btn-primary feedback">
                Внутренний чат 
                <?if($_SESSION['logged_user']['read_internal_message'] != $_SESSION['logged_user']['total_internal_message']){?>
                    <span class="badge badge-light">+1</span>
                <?}?>                
                
                </a>                
            <?}?>
        <?}?>
        
        <? if (isset($_SESSION['logged_user']) ){?>
            <? if ($_SERVER['SCRIPT_NAME'] == '/index.php' || $_SERVER['SCRIPT_NAME'] == '/videodetail.php'){?>
                <div class="btn btn-info loader" title="Таймер обновления комментариев в чате.">20</div>
            <?}?>
            <a href="/user/logout.php" class="btn logout btn-outline-success">Logout</a>
        <?}?>
    </div>
    

    
  </div>
  
  
    <button class="navbar-toggler p-0 border-0" type="button" data-toggle="offcanvas">
    <span class="navbar-toggler-icon"></span>
  </button>
  
</nav>
