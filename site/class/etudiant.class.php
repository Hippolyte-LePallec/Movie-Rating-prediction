<?php
class Etudiant {
    private $db; 
    private $data = []; 

    //-------------------------------------------------------------------------------------------------------------
    public function __construct($dbConnection) 
    {
        $this->db = $dbConnection;
    }
    //-------------------------------------------------------------------------------------------------------------
    public function setData($key, $value)
    {
        $allowedKeys = ['nometu', 'prenometu', 'adretu', 'viletu', 'cpetu', 'teletu', 'datentetu', 'annetu', 'remetu', 'sexetu', 'datnaietu'];
        if (!in_array($key, $allowedKeys)) {
            throw new InvalidArgumentException("Cle de data invalide : $key");
        }
        $this->data[$key] = $value;
    }
    //-------------------------------------------------------------------------------------------------------------
    public function getData($key) 
    {
        return $this->data[$key] ?? null;
    }
    //-------------------------------------------------------------------------------------------------------------
    // public function create()
    // {
    //     try 
    //     {
    //         $this->db->beginTransaction();

    //         $studentStmt = $this->db->prepare("
    //             INSERT INTO etudiants (nometu, prenometu, adretu, viletu, cpetu, teletu, datentetu, annetu, remetu, sexetu, datnaietu)
    //             VALUES (:nometu, :prenometu, :adretu, :viletu, :cpetu, :teletu, :datentetu, :annetu, :remetu, :sexetu, :datnaietu)
    //         ");
    //         $studentStmt->bindParam(':nometu', $this->data['nometu'], PDO::PARAM_STR);
    //         $studentStmt->bindParam(':prenometu', $this->data['prenometu'], PDO::PARAM_STR);
    //         $studentStmt->bindParam(':adretu', $this->data['adretu'], PDO::PARAM_STR);
    //         $studentStmt->bindParam(':viletu', $this->data['viletu'], PDO::PARAM_STR);
    //         $studentStmt->bindParam(':cpetu', $this->data['cpetu'], PDO::PARAM_STR);
    //         $studentStmt->bindParam(':teletu', $this->data['teletu'], PDO::PARAM_STR);
    //         $studentStmt->bindParam(':datentetu', $this->data['datentetu'], PDO::PARAM_STR);
    //         $studentStmt->bindParam(':annetu', $this->data['annetu'], PDO::PARAM_INT);
    //         $studentStmt->bindParam(':remetu', $this->data['remetu'], PDO::PARAM_STR);
    //         $studentStmt->bindParam(':sexetu', $this->data['sexetu'], PDO::PARAM_STR);
    //         $studentStmt->bindParam(':datnaietu', $this->data['datnaietu'], PDO::PARAM_STR);
    //         $studentStmt->execute();

    //         $this->db->commit();
    //         return true;
    //     } 
    //     catch (Exception $e) 
    //     {
    //         $this->db->rollBack();
    //         throw $e;
    //     }
    // }

