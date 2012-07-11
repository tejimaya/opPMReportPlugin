opPMReportPlugin
================

SNSの各データを集計するプラグイン

保存するデータ
---------------

* 一日/一月のログイン人数
* 一日/一月のメンバ数（デフォルトではOFF）

閲覧方法
-----------

管理画面トップ > PMレポート（/pc_backend.php/report）にアクセス。

### 管理画面メニューに「PMレポート」が存在しない場合

管理画面 ナビゲーション設定 > 管理画面ナビ設定（/pc_backend.php/navigation/list/app/backend）より以下の設定を追加。

URL: /report
項目名(en): PMReport
項目名(ja_JP): PMレポート

設定完了後、管理画面メニューよりPMレポートへアクセス可能となる。


設定方法
-----------

### 集計時間

crontab で下記の行を追加
意味は「毎日 0時00分 に全部を集計する」

    00 0 * * * cd /path/to/openpne ; ./symfony opPMReport:totalall

/path/to/openpne は OpenPNE のルートディレクトリを指定。

### 集計内容（通常は変更不要）

保存するデータは config/reports.yml を編集する．
デフォルトの状態は下記の通り．

    report:
      login:                                                                                                                                                                                                                                  
        task: TotalLogin
        caption: "Num of Login"
    #  member:
    #    task: TotalMember
    #    caption: "Num of Member"


* task

lib/task/opPMReportExecああああTask.class.php というようなファイルがあるのでこの「ああああ」に該当する部分を記述する．

* caption

「PMレポート」での各データの項目名

処理詳細
--------

1. cron によって集計用のタスクを起動する
2. 集計用のタスクは config/reports.yml を読み込んで集計するデータリストを取得する
3. 各集計用タスクを実行する


拡張方法
--------

lib/task/opPMReportExecああああTask.class.php のようなファイルを新しく作成して， opPMReportExecBaseTask を継承する．すると下記のように一日毎のデータと月毎のデータを追加する処理を使用して設定することができる．

    $this->setDailyReport('login', $date, $result['count']);
    $this->setMonthlyReport('login', $date, $result['count']);
    $this->addMonthlyReport('login', $date, $result['count']);
