<?php
class DATABASE_CONFIG {
        
        //Localhost
public $default = array(
  'datasource' => 'Database/Mysql',
  'persistent' => false,
  'host' => 'localhost',
  'login' => 'root',
  'password' => '',
  'database' => 'inmosystem'
);
        
// RDS AWS Amazon
/*public $default = array(
  'datasource' => 'Database/Mysql',
  'persistent' => false,
  'host' => 'inmosystem.cnhu5xayixb1.us-east-1.rds.amazonaws.com',
  'login' => 'admina',
  'password' => 'adminAigel',
  'database' => 'inmosystem'
);*/
        
        //Dragon
        /*public $default = array(
        'datasource' => 'Database/Mysql',
        'persistent' => false,
        'host' => 'localhost',
        'login' => 'inmosystem',
        'password' => 'Inmosystem.2018',
        'database' => 'inmosystem'
	);*/
}
