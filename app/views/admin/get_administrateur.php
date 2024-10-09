<?php
require_once('C:/xmp/htdocs/gestion-ecole/config/db.php');

try {
    $stmt = $conn->query("SELECT prenom, nom, telephone, email FROM administrateur");
    $rowCount = $stmt->rowCount();
    echo "Nombre d'administrateurs trouvés : " . $rowCount;

    if ($rowCount > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td><input type='checkbox'></td>";
            echo "<td>" . htmlspecialchars($row["prenom"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["nom"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["telephone"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
            echo "<td>
                <a href='modifier.php?telephone=" . htmlspecialchars($row["telephone"]) . 
                   "&prenom=" . htmlspecialchars($row["prenom"]) . 
                   "&nom=" . htmlspecialchars($row["nom"]) . 
                   "&email=" . htmlspecialchars($row["email"]) . "'>
                    <i class='fas fa-edit'></i>
                </a>
                <i class='fas fa-trash' onclick='confirmDelete(\"" . htmlspecialchars($row["telephone"]) . "\")'></i>
              </td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='6'>Aucun administrateur trouvé</td></tr>";
    }
} catch (PDOException $e) {
    echo "Erreur : " . htmlspecialchars($e->getMessage());
}
