<?php
require_once '../autoload.php'
?>

<?php
class Connect {
    public static function getConfig($key) {
        $config = new Config;

        return $config->config[$key];
    }

    public static function getPdo(){
        static $pdo = null;

        if (!$pdo) {
            $pdo = new PDO(
                self::getConfig('db_dsn'),
                self::getConfig('db_user'),
                self::getConfig('db_password')
            );

            $pdo->exec("set names = utf8");

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = $pdo->prepare("SET sql_mode = 'STRICT_ALL_TABLES'");
            $query->execute();
        }

        return $pdo;
    }
}
?>
