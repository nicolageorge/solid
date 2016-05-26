 <!DOCTYPE html>
<html>
<head>
<title>Solid Principles</title>
</head>

<body>
<a href="docs/singleresp.html">Docs</a>
<?php
// http://code.tutsplus.com/tutorials/solid-part-1-the-single-responsibility-principle--net-36074


// Example 1

// Audience - Book Mangement, Data presentation Mechanism

// Mixes business logic with presentation
class Book {

    function getTitle() {
        return "A Great Book";
    }

    function getAuthor() {
		return "George Nicola";
    }

    function turnPage() {
        // pointer to next page
    }

    function printCurrentPage() {
        echo "current page content";
    }
}

// Example 1 with Single Responsibility
class Book{
	function getTitle(){
		return "A great book";
	}

	function getAuthor(){
		return "George Nicola";
	}

	function turnPage(){
		//pointer to next page;
	}

	function getCurrentPage(){
		return "current page content";
	}
}

interface Printer{
	function printPage( $page );
}

class PlainTextPrinter implements Printer{
	function printPage( $page ){
		echo $page;
	}
}

class HtmlPrinter implements Printer{
	function printPage( $page ){
		echo '<div class="single-page">' . $page . '</div>';
	}
}




















// Example 2 - Objects that can save themselves
class Book {

    function getTitle() {
        return "A Great Book";
    }

    function getAuthor() {
        return "John Doe";
    }

    function turnPage() {
        // pointer to next page
    }

    function getCurrentPage() {
        return "current page content";
    }

    function save() {
        $filename = '/documents/'. $this->getTitle(). ' - ' . $this->getAuthor();
        file_put_contents($filename, serialize($this));
    }

}
/*
Moving the persistence operation to another class will clearly separate the responsibilities and we will be free to
exchange persistence methods without affecting our Book class. For example implementing a DatabasePersistence
class would be trivial and our business logic built around operations with books will not change.
*/


















// Example 3
class Book {

    function getTitle() {
        return "A Great Book";
    }

    function getAuthor() {
        return "John Doe";
    }

    function turnPage() {
        // pointer to next page
    }

    function getCurrentPage() {
        return "current page content";
    }

    function getLocation() {
        // returns the position in the library
        // ie. shelf number & room number
    }
}
/* Now this may appear perfectly reasonable. We have no method dealing with persistence, or presentation. We have our turnPage() functionality and a few methods to
provide different information about the book. However, we may have a problem. To find out, we might want to analyze our application. The function getLocation() may be the problem.

All of the methods of the Book class are about business logic. So our perspective must be from the business's point of view. If our application
is written to be used by real librarians who are searching for books and giving us a physical book, then SRP might be violated.

We can reason that the actor operations are the ones interested in the methods getTitle(), getAuthor() and getLocation(). The clients may also
have access to the application to select a book and read the first few pages to get an idea about the book and decide if they want it or not.
So the actor readers may be interested in all the methods except getLocations(). An ordinary client doesn't care where the book is kept in the library.
The book will be handed over to the client by the librarian. So, we do indeed have a violation of SRP. */



// Example 3 With SRP
class Book {

    function getTitle() {
        return "A Great Book";
    }

    function getAuthor() {
        return "John Doe";
    }

    function turnPage() {
        // pointer to next page
    }

    function getCurrentPage() {
        return "current page content";
    }

}

class BookLocator {

    function locate(Book $book) {
        // returns the position in the library
        // ie. shelf number & room number
        $libraryMap->findBookBy($book->getTitle(), $book->getAuthor());
    }

}
/* Introducing the BookLocator, the librarian will be interested in the BookLocator. The client will be interested in the Book only. Of course,
there are several ways to implement a BookLocator. It can use the author and title or a book object and get the required information from the Book.
It always depends on our business. What is important is that if the library is changed, and the librarian will have to find books in a differently organized
library, the Book object will not be affected. In the same way, if we decide to provide a pre-compiled summary to the readers instead of letting them
browse the pages, that will not affect the librarian nor the process of finding the shelf the books sits on.

However, if our business is to eliminate the librarian and create a self-service mechanism in our library, then
we may consider that SRP is respected in our first example. The readers are our librarians also, they need to go and find
the book themselves and then check it out at the automated system. This is also a possibility. What is important to remember
here is that you must always consider your business carefully. */


?>
</body>

</html>
