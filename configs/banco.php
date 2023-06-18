<?php
class Banco
{
    	
	// private static $dbNome = getenv('MYSQL_DATABASE');
    // private static $dbHost = getenv('MYSQL_HOST');
    // private static $dbUsuario = getenv('MYSQL_USER');
    // private static $dbSenha = getenv('MYSQL_PASSWORD');
    
    private static $cont = null;
    
    public function __construct() 
    {
        die('A função Init nao é permitido!');
        
    }
    
    public static function conectar()
    {
        if(null == self::$cont)
        {
            try
            {   
                if (file_exists(__DIR__ . '/.env')) {
                    $dotenvPath = __DIR__ . '/.env';
                    $dotenv = parse_ini_file($dotenvPath);
                    foreach ($dotenv as $key => $value) {
                        putenv("$key=$value");
                    }
                }
                $dbHost   = getenv('MYSQL_HOST');
                $dbNome   = getenv('MYSQL_DATABASE');
                $dbUsuario   = getenv('MYSQL_USER');
                $dbSenha   = getenv('MYSQL_PASSWORD');
                // localhost do the following
                self::$cont =  new PDO( "mysql:host=".$dbHost.";"."dbname=".$dbNome, $dbUsuario, $dbSenha); 
            }
            catch(PDOException $exception)
            {
                die($exception->getMessage());
            }
        }
        return self::$cont;
    }
    
    public static function desconectar()
    {
        self::$cont = null;
    }
}

?>
