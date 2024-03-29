<?php

namespace Projet5\controller;

use Projet5\controller\Router;
use Projet5\controller\front\HomepageController;
use Projet5\controller\front\UserController;
use Projet5\controller\front\FrontPostController;
use Projet5\controller\front\MailController;
use Projet5\controller\back\AdminController;
use Projet5\controller\back\BackPostController;
use Projet5\controller\back\CommentController;

use Projet5\model\UserModel;
use Projet5\model\PostModel;
use Projet5\model\CommentModel;

class Router{

	public function run(){

		// Configuration and global variables
		require("config.php");

		//Models variables
		$userModel = new UserModel($dataBase);
		$postModel = new PostModel($dataBase);
		$commentModel = new CommentModel($dataBase);

		//ROUTER
		$url = '';
		if(isset($_GET['url'])){
			$url = explode('/', strtolower($_GET['url']));
		}
		/*Accueil*/
		if($url=='' || $url[0]=='accueil'){
			$homepageController = new HomepageController();
			$homepageController->index($userModel);
			
		/*Les Articles*/
		} elseif(preg_match('#^articles?-page([0-9]+)$#', $url[0], $params)){
			$currentPage = intval($params[1]);
			$postController = new FrontPostController();
			$postController->displayPosts($postModel,$currentPage);
			$url ='';

		/*Un article-id with this comments*/
		} elseif(preg_match('#^articles?-([0-9]+)-page([0-9]+)$#', $url[0], $params)){
			$idPost = $params[1];
			$currentPage = intval($params[2]);
			$postController = new FrontPostController();
			$postController->displayPost($postModel, $commentModel, $idPost, $currentPage);

		/*ajouter-un-commentaire-idPost*/
		} elseif(preg_match('#^ajouter-un-commentaire-([0-9]+)$#', $url[0], $params)){
			$idPost = $params[1];
			$commentController = new CommentController();
			$commentController->insertComment($postModel, $commentModel, $idPost);

		/*ajouter-un-article*/
		} elseif($url[0] == 'ajouter-un-article'){
			$postController = new BackPostController();
			$postController->addPost($postModel);

		/*supprimer-un-article*/
		} elseif(preg_match('#^supprimer-article-([0-9]+)$#', $url[0], $params)){
			$idPost = $params[1];
			$postController = new BackPostController();
			$postController->deletePost($idPost, $postModel);
			
		/*modifier-article-id*/
		} elseif(preg_match('#^modifier-article-([0-9]+)$#', $url[0], $params)){
			$idPost = $params[1];
			$postController = new BackPostController();
			$postController->editPost($idPost, $postModel);

		/*connexion*/
		} elseif($url[0]=='connexion'){
			$userController = new UserController();
			$userController->connexion($userModel);

		/*inscription*/
		} elseif($url[0]=='inscription'){
			$userController = new UserController();
			$userController->register($userModel);

		/*inscription*/
		} elseif($url[0]=='deconnexion'){
			$userController = new UserController();
			$userController->deconnexion();

		/*administratrion*/
		} elseif($url[0]=='administration'){
			$adminController = new AdminController();
			$adminController->display($userModel, $postModel, $commentModel);
			
		} else {
			$_SESSION['error'] = 'Erreur 404 - Page non trouvé';
			$homepageController = new HomepageController();
			$homepageController->index($userModel);
		}
	}

	//unset success variables after display
	public function unsetSuccessErrorVariables(){

	    unset($_SESSION['success']);
		unset($_SESSION['error']);

		
	}
}