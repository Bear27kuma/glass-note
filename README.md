# Glass Note

## 概要
LaravelとTailwind CSSを利用したシンプルなミニノートアプリケーション。<br>
UIのスタイリングにはGlassmorphismを採用。

[データベース構造（ER図）](https://dbdiagram.io/d/61176cba2ecb310fc3cb274e)

## スクリーンショット

![Screenshot01](https://user-images.githubusercontent.com/39920490/132076394-b6503473-2a26-4064-8554-07007396c739.png)
![Screenshot02](https://user-images.githubusercontent.com/39920490/132076437-7537d2bd-5385-4973-96c4-f654f0771c6b.png)


## 開発環境

Mac OS Big Sur 11.5.2

| 言語・フレームワーク・パッケージ名                 | バージョン     | 
| -------------------------------------------- | -------------- | 
| VirtualBox | 6.1.26 | 
| Vagrant | 2.2.18 | 
| Homestead  | 12.5.0 | 
| PHP | 8.0.5 | 
| Laravel | 8.56.0 |
| Tailwind CSS | 2.2.7 |


## 開発環境構築

開発環境の構築に関しては以下のページを参考に進めてください。<br>
- [【Laravel 5.5 or latest】Homestead で mac に Laravel 開発環境を構築](https://qiita.com/7968/items/68b3566d92d2b007038e)
- [Laravel Homesteadを使ってみたいけどコマンド入力が難しい！という人のために手順を分かりやすく解説](https://biz.addisteria.com/laravel_homestead_env/)

## コマンド一覧

```
# Laravelのインストールとプロジェクト作成
composer create-project laravel/laravel --prefer-dist glass-note

# Tailwind CSSのインストール
composer require laravel-frontend-presets/tailwindcss --dev

# 認証画面などのUIとその機能をTailwind CSSベースで作成
php artisan ui tailwindcss --auth

# Laravelプロジェクトを起動する
npm install && npm run dev

# 上記でエラーした場合は以下のコマンドを上から順に行う
npm audit fix
npm audit fix --force
npm install
npm run dev

# マイグレーション実行
php artisan migrate
```


## ソースコード対応表

| レクチャー名                                 | ブランチ名     | 
| -------------------------------------------- | -------------- | 
| 開発ブランチ | develop | 
| 時刻設定など、ide-helper導入 | setup | 
| マイグレーションファイルにテーブル定義を実装、モデル作成  | feature/create-model | 
| Tailwind CSSによる認証画面と大枠レイアウトの実装 | feature/ui-auth | 
| ノート作成機能の実装 | feature/create-notes | 
| ノート一覧取得、表示機能の実装 | feature/notes-index | 
| ノート更新機能の実装 | feature/notes-update | 
| ノート削除機能の実装 | feature/notes-delete | 
| ノートにタグをつけられる機能を実装 | feature/add-tags | 
| タグによるノート絞り込み機能を実装 | feature/tags-search | 
| タグ検索とその他のロジックのリファクタリング | feature/refactoring |  
| ノート作成機能にバリデーションを追加 | feature/validation | 
| ノート削除に確認ダイアログを追加 | feature/dialogue | 
| Tailwind CSSによるGlassmorphismのスタイリング | feature/frontend |
