<?php
header('Content-Type: application/json');

try {
    $con = require_once('../Controller/controlDB.php');

    if (!$con instanceof PDO) {
        throw new Exception("Database connection failed");
    }

    // Check if search term is provided
    if (isset($_GET['query']) && !empty(trim($_GET['query']))) {
        $query = trim($_GET['query']);

        // Search in artworks (title, description, category)
        $sql = "
            SELECT artworkID, title, [description], catagory, price, rate, [image], artistID
            FROM artworks
            WHERE
                title LIKE :query OR
                [description] LIKE :query OR
                catagory LIKE :query
            ORDER BY rate DESC
            LIMIT 10
        ";

        $stmt = $con->prepare($sql);
        $likeQuery = '%' . $query . '%';
        $stmt->bindParam(':query', $likeQuery, PDO::PARAM_STR);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['status' => 'success', 'data' => $results]);

    } else {
        echo json_encode(['status' => 'empty', 'message' => 'No search query provided.']);
    }

} catch (Exception $e) {
    error_log('Search error: ' . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'Something went wrong. Please try again later.']);
}
