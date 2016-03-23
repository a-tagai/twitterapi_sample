<?php

namespace App\Controller;

use Abraham\TwitterOAuth\TwitterOAuth;

class AuthTwitter extends \App\Controller{

	public function run(){

		if($_SERVER['REQUEST_METHOD'] === 'GET'){
			$this->doGet();
		}
	}

	protected function doGet(){
		if (!isset($_GET['oauth_token']) || !isset($_GET['oauth_verifier'])) {
			$this->_redirectFlow();
		}else{
			$this->_callbackFlow();
		}
	}

	private function _redirectFlow(){
		$conn = new TwitterOAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET);

		// 認証リクエスト用トークン発行
		$tokens = $conn->oauth('oauth/request_token', [
		  'oauth_callback' => TWITTER_CALLBACK_URL
		]);

		// 認証リクエスト用トークンの保持
		$_SESSION['tmp_twitter_oauth_token'] = $tokens['oauth_token'];
		$_SESSION['tmp_twitter_oauth_token_secret'] = $tokens['oauth_token_secret'];

		// Twitterの認証画面へリダイレクトさせる
		$authorizeUrl = $conn->url('oauth/authorize', [
		  'oauth_token' => $tokens['oauth_token']
		]);
		header('Location: ' . $authorizeUrl);
		exit;
	}

	private function _callbackFlow(){
		// 不正認証防止用に認証リクエスト用トークンをチェック
		if ($_GET['oauth_token'] !== $_SESSION['tmp_twitter_oauth_token']){
			echo "Invalid Token!";
			exit;
		}

		// twitterのユーザー情報の取得
		$conn = new TwitterOAuth(
			TWITTER_CONSUMER_KEY,
			TWITTER_CONSUMER_SECRET,
			$_SESSION['tmp_twitter_oauth_token'],
			$_SESSION['tmp_twitter_oauth_token_secret']
		);
		$tokens = $conn->oauth('oauth/access_token', [
			'oauth_verifier' => $_GET['oauth_verifier']
		]);

		//取得したtwitterユーザー情報をDBに登録もしくは更新
		$user = new \App\Model\User();
		if ($user->existsTwitterUser($tokens['user_id'])){
			if(!$user->updateTwitterUser($tokens)){
				echo "update error!";
				exit;
			}
		}else{
			if(!$user->createTwitterUser($tokens)){
				echo "create error!";
				exit;
			}
		}


		//ログイン処理
		session_regenerate_id(true);
		$_SESSION['user'] = $user->findTwitterUser([
			'tw_user_id' => $tokens['user_id']
		]);

		//認証リクエスト用トークンはもう使わないので消す
		unset($_SESSION['tmp_twitter_oauth_token']);
		unset($_SESSION['tmp_twitter_oauth_token_secret']);


		header('Location: ' . SITE_URL);
		exit;
	}
}
