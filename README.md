# job-hunting-system

要件定義 v2
システム名

就活管理システム

##概要
応募を検討している企業や応募済みのインターン、選考状況、自己PRを一元管理するWebアプリケーション。

##課題
就活では企業情報やインターン情報が複数のサイトやメモに分散してしまい管理が難しい。

解決策
企業情報、インターン情報、選考状況、自己PRを一元管理できるWebアプリを開発する。

## 技術スタック

- PHP
- Laravel
- SQLite
- HTML / CSS
- JavaScript
- Tailwind CSS
- Docker
- Git / GitHub

##機能一覧
・ユーザー管理
新規登録
ログイン
ログアウト

・自己PR管理

CRUD

管理項目

タイトル
本文
文字数
作成日時
更新日時

追加機能

本文一括コピー

・企業管理

CRUD

管理項目
企業名
志望度（１～５）
本社住所
業種
初任給
その他収入
勤務時間
休憩時間
研修期間
客先常駐レベル（選択式：なし
低い
高い
不明）
福利厚生メモ
自由メモ

・企業URL管理
企業に紐付く複数URLを登録可能
例
企業サイト
採用サイト

管理項目
URL
説明

・インターン管理
CRUD

管理項目
インターン名
企業
日時
休憩時間
開催場所
最寄り駅
実施内容
交通費支給有無
交通費金額
昼食支給有無
詳細URL
応募済フラグ
参加済フラグ
参加後メモ

・選考管理
CRUD

管理項目
企業名
選考段階
日時
開催場所
最寄り駅
交通費支給有無
自費交通費
服装
持ち物
メモ
結果連絡期間
現在状況（未終了、終了済み・結果未発表、結果発表済み）

・ソート機能
企業一覧
　登録順
　志望度順

インターン一覧
　開催日時順

選考一覧
　開催日時順
　企業名順

・絞り込み
インターン一覧
　応募済み
　参加

選考一覧
　未終了
　終了済み・結果未発表、
　結果発表済み


##画面一覧
ログイン
↓
ホーム
├─ 自己PR一覧
｜	├─ 自己PR作成
｜	└─ 自己PR編集
├─ 企業一覧
｜	├─ 企業登録
｜	└─ 企業編集
├─ インターン一覧
｜	├─ インターン登録
｜	└─ インターン編集
├─ 選考一覧
｜	├─ 選考登録
｜	└─ 選考編集
└─ マイページ
	├─ アカウント情報変更
	├─ 自己PR閲覧
	└─ アカウント削除


##DB設計
users(ユーザ)
id int PK
name varchar(50)
email varchar(255) unique
password varchar(255) 暗号化
created_at datetime
updated_at datetime

self_prs（自己PR）
id int PK
user_id int FK
title varchar(100)
body text 
created_at datetime
updated_at datetime


companies（気になる企業）
id int PK
user_id int FK
name varchar(255)
level int 1,2,3,4,5 default=3
address varchar(255)
industry varchar(50)
salary int
basic_salary int
other_salary int
start_time time
end_time time
break_time time
training_period int
ses_level varchar(16) "なし","低い","高い","不明"
benefits_memo text
free_memo text
created_at datetime
updated_at datetime

company_urls（企業URL）
id int PK
company_id int FK
url varchar(255)
memo varchar(100) null
created_at datetime
updated_at datetime

internships（インターン一覧）
id int PK
user_id int FK
company_id int FK
name varchar(255)
start_datetime datetime
end_datetime datetime
break_time int
place varchar(255)
station varchar(255)
content text
carfare boolean
carfare_price int
lunch boolean
url
applied boolean
joined boolean
joined_memo text
created_at datetime
updated_at datetime

selections（選考）
id int PK
user_id FK
company_id FK
step string
selection_datetime datetime
place string
station string
carfare boolean
carfare_price int
clothing string
items text
free_memo text
result_period string
status string
created_at datetime
updated_at datetime

