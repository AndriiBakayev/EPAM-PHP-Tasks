<?php

namespace OOP\Patterns\Adapter;

use \OOP\Abstractions\PhysicalBook as PhysicalBookBase;

/**
 * Example of the specific interface applicable for several types of book.
 */
interface EligibleForPrinter {

  /**
   * Prints book content.
   *
   * @return void
   */
    public function printIt();

}

/**
 * Example of the specific interface applicable for several types of book.
 */
interface ForSold {

  /**
   * Mark the book as could be sold.
   *
   * @return bool
   */
  public function sold();

  /**
   * Calculates product price.
   *
   * @return mixed
   */
  public function calculatePrice($product_name);
}

/**
 * The basic class behavior implementation.
 */
class PhysicalBook extends PhysicalBookBase implements ForSold {
  
  /**
   * {@inheritdoc}
   */
  function sold() {
    // @TODO: Implement sold() method.
  }
  
  /**
   * {@inheritdoc}
   */
  public function calculatePrice($product_name) {
    return 'The "' . $product_name . '" book costs: $' . ($this->numberOfPages * 2.5);
  }
}


/**
 * The class to be adapted.
 */
class eBook implements EligibleForPrinter {
  
  /**
   * The number of pages class property.
   *
   * @var int
   */
  protected $numberOfPages;
  
  /**
   * Constructs eBook object.
   *
   * @param int $numberOfPages
   *  The page number of pages
   */
  public function __construct(int $numberOfPages) {
    $this->numberOfPages = $numberOfPages;
  }
  
  /**
   * Performs opening the specified page number.
   *
   * @param int $page_number
   *   The target page number.
   */
  public function goToPage(int $page_number) {
      //@TODO: Implement goToPage() method.
  }
  
  /**
   * {@inheritdoc}
   */
  public function printIt() {
    //@TODO: Implement printIt() method.
  }
}

/**
 * The eBook adapter class example.
 */
class eBookAdapter extends PhysicalBook {
  /**
   * The ebook class instance.
   *
   * @var eBook
   */
  private $ebookInstance;
  
  /**
   * The current page number.
   *
   * @var int
   */
  protected $currentPage = 0;
  
  /**
   * Constructs adapter object.
   *
   * @param int $numberOfPages
   *  The page number of pages
   */
  public function __construct(int $numberOfPages) {
    parent::__construct($numberOfPages);
    $this->ebookInstance = new eBook($numberOfPages);
  }
  
  /**
   * {@inheritdoc}
   */
  public function openNextPage() {
      $this->currentPage++;
      $this->ebookInstance->goToPage($this->currentPage);
  }
  
  /**
   * {@inheritdoc}
   */
  public function openPreviousPage() {
    $this->currentPage--;
    if ($this->currentPage < 0) {
      $this->currentPage = 0;
    }
    $this->ebookInstance->goToPage($this->currentPage);
  }
  
  /**
   * Provides access to original eBook object.
   *
   * @return eBook
   */
  public function getOriginalEbook():eBook {
    return $this->ebookInstance;
  }
  
}

// Default eBook functionality.
$ebook = new eBook(300);
$ebook->printIt();
$ebook->goToPage(1);

// Physical book functionality.
$physical_book = new PhysicalBook(200);
$physical_book->openPreviousPage();
$physical_book->openNextPage();
$physical_book->sold();
print_r($physical_book->getPagesNumber());

// Adapted book functionality.
$adapted_ebook = new eBookAdapter(300);
print_r($adapted_ebook->getPagesNumber());
$adapted_ebook->openNextPage();
$adapted_ebook->openPreviousPage();
$adapted_ebook->sold();
$adapted_ebook->getOriginalEbook()->printIt();
$adapted_ebook->getOriginalEbook()->goToPage(1);


