<?php
session_start();

require_once '../../../hardcode.php';

if (!isset($_SESSION[$uid . 'FreiChatX_init']))
    exit;
?>
<!DOCTYPE html>
<html>
    <head>
        <title>

        </title>
        <script src="../../jquery/js/jquery.1.8.3.js"></script>
        <script src="../lib/js/bootstrap.min.js"></script>
        <script src="../lib/js/bootstrap-fileupload.min.js"></script>

        <link href="../lib/css/bootstrap.min.css" rel="stylesheet" />
        <link href="../lib/css/bootstrap-fileupload.min.css" rel="stylesheet" />

        <style>
            .upload_ctrl {
                text-align: center;
                margin: 0 auto;
                margin-bottom: 4px;
                padding: 0;
                padding-top:8px;
                padding-bottom: 4px;
            }

            .text-info {
                color: #3a87ad;
            }
            .text-error {
                color: #b94a48;
            }
            .text-success {
                color: #468847;
            }
            .notice {
                padding: 2px;
                width: 80%;
                border: 1px solid #bba;
                text-align: center;
                margin: 0 auto;
                background: white;
                border-radius: 3px;
            }
        </style>
    </head>
    <body>
        <div class="frei_upload_border">
            <form id="send_form" name="upload" action="upload.php" method="post" enctype="multipart/form-data">

                <!--            <label for="file">choose file to send</label><br/><br/>-->

                <div class="upload_ctrl well fileupload fileupload-new" data-provides="fileupload">
                    <div class="fileupload-new thumbnail" style="width: 80px; height: 80px;"><img src="http://www.placehold.it/80x80/EFEFEF/AAAAAA" /></div>
                    <div class="fileupload-preview fileupload-exists thumbnail" style="width: 80px; height: 80px;"></div>
                    <span class="btn btn-file"><span id="select_file" class="fileupload-new"></span><span id="change" class="fileupload-exists"></span><input id="send_input" type="file" name="file"/></span>
                    <a href="#" class="btn fileupload-exists" id="file_remove" data-dismiss="fileupload"></a>
                    <div class="text-info notice" id="notice"></div>

                </div>

                <button id="send_file" class ="btn btn-large btn-block"></button>





                <input id ="fromid" type="hidden" name="fromid"/>
                <input id="fromname" type="hidden" name="fromname"/>
                <input id="toid" type="hidden" name="toid"/>
                <input id="toname" type="hidden" name="toname"/>
                <input id="mode" type="hidden" name="mode"/>



            </form>
        </div>
    </body>
</html>
<script>

    $(document).ready(function() {

        $('#send_input').change(function() {

            if ($.trim($(this).val()) !== "") {
                $('#notice').html(opener.freidefines.TRANS.FILE.inotice2).addClass("text-success").removeClass("text-info").removeClass("text-error");
            }
        });

        $('#send_file').click(function() {

            if ($.trim($('#send_input').val()) === "") {
                $('#notice').html(opener.freidefines.TRANS.FILE.inotice3).addClass("text-error").removeClass("text-info").removeClass("text-success");
                return false;
            } else {

                $('#send_form').submit();
            }
        });
    });

    function freiVal(name, value)
    {
        var element = document.getElementById(name);

        if (element != null)
        {
            element.value = value;
        }
        else
        {
            alert("element does not exists");
        }
    }

    if (opener.FreiChat.is_chatroom) {
        freiVal("mode", 'chatroom');
    } else {
        freiVal("mode", 'private_chat');
    }

    freiVal("toid", opener.FreiChat.toid);
    freiVal("fromid", opener.freidefines.GEN.reidfrom);
    freiVal("toname", opener.FreiChat.touser);
    freiVal("fromname", opener.freidefines.GEN.fromname);

    document.getElementById('send_file').innerHTML = document.title = opener.freidefines.TRANS.FILE.title;
    document.getElementById('select_file').innerHTML = opener.freidefines.TRANS.FILE.select;
    document.getElementById('file_remove').innerHTML = opener.freidefines.TRANS.FILE.remove;
    document.getElementById('notice').innerHTML = opener.freidefines.TRANS.FILE.inotice;
    document.getElementById('change').innerHTML = opener.freidefines.TRANS.FILE.change;

</script>
