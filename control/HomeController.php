<?php
session_start();
if(empty($_SESSION['user_id'])){
    $_SESSION['user_id'] = 1;
    $_SESSION['user_img'] = '../assets/img/eu.jpg';
    $_SESSION['user_name'] = 'Gabriel';
}

// routes
require 'routes.php';
$likes_pub = 0;

function getAllComments(){
    require 'db-connect.php';
    $all = $pdo->query("SELECT comentarios.*, usuario.id as 'user_id', usuario.nome, usuario.img FROM comentarios INNER JOIN usuario ON usuario.id = comentarios.id_autor WHERE id_publicacao = 1 AND id_comentario = 0");

    $respostas = $pdo->query("SELECT comentarios.*, usuario.id as 'user_id', usuario.nome, usuario.img FROM comentarios INNER JOIN usuario ON usuario.id = comentarios.id_autor WHERE id_publicacao = 1 AND id_comentario > 0");

    $user_id = $_SESSION['user_id'];

    if($all->rowCount() > 0){
        foreach($all as $comment){
            echo '
            <div class="row">
                <div class="col-md-11 comment ml-3">
                    <img src="'.$comment['img'].'" class="avatar width-30">
                    '.$comment['nome'].'
                    ';
                        // excluir
                        if($comment['id_autor'] == $user_id)
                        echo '
                        <button type="button" onclick="deleteComment(this)" class="btn btn-sm deleteComment float-right" data-id="'.$comment['id'].'" data-toggle="tooltip" data-placement="top" title="Excluir comentário"><i class="material-icons">remove_circle</i>
                        </button>';
                        // excluir
                    echo '           
                    <div class="input-group ml-5">
                        <p>'.$comment['texto'].'</p>
                    </div>
                    <div class="col-md-12">
                        <span class="num-likes text-muted">'.$comment['likes'].'</span>
                        <button type="button" onclick="like(this)" class="btn mr-1 like" data-id="'.$comment['id'].'"><i class="material-icons">thumb_up</i></button>

                        <button type="button" class="btn responder" onclick="answer(this)" data-id-responder="'.$comment['id'].'" data-toggle="tooltip" data-placement="top" title="Responder"><i class="material-icons">insert_comment</i></button>                                  
                        <div class="div-respostas ml-4" data-id-resposta="'.$comment['id'].'">';
                    
                            foreach($respostas as $resp){
                                if($resp['id_comentario'] == $comment['id']){
                                    echo '
                                    <div class="row mt-2">
                                        <div class="col-md-11 comment">
                                            <img src="'.$resp['img'].'" class="avatar width-30">
                                            '.$resp['nome'].'
                                            ';
                                                // excluir
                                                if($resp['id_autor'] == $user_id)
                                                echo '<button type="button" onclick="deleteComment(this)" class="btn btn-sm deleteComment float-right" data-id="'.$resp['id'].'" data-toggle="tooltip" data-placement="top" title="Excluir comentário"><i class="material-icons">remove_circle</i>
                                                </button>';
                                                // excluir
                                            echo '           
                                            <div class="input-group ml-5">
                                                <p>'.$resp['texto'].'</p>
                                            </div>
                                            <div class="col-md-12">
                                                <span class="num-likes text-muted">'.$resp['likes'].'</span>
                                                <button type="button" onclick="like(this)" class="btn mr-1 like" data-id="'.$resp['id'].'"><i class="material-icons">thumb_up</i></button>
                                            </div>
                                        </div>
                                    </div><hr/>';
                                }
                            }
                        echo '
                        </div>
                    </div>
                </div>
            </div><hr/>';    
        }
    }else{
        echo '<center>Seja o primeiro a comentar!</center>';
    }
}

function add($post){
    session_start();
    require 'db-connect.php';

    $text = $post['comment'];
    $user_id = $_SESSION['user_id'];

    $pdo->query("INSERT INTO comentarios (texto, id_autor, id_publicacao) VALUES ('$text', $user_id, 1) ");
    echo 1;
}

function addResponse($post){
    session_start();
    require 'db-connect.php';

    $text = $post['resposta'];
    $id_comment = $post['id_comment'];
    $user_id = $_SESSION['user_id'];

    $pdo->query("INSERT INTO comentarios (texto, id_autor, id_comentario, id_publicacao) VALUES ('$text', $user_id, $id_comment, 1) ");    
    echo 1;
}

function likeComment($get){
    session_start();
    require 'db-connect.php';

    $id = $get['id'];
    $user_id = $_SESSION['user_id'];

    $verify = $pdo->query("SELECT id_comentario FROM comentarios_likes WHERE id_autor = $user_id AND id_comentario = $id ");
    
    if($verify->rowCount() > 0)
        $pdo->query("DELETE FROM comentarios_likes WHERE id_comentario = $id AND id_autor = $user_id");
    else
        $pdo->query("INSERT INTO comentarios_likes (id_comentario, id_autor) VALUES 
                    ($id, $user_id)");
    echo 1;
}

function likePublication($get){
    session_start();
    require 'db-connect.php';
    $id = $get['id'];
    $autor = $_SESSION['user_id'];

    $verify = $pdo->query("SELECT id_publicacao FROM publicacao_likes WHERE id_autor = $autor AND id_publicacao = $id ");

    if($verify->rowCount() > 0)
        $pdo->query("DELETE FROM publicacao_likes WHERE id_publicacao = $id AND id_autor = $autor ");
    else
        $pdo->query("INSERT INTO publicacao_likes (id_publicacao, id_autor) VALUES($id, $autor) ");
    
    echo 1;
}

function getLikesPublicacao(){
    require 'db-connect.php';

    $query = $pdo->query("SELECT id, likes FROM publicacao WHERE id = 1");

    foreach($query as $q){
        $like = $q['likes'];
        $id = $q['id'];
    }
    echo '
    <span class="text-muted">'.$like.'</span>
    <button type="button" class="btn btn-default ml-3" onclick="likePub(this)" data-id-pub="'.$id.'"> 
            <i class="material-icons md-18">thumb_up</i>
    </button>';
}

function deleteComment($get){
    require 'db-connect.php';
    $id = $get['id'];
    $pdo->query("DELETE FROM comentarios WHERE id_comentario = $id ");
    $pdo->query("DELETE FROM comentarios WHERE id = $id ");
    echo 1;
}

function changeUser($get){
    session_start();
    $_SESSION['user_id'] = $get['id'];
    $_SESSION['user_name'] = $get['name'];
    $_SESSION['user_img'] = $get['img'];
    
    echo 1;
}

function getDropDownUsers(){
    require 'db-connect.php';
    $users = $pdo->query("SELECT * FROM usuario ");

    foreach ($users as $u) {
        echo '<a class="dropdown-item users" href="#" id="'.$u['id'].'" data-name="'.$u['nome'].'" data-img="'.$u['img'].'">
                <img src="'.$u['img'].'" class="avatar width-30">
                '.$u['nome'].'
            </a>';
    }
}
?>

