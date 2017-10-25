
<div id="dvCountDown" style="display: none">
Your Account is activated You will be redirected after <span id="lblCount"></span>&nbsp;seconds.
</div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript">

$(function () {
        var seconds = 5;
        $("#dvCountDown").show();
        $("#lblCount").html(seconds);
        setInterval(function () {
            seconds--;
            $("#lblCount").html(seconds);
            if (seconds == 0) {
                $("#dvCountDown").hide();
                window.location = "//www.aspsnippets.com/";
            }
        }, 1000);
    
});

</script>