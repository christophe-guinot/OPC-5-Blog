<?php

namespace Projet5\controller\front;

use Projet5\controller\TwigController;

class FrontPostController extends TwigController{


	public function displayPosts($postModel, $currentPage){

		//count number of row valide
		$countPosts= $postModel->countAllPost($valide='yes');
		$numberPosts = $countPosts->rowCount();
		//take Limits for request SQL
		$paging = $this->paging(POST_PER_PAGE, $numberPosts, $currentPage);

		$posts = $postModel->loadAllPost($valide='yes', $paging['startLimit'], POST_PER_PAGE );

		echo $this->twig->render('blogPosts.twig', [
			'SESSION' => $_SESSION , 
			'posts' => $posts , 
			'paging' => $paging
		]);
	}

	public function displayPost($postModel, $commentModel, $idPost, $currentPage){

		//load the post
		$post = $postModel->loadPost($idPost);

		//if post not valide display a error message
		if ($post['validate']=='no'){
			$_SESSION['error'] = 'L\'article est en attente de validation par un administrateur';
			header('location:Articles-Page1');
			exit;
		}

		//load comments for this post
		$comments = $commentModel->loadAllCommentsWithIdPost($idPost);
		//count number of row
		$numberComments = $comments->rowCount();
		//take Limits for request SQL
		$paging = $this->paging(COMMENT_PER_PAGE, $numberComments, $currentPage);
		//load comments with limit
		$comments = $commentModel->loadAllCommentsWithIdPost($idPost, $paging['startLimit'], COMMENT_PER_PAGE);
		//display post and comments
		echo $this->twig->render('post.twig', [	
			'SESSION' => $_SESSION,
			'post' => $post,
			'comments' => $comments,
			'paging' => $paging
		]);
	}


	//This function use the $numberPerPage you want and how many row you have in your table for return a array of numbers with the $startlimit, the $currentPage and the $totalPages.
	private function paging($numberPerPage, $numberRow, $currentPage = 1){
		
		//calcul total pages
		$totalPages = ceil($numberRow/$numberPerPage);
		//calcul startlimit for request SQL
		$startLimit=intval(($currentPage-1)*$numberPerPage);

		return $paging = [
			'startLimit' => $startLimit,
			'currentPage' => $currentPage,
			'totalPages' => $totalPages
		];
	}
}