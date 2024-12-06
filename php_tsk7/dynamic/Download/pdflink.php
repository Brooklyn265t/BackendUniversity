<?php
class PdfLink {
    private $id;
    private $filename;

    public function __construct($id, $filename) {
        $this->id = $id;
        $this->filename = $filename;
    }

    public function getHref() {
        return "download.php?id=" . $this->id;
    }

    public function getFilename() {
        return htmlspecialchars($this->filename);
    }
}
?>