<?php

namespace OOP\Patterns\Observer;

/**
 * The observer manager class example.
 */
class ObserverManager {
  /**
   * The events list.
   *
   * @var Observer[]
   */
  protected static $events = [];
  
  /**
   * Add an observer for listening.
   *
   * @param string $eventName
   *   The event name to listen.
   * @param Observer $observer
   *    The observer object to be assigned.
   *
   * @return void
   */
  public static function addObserver(string $eventName, Observer $observer) {
      self::$events[$eventName][] = $observer;
  }
  
  /**
   * The function to trigger the event.
   *
   * @param string $eventName
   *   The event name to trigger.
   * @param mixed $data
   *   The event data to be handled.
   *
   * @return void
   */
  public static function dispatchEvent(string $eventName, $data) {
    if (isset(self::$events[$eventName])) {
      foreach (self::$events[$eventName] as $observer) {
        $observer->execute($data);
      }
    }
  }

}

/**
 * The observer class implementation example.
 */
class Observer {
  
  /**
   * Performs operations with a given data.
   *
   * @param mixed $data
   *   The data to be handled.
   * @return void
   */
  public function execute($data) {
    //@TODO: Implement the execute() method.
  }

}

/**
 * The example of the class which is trigger the event.
 */
class UserManager {
  
  /**
   * Register the user with a given email and password. Performs post-register operations.
   *
   * @param string $email
   *   The user email input value.
   * @param string $password
   *   The user password input value.
   * @return void
   */
  public function register(string $email, string $password) {
    // Create user in DB.
    ObserverManager::dispatchEvent('create_user', $this);
    // Add it to the regular mailing list.
    ObserverManager::dispatchEvent('add_to_mailing_list', $this);
  }

}

// Initialize the observer clients.
$create_user_observer = new Observer();
$add_to_mailing_list_observer = new Observer();
ObserverManager::addObserver('create_user', $create_user_observer);
ObserverManager::addObserver('add_to_mailing_list', $add_to_mailing_list_observer);

// Initialize user manager class.
$userManager = new UserManager();
// Perform register action.
$userManager->register('fake@fake.com', 123456);