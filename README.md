# **Atte**
***
### 概要説明
***
勤怠管理用のアプリ

### 作成した目的
***
人事評価のため
### アプリケーションURL
***
http://54.95.185.109  
### 機能一覧
***
* ログイン機能
* 会員登録機能
* ログアウト
* 勤務開始
* 勤務終了
* 休憩開始
* 休憩終了
* 日別勤怠情報取得
* 従業員情報取得
* 従業員別月別出勤情報取得
### 使用技術（実行環境）
***
* nginx 1.21.1
* mysql 8.0.26
* php 7.4.9-fpm
* Laravel Framework 8.83.28
### テーブル設計
***
![users](src/resources/images/users.png)
![attendances](src/resources/images/attendances.png)
![break_times](src/resources/images/break_times.png)
### ER図
***
![/ER](src/resources/images/ER.png)
### 環境構築
***
**Dockerビルド**
1. `git clone git@github.com:seiya71/Atte.git`
2. DockerDesktopアプリを立ち上げる
3. `docker-compose up -d --build`
> *MacのM1・M2チップのPCの場合、`no matching manifest for linux/arm64/v8 in the manifest list entries`のメッセージが表示されビルドができないことがあります。
エラーが発生する場合は、docker-compose.ymlファイルの「mysql」内に「platform」の項目を追加で記載してください*
``` bash
mysql:
    platform: linux/x86_64(この文追加)
    image: mysql:8.0.26
    environment:
```

**Laravel環境構築**
1. `docker-compose exec php bash`
2. `composer install`
3. 「.env.example」ファイルを 「.env」ファイルに命名を変更。または、新しく.envファイルを作成
4. .envに以下の環境変数を追加
``` text
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass
```
5. アプリケーションキーの作成
``` bash
php artisan key:generate
```

6. マイグレーションの実行
``` bash
php artisan migrate
```

7. シーディングの実行
``` bash
php artisan db:seed
```
## URL
- 開発環境：http://localhost/
- phpMyAdmin:：http://localhost:8080/
