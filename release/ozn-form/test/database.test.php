<?php namespace OznForm;

require dirname(__FILE__) . "/../release/lib/Database.class.php";


class DatabaseTest {


    function __construct()
    {
        $this->subject = new Database();
    }

    private function assertEquals($expect, $value)
    {
        $bt     = debug_backtrace();
        $method = $bt[1]['function'];
        $line   = $bt[0]['line'];

        if($expect === $value) {
            echo '.';
        } else {
            echo "\n\e[0;31m$line: $method Failure:\n-- expect[$expect]\n-- get[$value]\033[0m\n";
        }
    }

    public function run()
    {
        foreach ( get_class_methods(__CLASS__) as $method) {
            if(preg_match("/^test/", $method))
            {
                $this->$method();
            }
        };
    }


    function testDatabaseConfig() {

        $this->assertEquals('tegera', 'grea');
    }

}



$test = new DatabaseTest();


$test->run();



