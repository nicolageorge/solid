<?php
//http://code.tutsplus.com/tutorials/solid-part-2-the-openclosed-principle--net-36600

// Software entities (classes, modules, functions, etc.) should be open for extension, but closed for modification.


/*The User class uses the Logic class directly. If we need to implement a second Logic class in a way that will allow us to use both
the current one and the new one, the existing Logic class will need to be changed. User is directly tied to the implementation of
Logic, there is no way for us to provide a new Logic without affecting the current one. And when we are talking about statically
typed languages, it is very possible that the User class will also require changes. If we are talking about compiled languages,
most certainly both the User executable and the Logic executable or dynamic library will require recompilation and
redeployment to our clients, a process we want to avoid whenever possible.*/




/*Let's say we want to write a class that can provide progress as a percent for a
file that is downloaded through our application. We will have two main classes, a
Progress and a File, and I imagine we will want to use them like in the test below. */



/* The File class is just a simple data object containing the two fields. Of course in real life, it would probably contain other information and behavior also, like file name, path, relative path, current directory, type, permissions and so on. */
class File {
    public $length;
    public $sent;
}

/* Progress is simply a class taking a File in its constructor. For clarity, we specified the type of the variable in the constructor's parameters. There is a single useful method on Progress, getAsPercent(), which will take the values sent and length from File and transform them into a percent. Simple, and it works.*/
class Progress {
    private $file;

    function __construct(File $file) {
        $this->file = $file;
    }

    function getAsPercent() {
        return $this->file->sent * 100 / $this->file->length;
    }

}

/* In this test we are a user of Progress. We want to obtain a value as a percent, regardless of the actual file size. We use File as the source of information for our Progress. A file has a length in bytes and a field called sent representing the amount of data sent to the one doing the download. We do not care about how these values are updated in the application. We can assume there is some magical logic doing it for us, so in a test we can set them explicitly. */
function testItCanGetTheProgressOfAFileAsAPercent() {
    $file = new File();
    $file->length = 200;
    $file->sent = 100;

    $progress = new Progress($file);

    $this->assertEquals(50, $progress->getAsPercent());
}











/*Changing Requirements
Every application that is expected to evolve in time will need new features. One new feature for our application could be to allow streaming of music,
instead of just downloading files. File's length is represented in bytes, the music's duration in seconds. We want to offer a nice progress bar to our listeners, but can we reuse the one we already have?

No, we can not. Our progress is bound to File. It understands only files, even though it could be applied to music content also.
But in order to do that we have to modify it, we have to make Progress know about Music and File. If our design would respect OCP,
we would not need to touch File or Progress. We could just simply reuse the existing Progress and apply it to Music. */




// Solution 1 - no more typehinting, now we can throw everything in the class
class Progress {
    private $file;

    function __construct($file) {
        $this->file = $file;
    }

    function getAsPercent() {
        return $this->file->sent * 100 / $this->file->length;
    }
}


class Music {
    public $length;
    public $sent;

    public $artist;
    public $album;
    public $releaseDate;

    function getAlbumCoverFile() {
        return 'Images/Covers/' . $this->artist . '/' . $this->album . '.png';
    }
}


function testItCanGetTheProgressOfAMusicStreamAsAPercent() {
    $music = new Music();
    $music->length = 200;
    $music->sent = 100;

    $progress = new Progress($music);

    $this->assertEquals(50, $progress->getAsPercent());
}

// new progress class, with good names
class Progress {

    private $measurableContent;

    function __construct($measurableContent) {
        $this->measurableContent = $measurableContent;
    }

    function getAsPercent() {
        return $this->measurableContent->sent * 100 / $this->measurableContent->length;
    }

}

// NEW PROBLEM, everything that uses the Progress class, should have SENT and LENGTH properties
// If class is called with a string, a generic error is produced which may be hard to debug












// Solution 2 - Strategy Design Patern
interface Measurable {
    function getLength();
    function getSent();
}

class File implements Measurable {

    private $length;
    private $sent;

    public $filename;
    public $owner;

    function setLength($length) {
        $this->length = $length;
    }

    function getLength() {
        return $this->length;
    }

    function setSent($sent) {
        $this->sent = $sent;
    }

    function getSent() {
        return $this->sent;
    }

    function getRelativePath() {
        return dirname($this->filename);
    }

    function getFullPath() {
        return realpath($this->getRelativePath());
    }

}

class Progress {

    private $measurableContent;

    function __construct(Measurable $measurableContent) {
        $this->measurableContent = $measurableContent;
    }

    function getAsPercent() {
        return $this->measurableContent->getSent() * 100 / $this->measurableContent->getLength();
    }

}

function testItCanGetTheProgressOfAFileAsAPercent() {
    $file = new File();
    $file->setLength(200);
    $file->setSent(100);

    $progress = new Progress($file);

    $this->assertEquals(50, $progress->getAsPercent());
}




