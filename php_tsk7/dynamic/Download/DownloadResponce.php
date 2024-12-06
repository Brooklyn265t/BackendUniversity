<?php

class DownloadResponse
{
    private $filename;
    private $mimetype;
    private $data;

    public function __construct($filename, $mimetype, $data)
    {
        $this->filename = $filename;
        $this->mimetype = $mimetype;
        $this->data = $data;
    }

    public function send()
    {
        header('Content-Description: File Transfer');
        header('Content-Type: ' . $this->mimetype);
        header('Content-Disposition: attachment; filename="' . basename($this->filename) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . strlen($this->data));

        echo $this->data;
        exit;
    }
}

?>