<?php

namespace OOP\Patterns\Singleton;

/**
 * Definition of the abstract Singleton object.
 */
abstract class Singleton {
  /**
   * The singleton object instance.
   *
   * @var Singleton
   */
  protected static $instance;

  /**
   * Constructs singleton object, add this method if necessary.
   * However, it should not be available for getting an instance of the class, use ::getInstance() instead.
   */
  protected function __construct()
  {
      //mock
  }

  /**
   * Return the instance of class. There could be only one instance of the object across the system.
   * If the object is already exists, method below should return it, otherwise method will return a new object instance.
   *
   * @return mixed
   */
  abstract public static function getInstance();
}

/**
 * The example of classical singleton object.
 */
class DbConnection extends Singleton {
  /**
   * Returns the object instance.
   *
   * @return DbConnection
   */
  public static function getInstance():DbConnection {
    if (!self::$instance) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  /**
   * Check if the connection is initialized.
   *
   * @return bool
   */
  private function isDbInitialized():bool {
    return !empty(self::$instance);
  }

  /**
   * Executes the DB query.
   *
   * @param string $query
   *   The SQL query string.
   * @return array
   *   Returns executed query results.
   */
  public function executeQuery(string $query) {
    $results = [];
    if ($this->isDbInitialized()) {
      try {
        $results = $this->query($query);
      }
      catch (\SQLiteException $db_exception) {
        $results['error'] = $db_exception->getCode() . $db_exception->getMessage();
        //@TODO: Implement your code here.
      }
      catch (\Exception $general_exception) {
        $results['error'] = $general_exception->getCode() . $general_exception->getMessage();
        //@TODO: Implement your code here.
      }
    }
    return $results;
  }

  /**
   * Executes the SQL query.
   *
   * @param string $query_string
   *   The SQL query string.
   * @return array
   *   Returns executed query results.
   */
  private function query(string $query_string) {
    //@TODO: Implement your code here.
    return [];
  }
  
}


// Initialize the DBConnection object.
$dbConnection1 = DbConnection::getInstance();
// Try to initialize the secondary connection.
$dbConnection2 = DbConnection::getInstance();

// The connection objects should be equal.
//$dbConnection1===$dbConnection2

$dbConnection1->executeQuery('select * from books;');
$dbConnection2->executeQuery('select * from quiz_results;');
