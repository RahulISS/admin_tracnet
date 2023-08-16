    <!-- Bootstrap JS -->
    <script src="{{ asset('backend/assets/js/bootstrap.bundle.min.js') }}"></script>
	<!--plugins-->
	<script src="{{ asset('backend/assets/js/jquery.min.js')}}"></script>
    <script src="{{ asset('backend/assets/plugins/simplebar/js/simplebar.min.js')}}"></script>
    <script src="{{ asset('backend/assets/plugins/metismenu/js/metisMenu.min.js')}}"></script>
    <script src="{{ asset('backend/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js')}}"></script>
    <script src="{{ asset('backend/assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js')}}"></script>
    <script src="{{ asset('backend/assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
    <script src="{{ asset('backend/assets/plugins/chartjs/js/Chart.min.js')}}"></script>
    <script src="{{ asset('backend/assets/plugins/chartjs/js/Chart.extension.js')}}"></script>
    <script src="{{ asset('backend/assets/plugins/sparkline-charts/jquery.sparkline.min.js')}}"></script>

	<!--notification js -->
	<script src="{{ asset('backend/assets/plugins/notifications/js/lobibox.min.js') }}"></script>
	<script src="{{ asset('backend/assets/plugins/notifications/js/notifications.min.js') }}"></script>
	<script src="{{ asset('backend/assets/plugins/notifications/js/notification-custom-script.js') }}"></script>
	<script src="{{ asset('backend/assets/js/index3.js') }}"></script>

	<script src="{{ asset('backend/assets/js/app.js') }}"></script>
	<script src="{{ asset('backend/assets/plugins/select2/js/select2.min.js') }}"></script>
	<script src="{{ asset('backend/assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('backend/assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('backend/assets/plugins/bootstrap-material-datetimepicker/js/moment.min.js') }}"></script>
	<script src="{{ asset('backend/assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.min.js') }}"></script>
    
	<!--app JS-->
	<script>

        $(document).ready(function () {
            // $('.cart-arrow-down').click(function () { alert();
            //     $(this).next().next().slideToggle('show');
            // });
        });
    </script>
	<script>
		$(document).ready(function() {
			$('#tablefilter').DataTable();
		  });
	</script>
	<script language="JavaScript" type="text/javascript">
        $(document).ready(function(){
            $("a.delete").click(function(e){
                if(!confirm('Are you sure! want to delete?')){
                    e.preventDefault();
                    return false;
                }
                return true;
            });
        });
    </script>
    <script>
        $(document).ready(function(){
            $('.multiple-select').select2({
                theme: 'bootstrap4',
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
                placeholder: $(this).data('placeholder'),
                allowClear: Boolean($(this).data('allow-clear')),
            });
        });
        $('#reset-btn').click(function(){
            $('form')[0].reset();
        });

    </script>
      @if(\Session::get('success'))
    <script>
        $(document).ready(function(){
            Lobibox.notify('success', {
                pauseDelayOnHover: true,
                size: 'mini',
                rounded: true,
                icon: 'bx bx-check-circle',
                delayIndicator: false,
                continueDelayOnInactiveTab: false,
                position: 'top right',
                msg: '{{ \Session::get("success") }}'
            });
        });
    </script>
    @endif
    {{ \Session::forget('success') }}
    @if(\Session::get('error'))
    <script>
        $(document).ready(function(){
            Lobibox.notify('error', {
                pauseDelayOnHover: true,
                size: 'mini',
                rounded: true,
                delayIndicator: false,
                icon: 'bx bx-x-circle',
                continueDelayOnInactiveTab: false,
                position: 'top right',
                msg: '{{ \Session::get("error") }}'
            });
        });
        $('.multiple-select').select2({
            theme: 'bootstrap4',
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            allowClear: Boolean($(this).data('allow-clear')),
        });
    </script>
  
    @endif
