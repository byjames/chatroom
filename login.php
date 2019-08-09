<script src="http://libs.baidu.com/jquery/2.1.4/jquery.min.js"></script>
<script>
    $(function () {
        // 注册
        $("#login").click(function () {
            var form = $("#chatfrom").serializeArray();
            form.push({"name": "type", "value": "1"});
            $.ajax({
                type: 'POST',
                url: "chat.php",
                data: form,
                dataType: 'json',
                success: function (result) {
                    var data = result;
                    alert(123);
                    alert(result.msg);
                    if (result.errcode == 0) {
                        window.location.href = window.location.href;
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {

                    /*弹出jqXHR对象的信息*/
                    alert(jqXHR.responseText);
                    alert(jqXHR.status);
                    alert(jqXHR.readyState);
                    alert(jqXHR.statusText);
                    /*弹出其他两个参数的信息*/
                    alert(textStatus);
                    alert(errorThrown);
                },
                beforeSend: function () {
                    //$("#alertActivityBtn").addClass("disabled");
                }
            });
        });
         /*// login
         $("#login").click(function () {
             var form = $("#chatfrom").serializeArray();
              form.push({"name": "type", "value": "2"});
             $.ajax({
                 type: 'POST',
                 url: "user.php",
                 data: form,
                 dataType: 'json',
                 success: function (result) {
                     alert(result.msg);
                     if (result.errcode == 0) {
                         window.location.href = window.location.href;
                     }
                 },
                 beforeSend: function () {
                     //$("#alertActivityBtn").addClass("disabled");
                 }
             });
         });*/
    });
</script>

<div style="margin:0 auto;border:1px solid #000;width:300px;height:100px;margin-top: 300px">
    <form action="chat.php" method="post" id="chatfrom">
        <p>
            <input type="text" name="account"/>
        </p>
        <input type="password" name="paw"/>
        <!--<input type="submit"  data-type=1 id="redc" value="注册"/>-->
        <input type="submit" name="login2" data-type=2 id="login2" value="登录"/>
    </form>
</div>

