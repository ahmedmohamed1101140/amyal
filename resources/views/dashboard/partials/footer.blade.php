
<div class="clearfix"></div>

<footer>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="foter-logo">
                    <img src="{{asset("admin_assets/")}}/img/logo-s.png" width="86" height="61">
                </div>
                <div class="copyrights">
                    <p>Copyrights © Amyal 2019</p>
                    <p>Designed & Developed by <a href="{{--http://paladox.com--}}" target="_blank">Paladox corporate</a></p>
                </div>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-12">
                <ul class="horizontal pull-right">
                    <li>
                        <a href="#" target="_blank">
                            <span class="fa fa-facebook "></span>
                        </a>

                    </li>
                    <li>
                        <a href="#" target="_blank">
                            <span class="fa fa-linkedin "></span>
                        </a>

                    </li>
                    <li>
                        <a href="#" target="_blank">
                            <span class="fa fa-youtube-play "></span>
                        </a>

                    </li>
                </ul>
            </div>
        </div>
    </div>

</footer>

<!--modals-->

@yield('modals')



<script src="{{asset("admin_assets/")}}/js/jquery.2.2.3.min.js"></script>
<script src="{{asset("admin_assets/")}}/js/bootstrap.js" type="text/jscript" ></script>
<script src="{{asset("admin_assets/")}}/js/bootsnav.js"></script>
<script src="{{asset("admin_assets/")}}/js/jquery.datetimepicker.full.js"></script>
<script src="{{asset("admin_assets/")}}/js/mdtimepicker.js"></script>
<script src="{{asset("admin_assets/")}}/js/ui.js"></script>

<script src="{{asset("admin_assets/")}}/js/jquery.selectallcheckbox.js"></script>
{{--<script src="{{asset("admin_assets/")}}/js/multi-input.js"></script>--}}
<script src="{{asset("admin_assets/")}}/js/nested-form.js"></script>
<script src="{{asset("admin_assets/")}}/js/bootstrap-toggle.js"></script>



@yield('js')


<script type="text/javascript">
    $(window).on('load',function(){
        $('#squarespaceModal-').modal('show');
    });
</script>

<script>
    $("#checkAll").click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });
</script>
<script>
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove();
        });
    }, 6000);
</script>
</body>
</html>
