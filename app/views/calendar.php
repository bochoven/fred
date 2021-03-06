<?$this->view('partials/head')?>

    <div class="container">
      <div class="row">
        <div class="span4">
          <h2><i class="icon-calendar"></i> Calendar</h2>
          <p>Click on a reservation to see the details.</p>
        </div>
        <div class="span8">
          <div id="calendar"></div>
        </div>
      </div><!--/row-->

      <hr>

<div class="modal hide" data-update="" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Reservation</h3>
  </div>
  <div class="modal-body">
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <button id="save-changes" class="btn btn-primary">Save changes</button>
  </div>
</div>

<?$this->view('partials/foot')?>

<script src="<?=WEB_FOLDER?>assets/js/fullcalendar.min.js"></script>
<script type="text/javascript">

  $('#calendar').fullCalendar({
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'prevYear,nextYear'
      },
      editable: false,
      events: "<?=url('user/json_events')?>",
      eventRender: function(event, element) {
        $(element).data('icu', 1) //.data('id', event.id);
      }
    });

</script>

  </body>
</html>
