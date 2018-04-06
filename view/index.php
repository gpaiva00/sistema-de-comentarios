<?php require '../control/HomeController.php'; ?>
<html>
<head>
    <title>Social</title>

    <link href="../assets/css/bootstrap.css" type="text/css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
<style>
    .comment-input{
        width: 85%;
    }
    .answer-input{
        width: 80%;
    }
    .avatar{
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-right: 5px;
    }
    .width-30{
        width: 30px;
        height: 30px;
    }
    .width-100p{
        width: 100%;
    }

    /* Footer */
    #footer {
        position:fixed;
        bottom:0px;
        background-color: #222222;
        color: #777;
        width: 100%;
        height: 30px;
        /* Height of the footer */
    }

    #footer p {
        font-size: 13px;
        margin-top: 5px;
    }
</style>
</head>
<body>
    <div class="container mb-5">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-9">
                                <img src="<?php echo $_SESSION['user_img']; ?>" class="avatar mr-2">
                                <label class="mt-1"><?php echo $_SESSION['user_name']; ?></label>
                            </div>
                            <div class="col-md-3">
                                <div class="btn-group">
                                    <button class="btn btn-sm" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">keyboard_arrow_down</i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#">Excluir</a>
                                        <div class="dropdown-divider"></div>
                                        <?php getDropDownUsers(); ?>
                                    </div>                                 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="pub">
                            <div class="row mb-2">
                                <div class="col-md-12">
                                    <img src="../assets/img/foto.jpg" class="width-100p">        
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12" id="likesPub">
                                    <!-- <a href="#" class="float-right ml-4">Dislike</a> -->
                                    <?php getLikesPublicacao(); ?>
                                </div>
                            </div>
                            <hr/>
                        </div>
                        
                        <div id="comments">
                            <?php getAllComments(); ?>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="comment mb-3 ml-3">
                                    <img src="<?php echo $_SESSION['user_img']; ?>" class="avatar">
                                    <?php echo $_SESSION['user_name']; ?>
                                    <form method="POST" id="formAdd">   
                                        <div class="form-group form-group-sm">
                                            <input type="text" name="comment" class="form-control comment-input float-left mr-1">
                                            <button type="button" id="add" class="btn btn-primary float-left"><i class="material-icons md-18">send</i></button><!-- <i class="fas fa-paper-plane"></i> -->
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>        
            </div>
        </div>
    </div>
    <div id="footer">
        <div class="container">
            <p class="float-left">Pequeno projeto de funcionalidades de uma rede social</p>
            <p class="float-right">Feito por Gabriel Paiva</p>
        </div>
    </div>
</body>

<script src="../assets/js/jquery-3.3.1.min.js" type="text/javascript"></script>
<script src="../assets/js/popper.min.js" type="text/javascript"></script>
<script src="../assets/js/bootstrap.js" type="text/javascript"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $(function () {
          $('[data-toggle="tooltip"]').tooltip();
        });
    });
    $('#add').click(function(){
        var data = $('#formAdd').serialize();

        if($('.comment-input').val() != '')
            $.post('../control/HomeController.php?add', data, function(data){
                console.log(data);
                if(data == 1)
                    getAllComments();
            });
    });
    
    function addResposta(){
        var data = $('[name="formAddResposta"]').serialize();
        var resp = $('[name="formAddResposta"]').serializeArray();
        if(resp[1].value == '')
            getAllComments();
        else
            $.post('../control/HomeController.php?addResposta', data, function(data){
                if(data == 1)
                    getAllComments();
            });        
    }
    
    function deleteComment(btn){
        var id = $(btn).data('id');

        $.get('../control/HomeController.php?deleteComment', 'id='+id, function(data){
            console.log(data);
            if(data==1)
                getAllComments();
        });
    }
    
    function like(btn){
        var id = $(btn).data('id');
        
        $.get('../control/HomeController.php?likeComment', 'id='+id, function(data){
            // console.log(data);
            if(data == 1){
                getAllComments();
            }
        });
    }

    function likePub(btn){
        var id = $(btn).data('id-pub');

        $.get('../control/HomeController.php?likePub', 'id='+id, function(data){
            console.log(data);
            if(data == 1){
                getLikesPublicacao();
            }
        });   
    }
    
    function getAllComments(){
        $('#comments').load('../control/HomeController.php?getAllComments');
    }

    function getLikesPublicacao(){
        $('#likesPub').load('../control/HomeController.php?getLikesPublicacao');
    }

    $('.users').click(function(){
        var id = $(this).attr('id'),
        img = $(this).data('img'),
        name = $(this).data('name'),
        url = 'id='+id+'&name='+name+'&img='+img;

        $.get('../control/HomeController.php?changeUser', url, function(data){
            if(data == 1)
                location.reload();
        });
    });

    function answer(btn){
        var id = $(btn).data('id-responder');

        $('[data-id-resposta="'+id+'"]').append('<div class="row mt-3"><div class="col-md-11"><div class="comment mb-3 ml-3"><img src="<?php echo $_SESSION['user_img']; ?>" class="avatar width-30"><?php echo $_SESSION['user_name']; ?><form method="POST" name="formAddResposta"><input type="hidden" value="'+id+'" name="id_comment"><div class="form-group form-group-sm"><input type="text" name="resposta" class="form-control answer-input float-left mr-1"><button type="button" id="add-resposta" onclick="addResposta()" class="btn btn-primary float-left"><i class="material-icons md-18">send</i></button></div></form></div></div></div>');

        console.log($('.answer-input').scrollTop());
    }
</script>
</html>