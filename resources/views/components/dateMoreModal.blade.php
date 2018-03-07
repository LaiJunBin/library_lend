<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="dateMoreModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                <h4 class="modal-title" id="dateMoreModalTitle"></h4>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <th>節次</th>
                        <th>借用單位</th>
                        <th>借用老師</th>
                        <th>借用目的</th>
                    </thead>
                    <tr class="dateMoreTr" id="第1節"></tr>
                    <tr class="dateMoreTr" id="第2節"></tr>
                    <tr class="dateMoreTr" id="第3節"></tr>
                    <tr class="dateMoreTr" id="第4節"></tr>
                    <tr class="dateMoreTr" id="午休時間"></tr>
                    <tr class="dateMoreTr" id="第5節"></tr>
                    <tr class="dateMoreTr" id="第6節"></tr>
                    <tr class="dateMoreTr" id="第7節"></tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">關閉視窗</button>
            </div>
        </div>
    </div>
</div>
<script>
    var data = <?php echo $data;?>;
    $(function () {
        //var data = <?php echo $data;?>;
        $("td a[data-id]").click(function () {
            $(".dateMoreTr").each(function(){
                $(this).html('');
                for(var i = 1; i <=4; i++)
                    $(this).append("<td></td>");
                var id = $(this).attr('id');
                $("#"+id+' td').eq(0).text(id);
            });
            var key = 'd' + $(this).data('id');
            var currentData = data[key];
            $("#dateMoreModalTitle").text(currentData[0].date + '借用紀錄');
            currentData.forEach(function(item){
                var times = item.lendTime.split(',');
                times.forEach(function(time){
                    var currentTime = $('#'+time+' td');
                    currentTime.eq(1).text((item.unit.trim())==''?'無':item.unit);
                    currentTime.eq(2).text(item.teacher);
                    currentTime.eq(3).text(item.purpose);
                });
            });
            $('#dateMoreModal').modal('toggle');
        })
        
    });
</script>