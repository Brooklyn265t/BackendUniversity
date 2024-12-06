<?php
class PdfManager {
    private $conn;

    public function __construct(DatabaseConnection $conn) {
        $this->conn = $conn;
    }

    public function get_file($id) {
        $sql = "SELECT filename, mimetype, data FROM pdf WHERE id = ?";
        $result = $this->conn->query($sql, ['i' => $id]);
        if ($row = $result->fetch_assoc()) {
            return new DownloadResponse($row['filename'], $row['mimetype'], $row['data']);
        } else {
            throw new Exception("File not found");
        }
    }

    public function display_pdf_list() {
        $sql = "SELECT id, filename FROM pdf";
        $result = $this->conn->query($sql);
        if ($result !== false && $result->num_rows > 0) {
            $pdfList = [];
            while ($row = $result->fetch_assoc()) {
                $pdfList[] = new PdfLink($row['id'], $row['filename']);
            }
            return $pdfList;
        } else {
            throw new Exception("No PDF files available for download");
        }
    }
}

?>