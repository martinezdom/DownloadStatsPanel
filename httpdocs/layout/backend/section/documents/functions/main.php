<?php

function getDocuments($id = null)
{
    global $link;
    $sql = "SELECT * FROM documents";
    if ($id !== null) {
        $sql .= " WHERE id = " . $id;
    }
    $result = mysqli_query($link, $sql);
    if ($id !== null) {
        return mysqli_fetch_assoc($result);
    }
    $documents = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $documents[] = $row;
    }
    return $documents;
}

function getDocumentListFormattedToTable($order = 'ASC', $limit = null, $orderBy = 'date')
{
    global $link;

    if ($orderBy == "date") {
        $orderBy = "d.date";
    }

    $sql = "
    SELECT 
        d.id,
        d.code,
        d.date,
        p.name AS place_name,
        c.name AS city_name,
        COUNT(do.id) AS downloads,
        d.description
    FROM 
        documents d
    LEFT JOIN 
        places p ON p.id = d.place_id
    LEFT JOIN
        cities c ON c.id = d.city_id
    LEFT JOIN
        downloads do ON do.document_id = d.id
    GROUP BY 
        d.id
    ORDER BY
        $orderBy $order
    ";

    if ($limit !== null && is_numeric($limit)) {
        $sql .= " LIMIT " . $limit;
    }
    $result = mysqli_query($link, $sql);

    $documents = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $documents[] = $row;
    }

    return $documents;
}

function getPlaceNameByPlaceId($id)
{
    global $link;
    $sql = "
    SELECT 
        p.name
    FROM 
        documents d
    JOIN 
        places p ON p.id = d.place_id
    WHERE 
        p.id = $id
    ";
    $result = mysqli_query($link, $sql);
    $place = mysqli_fetch_assoc($result);
    return $place['name'];
}

function getCityNameByCityId($id)
{
    global $link;
    $sql = "
    SELECT 
        c.name
    FROM 
        documents d
    JOIN 
        cities c ON c.id = d.city_id
    WHERE 
        c.id = $id
    ";
    $result = mysqli_query($link, $sql);
    $city = mysqli_fetch_assoc($result);
    return $city['name'];
}

function getTotalDocuments()
{
    global $link;

    $sql = "
    SELECT 
        COUNT(*) AS total 
    FROM 
        documents
    ";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);

    return $row['total'];
}

function getDownloadsByDocumentIds($documentIds)
{
    global $link;
    if (empty($documentIds)) {
        return [];
    }
    $ids = implode(',', $documentIds);
    $sql = "
        SELECT 
            d.id, d.code, COUNT(do.id) AS total
        FROM documents d
        LEFT JOIN downloads do ON do.document_id = d.id
        WHERE d.id IN ($ids)
        GROUP BY d.id
    ";
    $result = mysqli_query($link, $sql);
    $downloads = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $downloads[] = $row;
    }
    return $downloads;
}

function getAllPlaces()
{
    global $link;
    $sql = "
    SELECT 
        id, name, city_id
    FROM 
        places
    ";
    $result = mysqli_query($link, $sql);
    $places = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $places[] = $row;
    }
    return $places;
}

function getAllCities()
{
    global $link;
    $sql = "
    SELECT 
        id, name 
    FROM 
        cities
    ";
    $result = mysqli_query($link, $sql);
    $cities = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $cities[] = $row;
    }
    return $cities;
}

function getPlacesByCityId($cityId)
{
    global $link;
    $sql = "
    SELECT 
        id, name 
    FROM 
        places
    WHERE 
        city_id = $cityId
    ";
    $result = mysqli_query($link, $sql);
    $places = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $places[] = $row;
    }
    return $places;
}

function addDocument($code, $date = '', $place_id = null, $city_id = null, $description = '')
{
    global $link;
    if (empty($code)) {
        return false;
    }

    $date_sql = $date !== '' ? "'$date'" : "NULL";
    $place_sql = $place_id !== null && $place_id !== '' ? $place_id : "NULL";
    $city_sql = $city_id !== null && $city_id !== '' ? $city_id : "NULL";
    $desc_sql = $description !== '' ? "'$description'" : "NULL";

    $sql = "
        INSERT INTO documents (code, date, place_id, city_id, description)
        VALUES ('$code', $date_sql, $place_sql, $city_sql, $desc_sql)
    ";
    return mysqli_query($link, $sql);
}