    public function create()
    {
        try 
        {
            $this->db->beginTransaction();

            $studentStmt = $this->db->prepare("CALL ajout_etudiant(:nometu, :prenometu, :adretu, :viletu, :cpetu, :teletu, :annetu, :remetu, :sexetu, :datnaietu)");

            $studentStmt->bindParam(':nometu', $this->data['nometu'], PDO::PARAM_STR);
            $studentStmt->bindParam(':prenometu', $this->data['prenometu'], PDO::PARAM_STR);
            $studentStmt->bindParam(':adretu', $this->data['adretu'], PDO::PARAM_STR);
            $studentStmt->bindParam(':viletu', $this->data['viletu'], PDO::PARAM_STR);
            $studentStmt->bindParam(':cpetu', $this->data['cpetu'], PDO::PARAM_STR);
            $studentStmt->bindParam(':teletu', $this->data['teletu'], PDO::PARAM_STR);
            $studentStmt->bindParam(':annetu', $this->data['annetu'], PDO::PARAM_INT);
            $studentStmt->bindParam(':remetu', $this->data['remetu'], PDO::PARAM_STR);
            $studentStmt->bindParam(':sexetu', $this->data['sexetu'], PDO::PARAM_STR);
            $studentStmt->bindParam(':datnaietu', $this->data['datnaietu'], PDO::PARAM_STR);
            $studentStmt->execute();

            $this->db->commit();
            return true;
        } 
        catch (Exception $e) 
        {
            $this->db->rollBack();
            throw $e;
        }
    }
    //-------------------------------------------------------------------------------------------------------------
    public function fetch($id)
    {
        if (!is_numeric($id)) {
            throw new InvalidArgumentException("ID doit etre un numero.");
        }
        $stmt = $this->db->prepare("SELECT * FROM etudiants WHERE numetu = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $this->data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $this->data;
    }
    //-------------------------------------------------------------------------------------------------------------
    public function fetchAll() 
    {
        $stmt = $this->db->query("SELECT * FROM etudiants");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    //-------------------------------------------------------------------------------------------------------------
    public function exists($id)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM etudiants WHERE numetu = :numetu");
        $stmt->bindValue(':numetu', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
    //-------------------------------------------------------------------------------------------------------------
    // public function update($id)
    // {
    //     try 
    //     {
    //         $this->db->beginTransaction();
    
    //         $stmt = $this->db->prepare("
    //             update etudiants set 
    //                 nometu = :nometu, 
    //                 prenometu = :prenometu, 
    //                 adretu = :adretu, 
    //                 viletu = :viletu, 
    //                 cpetu = :cpetu, 
    //                 teletu = :teletu, 
    //                 datentetu = :datentetu, 
    //                 annetu = :annetu, 
    //                 remetu = :remetu, 
    //                 sexetu = :sexetu, 
    //                 datnaietu = :datnaietu
    //             where numetu = :numetu
    //         ");
    
    //         $stmt->bindParam(':numetu', $id, PDO::PARAM_INT);
    //         $stmt->bindParam(':nometu', $this->data['nometu'], PDO::PARAM_STR);
    //         $stmt->bindParam(':prenometu', $this->data['prenometu'], PDO::PARAM_STR);
    //         $stmt->bindParam(':adretu', $this->data['adretu'], PDO::PARAM_STR);
    //         $stmt->bindParam(':viletu', $this->data['viletu'], PDO::PARAM_STR);
    //         $stmt->bindParam(':cpetu', $this->data['cpetu'], PDO::PARAM_INT);
    //         $stmt->bindParam(':teletu', $this->data['teletu'], PDO::PARAM_STR);
    //         $stmt->bindParam(':datentetu', $this->data['datentetu'], PDO::PARAM_STR);
    //         $stmt->bindParam(':annetu', $this->data['annetu'], PDO::PARAM_INT);
    //         $stmt->bindParam(':remetu', $this->data['remetu'], PDO::PARAM_STR);
    //         $stmt->bindParam(':sexetu', $this->data['sexetu'], PDO::PARAM_STR);
    //         $stmt->bindParam(':datnaietu', $this->data['datnaietu'], PDO::PARAM_STR);
    
    //         $stmt->execute();
    
    //         $this->db->commit();
    //         return true;
    //     } 
    //     catch (Exception $e) 
    //     {
    //         $this->db->rollBack();
    //         throw $e;
    //     }
    // }    
    public function update($id)
    {
        try 
        {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare("CALL modif_etudiant(:numetu, :nometu, :prenometu, :adretu, :viletu, :cpetu, :teletu, :annetu, :remetu, :sexetu, :datnaietu)");

            $stmt->bindParam(':numetu', $id, PDO::PARAM_INT);
            $stmt->bindParam(':nometu', $this->data['nometu'], PDO::PARAM_STR);
            $stmt->bindParam(':prenometu', $this->data['prenometu'], PDO::PARAM_STR);
            $stmt->bindParam(':adretu', $this->data['adretu'], PDO::PARAM_STR);
            $stmt->bindParam(':viletu', $this->data['viletu'], PDO::PARAM_STR);
            $stmt->bindParam(':cpetu', $this->data['cpetu'], PDO::PARAM_INT);
            $stmt->bindParam(':teletu', $this->data['teletu'], PDO::PARAM_STR);
            $stmt->bindParam(':annetu', $this->data['annetu'], PDO::PARAM_INT);
            $stmt->bindParam(':remetu', $this->data['remetu'], PDO::PARAM_STR);
            $stmt->bindParam(':sexetu', $this->data['sexetu'], PDO::PARAM_STR);
            $stmt->bindParam(':datnaietu', $this->data['datnaietu'], PDO::PARAM_STR);

            $stmt->execute();

            $this->db->commit();
            return true;
        } 
        catch (Exception $e) 
        {
            $this->db->rollBack();
            throw $e;
        }
    }
    //-------------------------------------------------------------------------------------------------------------
    public function delete($numetu)
    {
        try 
        {
            $this->db->beginTransaction();
    
            $deleteStudentStmt = $this->db->prepare("DELETE FROM etudiants WHERE numetu = :numetu");
            $deleteStudentStmt->bindValue(':numetu', $numetu, PDO::PARAM_INT);
            $deleteStudentStmt->execute();
    
            $this->db->commit();
            return true;
        } 
        catch (Exception $e) 
        {
            $this->db->rollBack();
            throw $e;
        }
    }
    //-------------------------------------------------------------------------------------------------------------
    public function find($params)
    {
        $allowedColumns = ['nometu', 'prenometu', 'adretu', 'viletu', 'cpetu', 'teletu', 'datentetu', 'annetu', 'remetu', 'sexetu', 'datnaietu'];
        $queryParams = [];
        $sql = "SELECT * FROM etudiants WHERE 1=1";
    
        foreach ($params as $key => $value) {
            if (!empty($value) && in_array($key, $allowedColumns)) 
            {
                if (in_array($key, ['nometu', 'prenometu', 'adretu', 'viletu', 'remetu', 'sexetu'])) 
                {
                    $sql .= " AND LOWER($key) LIKE LOWER(:$key)";
                    $queryParams[":$key"] = "%$value%";
                } 
                elseif (in_array($key, ['datnaietu', 'datentetu'])) 
                {
                    if (DateTime::createFromFormat('Y-m-d', $value) !== false) 
                    {
                        $sql .= " AND $key = :$key";
                        $queryParams[":$key"] = $value;
                    }
                } 
                elseif (in_array($key, ['cpetu', 'annetu']) && is_numeric($value)) 
                {
                    $sql .= " AND $key = :$key";
                    $queryParams[":$key"] = $value;
                }
            }
        }
    
        $stmt = $this->db->prepare($sql);
        $stmt->execute($queryParams);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }    
}
