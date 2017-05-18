<?php namespace OznForm;

require_once dirname(__FILE__) . '/FormError.class.php';

/**
 * Class Database
 *
 * @package OznForm
 *
 * @property \PDO   $db
 * @property array $config
 * @property string $lastErrorMessage
 */
class Database
{

    private $config;
    private $db;

    public $lastErrorMessage;

    const RELATIVE_CONFIG_PATH = '/../config/database.php';
    const RELATIVE_SQLITE_PATH = '/../db/';


    function __construct()
    {
        $this->loadConfig();
        $this->connect();
    }


    /**
     * 接続済みデータベースハンドルを返す
     *
     * @return \PDO
     */
    public function getDBH()
    {
        return $this->db;
    }

//    /**
//     * データ取得
//     *
//     * @param       $table
//     *
//     * @return
//     */
//    public function find($table, $condition = array(), $limit = null, $offset = null) {
//
//        $is_condition = FALSE;
//        $sql          = "SELECT * FROM $table ";
//
//        // 検索条件があるときの処理
//        if( ! empty($condition)) {
//
//            $is_condition  = TRUE;
//            $condition_str = array();
//            $condition_values = array();
//
//            foreach ($condition as $item) {
//                $condition_str[] = "{$item[0]} = :{$item[0]}";
//                $condition_values[$item[0]] = $item[1];
//            }
//
//            $sql .= 'WHERE ' . join(' AND ', $condition_str);
//        }
//
//        $stmt = $this->db->prepare($sql);
//
//
//        if($is_condition) {
//            foreach ($condition_values as $key => $value) {
//                $stmt->bindValue(":$key", $value);
//            }
//        }
//
//        if($stmt->execute()) {
//            if($stmt->rowCount() == 0) {return false;}
//            return $stmt->fetch();
//        } else {
//            $this->lastErrorMessage = $stmt->errorInfo();
//            return false;
//        }
//
//    }

    public function getConfig()
    {
        return $this->config;
    }

    /**
     * 指定のテーブルへINSERT
     *
     * @param $table
     * @param $params
     *
     * @return string|bool
     */
    public function insert($table, $params)
    {
        $columns = join(', ', array_keys($params));
        $values  = join(', ', array_map(function($v){ return ':' . $v;}, array_keys($params)));

        $sql = "INSERT INTO $table ($columns) VALUES ($values)";

        $stmt = $this->db->prepare($sql);

        foreach ($params as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        if($stmt->execute()) {
            return $this->db->lastInsertId();
        } else {
            $this->lastErrorMessage = $stmt->errorInfo();
            return FALSE;
        }

    }

    /**
     * 設定ファイル読み込み
     *
     * @throws FormError
     */
    private function loadConfig()
    {
        $path = dirname(__FILE__) . self::RELATIVE_CONFIG_PATH;

        if(file_exists($path))
        {
            $this->config = include($path);
        } else {
            throw new FormError('管理機能が有効化されていません');
        }
    }

    /**
     * 接続処理
     */
    private function connect()
    {
        switch ($this->config['database']) {
            case 'sqlite': $this->connectSQLite(); break;
            default: throw new FormError('接続データベース種別の記述が不正です。');
        }
    }

    /**
     * SQLite 接続処理
     */
    private function connectSQLite()
    {

        $dsn = 'sqlite:' . $this->getSQLiteDBPath();

        $this->db = new \PDO($dsn, null, null, array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));

        // DBが作成直後だったら初期化する
        $res = $this->db->query("SELECT COUNT(*) FROM sqlite_master WHERE tbl_name NOT LIKE 'sqlite%';");

        if($res->fetchColumn() == 0) { $this->initDatabase(); }
    }

    /**
     * SQLite DBのパスを返す
     * @throws FormError
     * @return string
     */
    private function getSQLiteDBPath() {

        $dir = dirname(__FILE__);
        $db_extension = '.db';

        if(isset($this->config['database_path'])) {
            $dir .= '/../' . $this->config['database_path'];
        } else {
            $dir .=  self::RELATIVE_SQLITE_PATH;
        }

        if( ! file_exists($dir)) { throw new FormError('SQLite DB保存ディレクトリが存在しません。設定値を見直してください。'); }

        return $dir . $this->config['sqlite']['db_name'] . $db_extension;

    }

    /**
     * データベース初期化処理
     */
    private function initDatabase()
    {

        $init_sql = "
            CREATE TABLE histories
            (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                form_name TEXT,
                send_datetime TEXT,
                user_agent TEXT,
                referrer TEXT,
                form_items TEXT
            );";

        $this->db->query($init_sql);

    }
}