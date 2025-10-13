<?php
/**
 * Veritabanı Bağlantı Sınıfı
 * PDO kullanarak MySQL bağlantısı ve işlemleri
 */
class Database
{
    private $pdo;
    private $host;
    private $dbname;
    private $username;
    private $password;
    private $charset;

    public function __construct()
    {
        $this->host = DB_HOST;
        $this->dbname = DB_NAME;
        $this->username = DB_USER;
        $this->password = DB_PASS;
        $this->charset = 'utf8mb4';

        $this->connect();
    }

    /**
     * Veritabanına bağlan
     */
    private function connect()
    {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            $this->pdo = new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $e) {
            die('Veritabanı bağlantı hatası: ' . $e->getMessage());
        }
    }

    /**
     * SQL sorgusu çalıştır ve sonuç döndür
     */
    public function query($sql, $params = [])
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log('Database query error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * SQL sorgusu çalıştır (INSERT, UPDATE, DELETE)
     */
    public function execute($sql, $params = [])
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute($params);
            
            // INSERT işlemi için son eklenen ID'yi döndür
            if (strpos(strtoupper($sql), 'INSERT') === 0) {
                return $this->pdo->lastInsertId();
            }
            
            return $result;
        } catch (PDOException $e) {
            error_log('Database execute error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Tek bir kayıt getir
     */
    public function fetch($sql, $params = [])
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log('Database fetch error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Etkilenen satır sayısını getir
     */
    public function rowCount($sql, $params = [])
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            error_log('Database rowCount error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Transaction başlat
     */
    public function beginTransaction()
    {
        return $this->pdo->beginTransaction();
    }

    /**
     * Transaction commit
     */
    public function commit()
    {
        return $this->pdo->commit();
    }

    /**
     * Transaction rollback
     */
    public function rollback()
    {
        return $this->pdo->rollback();
    }

    /**
     * PDO instance'ını getir
     */
    public function getPDO()
    {
        return $this->pdo;
    }
}