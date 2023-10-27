<?php
	class UserManager extends BaseManager
	{
		public function __construct()
		{
			parent::__construct("user", "User");
		}
		
    // Recherche sur le mail
		public function getByMail($mail): mixed
		{
			$req = $this->dataBase->prepare("SELECT * FROM user WHERE mail = ?");
			$req->execute(array($mail));
			$req->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "User");
			return $req->fetch();
		}
	}