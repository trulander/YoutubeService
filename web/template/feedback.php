<div class="modal fade" id="feedback" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="POST">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Новое сообщение</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?/*<div class="form-group">
                    <label for="recipient-name" class="col-form-label">Тема:</label>
                    <input type="text" class="form-control" id="recipient-name">
                </div>*/?>
                <div class="form-group">
                    <label for="message-text" class="col-form-label">Сообщение:</label>
                    <textarea class="form-control" name="message-text" id="message-text"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                <button type="submit" class="btn btn-primary">Отправить</button>
            </div>
      </form>
    </div>
  </div>
</div>
