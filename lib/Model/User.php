<?php

namespace App\Model;

/**
*
*/
class User extends \App\Model{

/**
 * 新規ユーザーを登録する
 * 既にメールアドレスが登録されてる場合は、登録できません
 * @param  array[] $values 取得したいユーザーの条件。有効な値は以下のとおりです
 * 	$values[
 *	 	'email'=>'メールアドレス',
 * 		'password'=>'パスワード'
 * 	]
 * @return bool 登録結果。成功の場合はtrue。失敗した場合はfalseを返します。
 */
	public function create($values){
		try{
			$sql = "INSERT into users(
					name,
					email,
					password,
					created,
					modified
				) values(
					:name,
					:email,
					:password,
					now(),
					now()
				)";
			$stmt = $this->conn->prepare($sql);
			$result = $stmt->execute([
				':name' => $values['email'],
				':email' => $values['email'],
				':password' => password_hash($values['password'], PASSWORD_DEFAULT)
			]);
			return $result;
		}catch(\PDOException $e){
			error_log($e->getMessage(),0);
			error_log($e->getTraceAsString(),0);
			return false;
		}
	}

/**
 * 特定のユーザーの情報を取得する
 * @param  string[] $options 取得したいユーザーの条件。有効な値は以下のとおりです
 * 	$options[
 *	 	'email'=>'メールアドレス',//必須
 * 		'password'=>'パスワード',//必須
 * 	]
 * @return array|bool 取得したユーザー情報を配列で返します。失敗した場合はfalseを返します。
 */
	public function findUser($options){
		try{
			$sql = "SELECT * FROM users WHERE email = :email";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute([
				':email' => $options['email']
			]);

			$stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
			$user = $stmt->fetch();

			if(empty($user)){
				//ユーザが見つからない場合
				return false;
			}elseif(!password_verify($options['password'], $user->password)){
				//パスワードが一致しない場合
				return false;
			}
			return $user;
		}catch(\PDOException $e){
			error_log($e->getMessage(),0);
			error_log($e->getTraceAsString(),0);
			return false;
		}
	}

/**
 * Twitterのログイン情報を元に、特定のユーザーの情報を取得する
 * @param  string[] $options 取得したいユーザーの条件。有効な値は以下のとおりです
 * 	$options[
 *	 	'tw_user_id'=>string 'TwitterユーザーID',//必須
 * 	]
 * @return array|bool 取得したユーザー情報を配列で返します。失敗した場合はfalseを返します。
 */
	public function findTwitterUser($options){
		try{
			$sql = "SELECT * FROM users WHERE tw_user_id = :tw_user_id";
			$stmt = $this->conn->prepare($sql);
			$result = $stmt->execute([
				':tw_user_id' => $options['tw_user_id']
			]);
			if(!$result){
				throw new \App\Exception\StmtExecuteException($stmt->errorInfo());
			}

			$stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
			$user = $stmt->fetch();

			if(empty($user)){
				//ユーザが見つからない場合
				return false;
			}
			return $user;
		}catch(\PDOException $e){
			error_log($e->getMessage(),0);
			error_log($e->getTraceAsString(),0);
			return false;
		}catch(\App\Exception\StmtExecuteException $e){
			error_log($e->getMessage(),0);
			error_log($e->getTraceAsString(),0);
			return false;
		}
	}

/**
 * 全ユーザー情報を取得
 * @return array|bool 全ユーザー情報を配列で返します。失敗した場合はfalseを返します。
 *
 */
	public function findAll(){
		$stmt = $this->conn->query("select * from users order by id");
		$stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
		return $stmt->fetchAll();
	}


/**
 * 指定したTwitterユーザーIDのログイン情報を持っているユーザーが存在するか判定する
 * @param  string $twUserId TwitterユーザーID。このIDを持つユーザーが存在するかを判定する
 * @return bool ユーザーが存在している場合はtrue,していない場合はfalse
 */
	public function existsTwitterUser($twUserId){
		try{
			$sql = sprintf("select count(*) from users where tw_user_id=%d", $twUserId);
			$res = $this->conn->query($sql);
			return $res->fetchColumn() === '1';
		}catch(\PDOException $e){
			error_log($e->getMessage(),0);
			error_log($e->getTraceAsString(),0);
			return false;
		}
	}

