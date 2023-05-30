<?php
class MyDataBase
{
    public $conn;
    function __construct()
    {
        $this->conn = mysqli_connect("localhost", "root", "", "projectwep");
        if (mysqli_connect_errno()) {
            echo "Error in connection To Database" . $this->conn->connect_error;
        }
    }
    
    /************************************************************************ */

    function addStudent($name, $age, $phone, $gender)
    {
        $query = "INSERT INTO students (name, age, phone, gender) VALUES (?, ?, ?, ?)";
        $newStudent = $this->conn->prepare($query);
        $newStudent->bind_param("siis", $name, $age, $phone, $gender);
        $check = $newStudent->execute(); 
        if($check==true){
            echo json_encode(array("success"=>true,
                "message"=>"new student has been addedd"
            )) ;
        }else{
            echo json_encode(array("success"=>false,
                "message"=>"new student has not been addedd"
            )) ;
        }
    }

    function getAllStudents()
    {
        $query = "SELECT * FROM students ORDER BY id ASC";
        $pt = $this->conn->prepare($query);
        $pt->execute();
        $result = $pt->get_result();
        $count = $result->num_rows;
        if ($count > 0) {
            $all_students_array = array();
            while ($row = $result->fetch_assoc()) {
                $id = $row["id"];
                $name = $row["name"];
                $age = $row["age"];
                $phone = $row["phone"];
                $gender = $row["gender"];
                $student_array = $this->createStudentResponse($id, $name, $age,$phone,$gender);
                array_push($all_students_array, $student_array);
            }
            $this->createResponse(true, $count, $all_students_array);
        } else {
            $this->createResponse(false, 0, null);
        }
    }

    function deleteStudentById($id)
    {
        $queryDelete = "DELETE FROM students WHERE id=?";
        $d = $this->conn->prepare($queryDelete);
        $d->bind_param("i", $id);
        $d->execute();
    }

    function updateStudents($id, $name, $age, $phone, $gender)
    {
        $query = "UPDATE students SET name=?, age=?, phone=?, gender=? WHERE id=?";
        $updateStudent = $this->conn->prepare($query);
        $updateStudent->bind_param("siisi",  $name, $age, $phone, $gender, $id);
        $updateStudent->execute();
    }

    function createResponse($isSuccess, $count, $data)
    {
        echo json_encode(array(
            "success" => $isSuccess,
            "count" => $count,
            "data" => $data
        ));
    }

    function createStudentResponse($id, $name, $age,$phone,$gender)
    {
        return array(
            "id" => $id,
            "name" => $name,
            "age" => $age,
            "phone" => $phone,
            "gender" => $gender
        );
    }
}
