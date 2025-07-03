<?php

class BaseModel
{
    protected static $table = '';
    protected static $pdo;
    protected static $queryParts = array();
    protected static $bindings = array();

    public $id;

    public function __construct($dados = array())
    {
        self::$pdo = Database::getInstance();
        foreach ($dados as $chave => $valor) {
            $this->$chave = $valor;
        }
    }

    public function save()
    {
        $props = get_object_vars($this);

        if ($this->id) {
            $propsCopy = $props;
            unset($propsCopy['id']);

            $sets = array();
            $values = array();
            foreach ($propsCopy as $chave => $valor) {
                $sets[] = "$chave = ?";
                $values[] = $valor;
            }
            $values[] = $this->id;
            $sql = "UPDATE " . static::$table . " SET " . implode(', ', $sets) . " WHERE id = ?";
            $stmt = self::$pdo->prepare($sql);
            return $stmt->execute($values);
        } else {
            if (!isset($this->id) || $this->id == NULL) {
                $this->id = $this->gerarUUIDv4();
                $props['id'] = $this->id;
            }

            $campos = array_keys($props);
            $values = array_values($props);

            $placeholders = array_fill(0, count($values), '?');
            $sql = "INSERT INTO " . static::$table . " (" . implode(', ', $campos) . ") VALUES (" . implode(', ', $placeholders) . ")";
            $stmt = self::$pdo->prepare($sql);
            $success = $stmt->execute($values);
            
            return $success;
        }
    }

    public function delete()
    {
        if (!$this->id) return false;
        $stmt = self::$pdo->prepare("DELETE FROM " . static::$table . " WHERE id = ?");
        return $stmt->execute(array($this->id));
    }

    public static function find($id)
    {
        self::$pdo = Database::getInstance();
        $stmt = self::$pdo->prepare("SELECT * FROM " . static::$table . " WHERE id = ?");
        $stmt->execute(array($id));
        $dados = $stmt->fetch();
        if ($dados) {
            return new static($dados);
        }
        return null;
    }

    public static function all()
    {
        self::$pdo = Database::getInstance();
        $stmt = self::$pdo->query("SELECT * FROM " . static::$table);
        $resultados = array();
        while ($row = $stmt->fetch()) {
            $resultados[] = new static($row);
        }
        return $resultados;
    }

    // --- Builder ---

    public static function where($campo, $valor)
    {
        static::$queryParts['where'][] = "$campo = ?";
        static::$bindings[] = $valor;
        return new static;
    }

    public static function whereIn($campo, $array)
    {
        if (empty($array)) return new static;

        $placeholders = array_fill(0, count($array), '?');
        static::$queryParts['where'][] = "$campo IN (" . implode(', ', $placeholders) . ")";
        static::$bindings = array_merge(static::$bindings, $array);
        return new static;
    }

    public static function like($campo, $valor)
    {
        static::$queryParts['where'][] = "$campo LIKE ?";
        static::$bindings[] = $valor;
        return new static;
    }

    public function orderBy($campo, $direction = 'ASC')
    {
        static::$queryParts['order'] = "ORDER BY $campo " . strtoupper($direction);
        return $this;
    }

    public function limit($quantidade)
    {
        static::$queryParts['limit'] = "LIMIT " . intval($quantidade);
        return $this;
    }

    public function get()
    {
        $sql = "SELECT * FROM " . static::$table;

        if (!empty(static::$queryParts['where'])) {
            $sql .= " WHERE " . implode(' AND ', static::$queryParts['where']);
        }

        if (!empty(static::$queryParts['order'])) {
            $sql .= " " . static::$queryParts['order'];
        }

        if (!empty(static::$queryParts['limit'])) {
            $sql .= " " . static::$queryParts['limit'];
        }

        $stmt = self::$pdo->prepare($sql);
        $stmt->execute(static::$bindings);

        static::$queryParts = array();
        static::$bindings = array();

        $resultados = array();
        while ($row = $stmt->fetch()) {
            $resultados[] = new static($row);
        }

        return $resultados;
    }

    public static function count($campo = null, $valor = null)
    {
        $pdo = Database::getInstance();
        $tabela = static::$table;

        if ($campo && $valor !== null) {
            $sql = "SELECT COUNT(*) FROM `$tabela` WHERE `$campo` = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array($valor));
        } else {
            $sql = "SELECT COUNT(*) FROM `$tabela`";
            $stmt = $pdo->query($sql);
        }

        return (int) $stmt->fetchColumn();
    }

    // --- Relacionamentos básicos ---
    public function hasMany($relatedClass, $foreignKey)
    {
        require_once $relatedClass . '.php';
        return call_user_func(array($relatedClass, 'where'), $foreignKey, $this->id)->get();
    }

    public function belongsTo($relatedClass, $foreignKey)
    {
        require_once $relatedClass . '.php';
        return call_user_func(array($relatedClass, 'find'), $this->$foreignKey);
    }

    

    public function gerarUUIDv4() {
        $dados = '';
        for ($i = 0; $i < 16; $i++) {
            $dados .= chr(mt_rand(0, 255));
        }

        // Ajusta os bits conforme a versão e variante
        $dados[6] = chr(ord($dados[6]) & 0x0f | 0x40); // versão 4
        $dados[8] = chr(ord($dados[8]) & 0x3f | 0x80); // variante RFC 4122

        $hex = bin2hex($dados);

        $uuid = sprintf('%s-%s-%s-%s-%s',
            substr($hex, 0, 8),
            substr($hex, 8, 4),
            substr($hex, 12, 4),
            substr($hex, 16, 4),
            substr($hex, 20, 12)
        );

        return $uuid;
    }
}
