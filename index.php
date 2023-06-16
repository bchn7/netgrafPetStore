<!DOCTYPE html>
<html>
<head>
    <title>Pet Store</title>
</head>
<body>
    <h1>Pet Store</h1>

    <?php
    require_once 'src/controller/errorHandler.php';
    require_once 'src/controller/petStoreAPI.php';

    // Inicjalizacja obiektu ErrorHandler
    $errorHandler = new ErrorHandler();

    // Inicjalizacja obiektu PetStoreAPI z przekazaniem ErrorHandler jako zależność
    $petStoreAPI = new PetStoreAPI('https://petstore.swagger.io/v2', $errorHandler);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Dodawanie nowego elementu
        $name = $_POST['name'];
        $category = $_POST['category'];
        $status = $_POST['status'];

        $newPet = $petStoreAPI->addPet($name, $category, $status);
        echo "<p>New pet added with ID: {$newPet['id']}</p>";
    } elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        // Usuwanie elementu
        $petId = $_POST['deleteId'];
        $petStoreAPI->deletePet($petId);
        echo "<p>Pet with ID: $petId has been deleted.</p>";
    }

    ?>

    <h2>Add a new pet:</h2>
    <form method="POST" action="">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="category">Category:</label>
        <input type="text" id="category" name="category" required><br>

        <label for="status">Status:</label>
        <select id="status" name="status">
            <option value="available">Available</option>
            <option value="pending">Pending</option>
            <option value="sold">Sold</option>
        </select><br>

        <input type="submit" value="Add Pet">
    </form>

    <h2>Pets:</h2>
    <ul>
            <?php 
            
            for($i = 1; $i<5; $i++){
                // Pobranie wszystkich elementów w zasobie /pet
                $pet = $petStoreAPI->getPet($i);
                ?>
                <li>
                ID: <?php echo $pet['id']; ?>,
                Name: <?php echo $pet['name']; ?>,
                Category: <?php echo $pet['category']['name']; ?>,
                Status: <?php echo $pet['status']; ?>
            </li>
            <?php
            }
?>

    </ul>

    <h2>Delete a pet:</h2>
    <form method="POST" action="">
        <label for="deleteId">Pet ID:</label>
        <input type="text" id="deleteId" name="deleteId" required><br>

        <input type="submit" value="Delete Pet">
    </form>
</body>
</html>