<div class="clearfix"></div>

<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="foter-logo">
                    <img src="{{asset("assets/")}}/img/logo-s.png" width="86" height="61">
                </div>
                <div class="copyrights">
                    <p>Copyrights © Amyal 2019</p>
                    <p>Designed & Developed by <a href="http://paladox.com" target="_blank">Paladox corporate</a></p>
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

@yield('modals')


<script src="{{asset("assets/")}}/js/jquery.2.2.3.min.js"></script>
<script src="{{asset("assets/")}}/js/bootstrap.js" type="text/jscript" ></script>
<script src="{{asset("assets/")}}/js/bootsnav.js"></script>
<script src="{{asset("assets/")}}/js/jquery.datetimepicker.full.js"></script>

@yield('js')

<script type="text/javascript">
    $(window).on('load',function(){
        $('#squarespaceModal-').modal('show');
    });
</script>

<script>

    $('#myFormy').on('submit', function(e){
        $('#squarespaceModal-7').modal('show');
        $('#squarespaceModal-5').modal('hide');
        e.preventDefault();
    });
</script>


<script>
    $("#checkAll").click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });
</script>



</body>
</html>
