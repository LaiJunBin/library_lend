<div class="modal fade" tabindex="-1" role="dialog" id="@yield('modalID')">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                <h4 class="modal-title">@yield('modalTitle')</h4>
            </div>
            <div class="modal-body">
                @yield('modalBody')
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">@yield('modalCloseBtnText','關閉視窗')</button>
                @yield('modalFooter')
            </div>
        </div>
    </div>
</div>
<script>
    $("#@yield('modalID')").modal('toggle');
</script>