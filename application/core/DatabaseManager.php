<?php
/**
 * commentator: Bogdan N. date: 05.08.2020
 * A class that implements methods for working with a database.
 */

final class DatabaseManager {
    private static $instance;
    private $pdo;

    //region Statics
    public static function instance() {
        if (self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }
    //endregion

    //region Initialization
    public function __construct() {
        $settings = $this->getPDOSettings();
        $options = $this->getPDOOptions();
        $this->pdo = new PDO($settings['dsn'], $settings['user'], $settings['pass'], $options);
    }

    private function getPDOSettings() {
        $configuration = include_once DATABASE_CONFIGURATION;
        $pdoSettings['dsn'] = "{$configuration['type']}:host={$configuration['host']};dbname={$configuration['dbname']};charset={$configuration['charset']}";
        $pdoSettings['user'] = $configuration['user'];
        $pdoSettings['pass'] = $configuration['pass'];
        return $pdoSettings;
    }

    private function getPDOOptions() {
        return [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
    }
    //endregion

    //region Public methods
    public function query(string $sql, bool $all = true, array $parameters = null) {
        if(empty($parameters)) {
            $stmt = $this->pdo->query($sql);
            return $stmt === false ? '' : $this->fetch($stmt, $all);
        } else {
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($parameters) === false ? '' : $this->fetch($stmt, $all);
        }
    }

    public function execute(string $sql, array $parameters = null) {
        if (empty($parameters)) {
            return $this->pdo->exec($sql) > 0;
        } else {
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($parameters);
        }
    }

    public function fetch(PDOStatement $stmt, bool $all = true) {
        return $all ? $stmt->fetchAll() : $stmt->fetch();
    }
    //endregion
}