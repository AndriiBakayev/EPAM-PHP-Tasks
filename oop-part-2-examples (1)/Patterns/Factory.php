<?php

namespace OOP\Patterns\Factory;

use OOP\Patterns\Adapter\ForSold;
use OOP\Patterns\Adapter\PhysicalBook;
use OOP\Patterns\Adapter\eBookAdapter;

/**
 * Demonstrates an example of building abstract product object.
 */
class Product {
  
  /**
   * The product name.
   *
   * @var string
   */
  private $name;

  /**
   * The real product object.
   *
   * @var ForSold
   */
  private $productObject;

  /**
   * Builds product object.
   *
   * @param string $name
   *   The product's name.
   * @param ForSold $productObject
   *   The target product object.
   */
  public function __construct(string $name, ForSold $productObject) {
    $this->name = $name;
    $this->productObject = $productObject;
  }

  /**
   * Calculates product price.
   *
   * @return mixed
   */
  public function calculatePrice() {
    return $this->productObject->calculatePrice($this->name);
  }
    
}

/**
 * Produces product objects according to the input values.
 */
class ProductFactory {
  
  /**
   * Creates the object acccrding to the input values.
   *
   * @param string $name
   *   The product name value.
   * @param string $product_type
   *   The product type to select the object to be created.
   *
   * @return bool|Product|string
   *   Returns the generated product object.
   */
  public function create(string $name, string $product_type = 'physical') {
    switch ($product_type) {
      case 'physical':
        $product_object = new PhysicalBook(300);
        return new Product($name, $product_object);

      case 'digital':
        $product_object = new eBookAdapter(200);
        return new Product($name, $product_object);
    }
    return print_r('Could not create the product from provisioned values.');
  }
}

// Initialize products.
$factory = new ProductFactory();
$productA = $factory->create('Tom & Jerry adventures');
$productB = $factory->create('Lonely Tunes comics', 'digital');

// Calculate product price.
print_r($productA->calculatePrice());
print_r($productB->calculatePrice());