/**
 * Twitterでのログインユーザーとして新規アカウント登録
 * @param  array $twitterUser
 * $twitterUser[
 *   'oauth_token' => string '*****',
 *   'oauth_token_secret' => string '*****',
 *   'user_id' => string 'ユーザーID',
 *   'screen_name' => string 'twitterの「@username」の「username」の箇所'
 *	]
 *
 * @return bool 登録結果。成功の場合はtrue。失敗した場合はfalseを返します。
 */
	public function createTwitterUser($twitterUser) {
		$sql = "insert into users (
		name,
		tw_user_id,
		tw_screen_name,
		tw_access_token,
		tw_access_token_secret,
		created,
		modified
		) values (
		:name,
		:tw_user_id,
		:tw_screen_name,
		:tw_access_token,
		:tw_access_token_secret,
		now(),
		now()
		)";
		$stmt = $this->conn->prepare($sql);

		$stmt->bindValue(':name', $twitterUser['screen_name'], \PDO::PARAM_STR);
		$stmt->bindValue(':tw_user_id', (int)$twitterUser['user_id'], \PDO::PARAM_INT);
		$stmt->bindValue(':tw_screen_name', $twitterUser['screen_name'], \PDO::PARAM_STR);
		$stmt->bindValue(':tw_access_token', $twitterUser['oauth_token'], \PDO::PARAM_STR);
		$stmt->bindValue(':tw_access_token_secret', $twitterUser['oauth_token_secret'], \PDO::PARAM_STR);

		try{
			$result = $stmt->execute();
			if(!$result){
				throw new \App\Exception\StmtExecuteException($stmt->errorInfo());
			}
			return $result;
		}catch(\PDOException $e){
			error_log($e->getMessage(),0);
			error_log($e->getTraceAsString(),0);
			return false;
		}catch(\App\Exception\StmtExecuteException $e){
			error_log($e->getMessage(),0);
			error_log($e->getTraceAsString(),0);
			return false;
		}

	}

/**
 * Twitterのユーザー情報を更新
 * @param  array $twitterUser
 * $twitterUser[
 *   'oauth_token' => string '*****',
 *   'oauth_token_secret' => string '*****',
 *   'user_id' => string 'ユーザーID',
 *   'screen_name' => string 'twitterの「@username」の「username」の箇所'
 *	]
 *
 * @return bool 登録結果。成功の場合はtrue。失敗した場合はfalseを返します。
 */
	public function updateTwitterUser($twitterUser) {
		$sql = "update users set
		tw_screen_name = :tw_screen_name,
		tw_access_token = :tw_access_token,
		tw_access_token_secret = :tw_access_token_secret,
		modified = now()
		where tw_user_id = :tw_user_id";

		$stmt = $this->conn->prepare($sql);

		$stmt->bindValue(':tw_screen_name', $twitterUser['screen_name'], \PDO::PARAM_STR);
		$stmt->bindValue(':tw_access_token', $twitterUser['oauth_token'], \PDO::PARAM_STR);
		$stmt->bindValue(':tw_access_token_secret', $twitterUser['oauth_token_secret'], \PDO::PARAM_STR);
		$stmt->bindValue(':tw_user_id', (int)$twitterUser['user_id'], \PDO::PARAM_INT);

		try {
			$result = $stmt->execute();
			if(!$result){
				throw new \App\Exception\StmtExecuteException($stmt->errorInfo());
			}
			return $result;
		} catch (\PDOException $e) {
			error_log($e->getMessage(),0);
			error_log($e->getTraceAsString(),0);
			return false;
		}catch(\App\Exception\StmtExecuteException $e){
			error_log($e->getMessage(),0);
			error_log($e->getTraceAsString(),0);
			return false;
		}

	}

}