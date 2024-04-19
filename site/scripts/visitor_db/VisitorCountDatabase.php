<?php


require ('Entry.php');

class VisitorCountDatabase
{
    private $fd;
    private $filesize;

    private function seek_to(int $idx) : void
    {
        fseek($this->fd, $idx + 1);
    }

    private function get_free_entry_idx() : int
    {
        fseek($this->fd, 0);
        return intval(fread($this->fd, PHP_INT_SIZE));
    }

    function __construct(string $fileLocation) {
        $this->fd = fopen($fileLocation, "rb+");
        $this->filesize = filesize($fileLocation);
    }

    function __destruct() {
        $this->fd = fclose($this->fd);
    }

    function insert_entry(Entry $entry) : void {
        if($this->get_free_entry_idx() >= ($this->filesize/PHP_INT_SIZE) - 1) {
            // Seek to end of file, write
            fseek($this->fd, 0, SEEK_END);

            return;
        }

        $this->seek_to($this->get_free_entry_idx());
        $new_entry = new Entry();
        $new_entry->copy_from($this->fd);

        $entry->write_value($this->fd);
        fseek($this->fd, 0);
        $new_entry->write_value($this->fd);
    }

    function delete_entry() {

    }

    function modify_entry(int $idx, Entry $entry) {

    }

    function read_entry(int $idx) : Entry {
        $this->seek_to($idx);
        $entry = new Entry();
        $entry->copy_from($this->fd, false);
        return $entry;
    }
}