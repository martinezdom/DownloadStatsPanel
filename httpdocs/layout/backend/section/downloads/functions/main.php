<?php

function getDownloads($id = null)
{
    global $link;

    $sql = "
    SELECT 
        document_id, COUNT(*) AS total 
    FROM 
        downloads
    ";

    if ($id !== null) {
        $sql .= " WHERE document_id = $id";
    }

    $sql .= "
    GROUP BY 
        document_id
    ";
    $result = mysqli_query($link, $sql);

    $downloads = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $downloads[] = $row;
    }

    if ($id !== null) {
        return isset($downloads[0]['total']) ? $downloads[0]['total'] : 0;
    }

    return $downloads;
}

function getDownloadsTable($order = 'ASC', $limit = null)
{
    global $link;

    $sql = "
        SELECT
            do.id, d.id AS document_id, d.code, do.date_time
        FROM
            downloads do
        JOIN 
            documents d ON d.id = do.document_id
        GROUP BY
            do.id
        ORDER BY
            do.date_time $order
    ";

    if ($limit !== null && is_numeric($limit)) {
        $sql .= " LIMIT " . $limit;
    }

    $result = mysqli_query($link, $sql);
    $downloads = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $downloads[] = $row;
    }
    return $downloads;
}

function getDateWithMostDownloads()
{
    global $link;
    $sql = "
        SELECT
            DATE(do.date_time) AS date, 
            COUNT(*) AS total
        FROM
            downloads do
        GROUP BY
            date
        ORDER BY
            total DESC
        LIMIT 1
    ";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row;
}

function getMostDownloadedDocument()
{
    global $link;
    $sql = "
        SELECT
            d.code AS document_code, 
            COUNT(*) AS total,
            d.id AS document_id
        FROM
            downloads do
        JOIN
            documents d ON d.id = do.document_id
        GROUP BY
            d.id
        ORDER BY
            total DESC
        LIMIT 1
    ";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row;
}

function getDownloadsGroupedByDate()
{
    global $link;
    $sql = "
        SELECT 
            DATE(date_time) AS download_date, 
            COUNT(*) AS total_downloads
        FROM 
            downloads
        GROUP BY 
            download_date
        ORDER BY 
            download_date ASC
    ";
    $result = mysqli_query($link, $sql);
    $downloads = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $downloads[] = $row;
    }
    return $downloads;
}

function getDownloadsByDocumentInRange($startDate, $endDate)
{
    global $link;

    $sql = "
        SELECT d.code, d.id, COUNT(*) AS total
        FROM downloads do
        JOIN documents d ON d.id = do.document_id
        WHERE do.date_time >= '{$startDate} 00:00:00'
          AND do.date_time <= '{$endDate} 23:59:59'
        GROUP BY d.id
    ";
    $result = mysqli_query($link, $sql);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function getDownloadsByDayAndDocumentId($day, $documentId)
{
    global $link;
    $sql = "
        SELECT
            *
        FROM
            downloads do
        WHERE
            do.document_id = $documentId AND DATE(do.date_time) = '$day'
    ";
    $result = mysqli_query($link, $sql);
    $downloads = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $downloads[] = $row;
    }
    return $downloads;
}

function getDownloadsByDateRange($documentId)
{
    global $link;

    $sql = "
        SELECT 
            DATE(do.date_time) AS download_date, 
            COUNT(*) AS total_downloads
        FROM 
            downloads do
        WHERE 
            do.document_id = $documentId
        GROUP BY 
            download_date
        ORDER BY 
            download_date ASC
    ";

    $result = mysqli_query($link, $sql);

    $downloadsByDate = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $downloadsByDate[] = $row;
    }

    return $downloadsByDate;
}

function getDayWithMostDownloadsByDocumentId($id)
{
    global $link;
    $sql = "
        SELECT 
            DATE(date_time) as day
        FROM 
            downloads do
        JOIN 
            documents d ON d.id = do.document_id
        WHERE 
            d.id = $id
        GROUP BY 
            day
        ORDER BY 
            COUNT(*) DESC
        LIMIT 
            1
    ";
    $result = mysqli_query($link, $sql);
    $day = mysqli_fetch_assoc($result);
    return $day;
}

function getTotalDownloads()
{
    global $link;

    $sql = "
    SELECT 
        COUNT(*) AS total 
    FROM 
        downloads
    ";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);

    return $row['total'];
}

function totalDownloadsByCity()
{
    global $link;
    $sql = "
    SELECT 
        c.name, COUNT(do.id) AS total
    FROM 
        downloads do
    RIGHT JOIN 
        documents d ON d.id = do.document_id
    RIGHT JOIN 
        cities c ON c.id = d.city_id
    GROUP BY 
        c.name
    ORDER BY 
        total DESC
    ";
    $result = mysqli_query($link, $sql);
    $downloads = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $downloads[] = $row;
    }
    return $downloads;
}

function getDownloadsEvolutionByDocuments($documentIds)
{
    global $link;
    $ids = implode(',', $documentIds);
    $sql = "
        SELECT 
            DATE(do.date_time) AS date,
            do.document_id,
            COUNT(*) AS total
        FROM downloads do
        WHERE do.document_id IN ($ids)
        GROUP BY date, do.document_id
        ORDER BY date ASC
    ";
    $result = mysqli_query($link, $sql);
    $evolution = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $evolution[] = $row;
    }
    return $evolution;
}

function getDownloadsByHourForDocuments($documentIds)
{
    global $link;
    if (empty($documentIds)) {
        return [];
    }
    $ids = implode(',',  $documentIds);
    $sql = "
        SELECT 
            HOUR(do.date_time) AS hour,
            COUNT(*) AS total
        FROM downloads do
        WHERE do.document_id IN ($ids)
        GROUP BY hour
        ORDER BY hour ASC
    ";
    $result = mysqli_query($link, $sql);
    $downloads = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $downloads[] = $row;
    }
    return $downloads;
}

function getDownloadsByMonth($documentId)
{
    global $link;
    $sql = "
        SELECT 
            DATE_FORMAT(do.date_time, '%Y-%m') AS month,
            COUNT(*) AS total
        FROM 
            downloads do
        WHERE 
            do.document_id = $documentId
        GROUP BY 
            month
        ORDER BY 
            month ASC
    ";
    $result = mysqli_query($link, $sql);
    $downloads = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $downloads[] = $row;
    }
    return $downloads;
}

?>
