<?php
   // Database Connection
   include 'connection.php';

   // Reading value
   $draw = $_POST['draw'];
   $row = $_POST['start'];
   $rowperpage = $_POST['length']; // Rows display per page
   $columnIndex = $_POST['order'][0]['column']; // Column index
   $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
   $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
   $searchValue = $_POST['search']['value']; // Search value

   $searchArray = array();

   // Search
   $searchQuery = " ";
   if($searchValue != ''){
      $searchQuery = " AND (id_prod LIKE :id_prod OR 
           cantidad LIKE :cantidad OR
           nom_prod LIKE :nom_prod OR 
           clasificacion LIKE :clasificacion ) ";
      $searchArray = array( 
           'id_prod'=>"%$searchValue%",
           'cantidad'=>"%$searchValue%",
           'nom_prod'=>"%$searchValue%",
           'clasificacion'=>"%$searchValue%"
      );
   }

   // Total number of records without filtering
   $stmt = $conn->prepare("SELECT COUNT(*) AS allcount FROM movtos_prod ");
   $stmt->execute();
   $records = $stmt->fetch();
   $totalRecords = $records['allcount'];

   // Total number of records with filtering
   /* $stmt = $conn->prepare("SELECT COUNT(*) AS allcount FROM movtos_prod WHERE 1 ".$searchQuery);
   $stmt->execute($searchArray);
   $records = $stmt->fetch();
   $totalRecordwithFilter = $records['allcount']; */ 

   // Fetch records
    $stmt = $conn->prepare("SELECT * FROM movtos_prod WHERE 1 ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT :limit,:offset");

   // Bind values
   foreach ($searchArray as $key=>$search) {
      $stmt->bindValue(':'.$key, $search,PDO::PARAM_STR);
   }

   $stmt->bindValue(':limit', (int)$row, PDO::PARAM_INT);
   $stmt->bindValue(':offset', (int)$rowperpage, PDO::PARAM_INT);
   $stmt->execute(); 
   $empRecords = $stmt->fetchAll();

   $data = array();

   foreach ($empRecords as $row) {
      $data[] = array(
         "id_prod"=>$row['id_prod'],
         "cantidad"=>$row['cantidad'],
         "nom_prod"=>$row['nom_prod'],
         "clasificacion"=>$row['clasificacion'],
      );
   }

   // Response
   $response = array(
      "draw" => intval($draw),
     /*  "iTotalRecords" => $totalRecords, */
      /* "iTotalDisplayRecords" => $totalRecordwithFilter, */
      "aaData" => $data
   );

   echo json_encode($response);