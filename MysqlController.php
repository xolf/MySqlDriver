<?php

class ownMysql
{
    private $host;
    private $user;
    private $password;
    private $database;
    private $port;
    private $unitTest;
    private $connection;
    private $table;
    private $opts;
    private $collectData;

    /**
     * @param $host
     * @param $user
     * @param $password
     * @param $database
     * @param int $port
     * @param array $opts
     */
    public function __construct($host, $user, $password, $database, $port = 3306, array $opts = array())
    {

        $this->opts['collect'] = FALSE;

        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->database = $database;
        $this->port = $port;

        if(isset($opts['collect'])) $this->opts['collect'] = $opts['collect'];

        $this->unitTest = FALSE;



    }

    /**
     * @throws ownException
     */
    public function checkConnection()
    {

        if (mysqli_error($this->connection())) {

            throw new ownException(mysqli_error($this->connection()));

        }

    }

    /**
     * @throws ownException
     */
    public function __destruct()
    {

        if ($this->opts['collect']) $this->query($this->collectData);

    }

    /**
     *
     */
    public function unitTest()
    {

        $this->unitTest = TRUE;

    }

    /**
     * @throws ownException
     */
    public function connect()
    {

        $this->connection = mysqli_connect(
            $this->host,
            $this->user,
            $this->password,
            $this->database,
            $this->port);

        $this->checkConnection();

    }

    public function connection()
    {

        return $this->connection;

    }

    /**
     * @param $testType
     * @return string
     */
    public function test($testType)
    {

        if ($testType == 'CONNECTION' && $this->connection() != '') return $this->connection();

        if ($testType == 'DATA_CONNECTION' && $this->unitTest) {

            return "mysql://" . $this->user . ":" . $this->password . "@" . $this->host . "/" . $this->database . ":" . $this->port;

        }

        if ($testType == 'TABLE') return $this->table;


    }

    /**
     * @param $query
     * @throws ownException
     */
    public function query($query)
    {

        $query = mysqli_query($this->connection(), $query);

        $this->checkConnection();

        return $query;

    }

    /**
     * @param bool $tableName
     * @return string
     */
    public function table($tableName = FALSE)
    {

        if(!$tableName) return $this->table;

        $this->table = $tableName;

    }

    /**
     * @param $var
     */
    public function debug($var)
    {

        var_dump($var);

    }

    /**
     * @param array $data
     * @param bool $table
     * @return string
     */
    public function insert(array $data, $table = FALSE)
    {

        if ($table !== FALSE) $this->table = $table;


        if ($this->opts['collect']) echo NULL;

        $i = 0;

        foreach ($data as $row => $content) {

            $rows[$i] = "`" . $row . "`";

            if ($content == NULL) $values[$i] = "NULL";
            else $values[$i] = "'" . $content . "'";

            $i++;

        }

        $query = "INSERT INTO `" . $this->database . "`.`" . $this->table . "` ";

        $query .= "(" . implode(', ', $rows) . ") ";

        $query .= "VALUES (" . implode(', ', $values) . ");";

        if($this->unitTest) return $query;

        if (!$this->opts['collect']) $this->query($query);
        else $this->collectData .= "\n" . $query;

        return NULL;

    }


}
