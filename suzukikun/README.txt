##################################################
総会管理システム 鈴木くん v4.4.0
Copyright Hirochka Suzuki. All Rights Reserved.

LastUpdate: 2012.5.5
##################################################


1. サーバー必須環境
	・WebServer (Apache等)
	・MySQL ver4.0以上
	・PHP ver5.2以上


2. クライアント必須環境
	a. OS
		・Windows vista 以上
		・Mac OS X 10.6 以上

	b Browser
		・(Win) Microsoft InternetExplorer 9 以上
		・(Win,Mac) Mozila firefox4 以上
		・(Win,Mac) Google Chrome11 以上
		・(Mac) Apple Safari5 以上
	
	c. Other
		・Javascriptが使える環境
		・Cookieが使える環境


3. 初期セットアップ
	a. "Suzuki-kun4.4.0"内の全データをWebServerのホームディレクトリーに移動する。
	
	b. MySQLにユーザーを作成する。
		例:
		サーバー名 : localhost (通常はlocalhost)
		ユーザー名 : shikkou
		パスワード : shikkoupass
		データーベース名 : shikkoudb 
		grant all privileges on shikkoudb.* to shikkou@localhost identified by 'shikkoupass';
		
	c. ブラウザからアクセスする。
	
	d. 管理者のユーザーを作成する。ただし、ここで作るユーザーは最高管理ユーザーとなり、後で変更することはできないため注意が必要である。
