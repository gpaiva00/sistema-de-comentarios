<?php

if(isset($_GET['getAllComments']))
    getAllComments();
if(isset($_GET['getLikesPublicacao']))
    getLikesPublicacao();
if(isset($_GET['add']))
    add($_POST);
if(isset($_GET['addResposta']))
    addResponse($_POST);
if(isset($_GET['likeComment']))
    likeComment($_GET);
if(isset($_GET['likePub']))
    likePublication($_GET);
if(isset($_GET['deleteComment']))
    deleteComment($_GET);

// users
if(isset($_GET['changeUser']))
    changeUser($_GET);