<?php
class PDFBook {
    function read() {
        return "reading a pdf book.";
    }
}

class PDFReader {
    private $book;

    function __construct(PDFBook $book) {
        $this->book = $book;
    }

    function read() {
        return $this->book->read();
    }
}


class Test extends PHPUnit_Framework_TestCase {

    function testItCanReadAPDFBook() {
        $b = new PDFBook();
        $r = new PDFReader($b);

        $this->assertRegExp('/pdf book/', $r->read());
    }

}

/* We start developing our e-reader as a PDF reader. So far so good. We have a PDFReader class using a PDFBook. The read() function on the reader
delegates to the book's read() method. We just verify this by doing a regex check after a key part of the string returned by PDFBook's reader() method. */

/* Acceptable solution if you want to write a PDFReader and nothing more */



/*NOW let's say we want an ebook reader, which reads a pdf book */
class PDFBook {
    function read() {
        return "reading a pdf book.";
    }
}

class EBookReader {
    private $book;

    function __construct(PDFBook $book) {
        $this->book = $book;
    }

    function read() {
        return $this->book->read();
    }
}

class Test extends PHPUnit_Framework_TestCase {
    function testItCanReadAPDFBook() {
        $b = new PDFBook();
        $r = new EBookReader($b);

        $this->assertRegExp('/pdf book/', $r->read());
    }
}

/* BIG design defect, we have a generic EBookReader which only accepts PDFBooks = AN ABSTRACTION DEPENDS ON THE DETAIL
The fact that our book is PDF should be a detail and no one should depend on it */



/* MOST COMMON SOLUTION TO INVERT DEPENDENCY = Introduce a more abstract module in the design*/
interface EBook {
    function read();
}

class PDFBook implements EBook{
    function read() {
        return "reading a pdf book.";
    }
}

class EBookReader {
    private $book;

    function __construct(EBook $book) {
        $this->book = $book;
    }

    function read() {
        return $this->book->read();
    }
}

class Test extends PHPUnit_Framework_TestCase {
    function testItCanReadAPDFBook() {
        $b = new PDFBook();
        $r = new EBookReader($b);

        $this->assertRegExp('/pdf book/', $r->read());
    }
}
/* An interface was created, Ebook, representing the needs of EBookReader ( direcct result of respecting Interface Segregation Principle - Interface should reflect the needs of the clients,
Interfaces belong to the clients so they are named to reflect types and objects the clients need and contain methods the client wants to use)


/* Now we have 2 dependancies */
/* 1. From EbookReader to Ebook interface and it's type of usage
   2. From PDFBook to Ebook Interface, but it's of type IMPLEMENTATION. A PDFBook is a type of Ebook, thus implements that interface to satisfy the client needs.
   */



/* This solution allows to plug in different types of ebooks in the reader, Single condition is to implement the Ebook interface. */
interface EBook {
    function read();
}

class PDFBook implements EBook {
    function read() {
        return "reading a pdf book.";
    }
}

class MobiBook implements EBook {
    function read() {
        return "reading a mobi book.";
	}
}


class EBookReader {
    private $book;

    function __construct(EBook $book) {
        $this->book = $book;
    }

    function read() {
        return $this->book->read();
    }
}

class Test extends PHPUnit_Framework_TestCase {
    function testItCanReadAPDFBook() {
        $b = new PDFBook();
        $r = new EBookReader($b);

        $this->assertRegExp('/pdf book/', $r->read());
    }

    function testItCanReadAMobiBook() {
        $b = new MobiBook();
        $r = new EBookReader($b);

        $this->assertRegExp('/mobi book/', $r->read());
    }
}
/* This satisfies the Open/CLosed principle,*/
















