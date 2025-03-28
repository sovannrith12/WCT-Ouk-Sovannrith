<?php
session_start();
// student class
class Student {
    public $name;
    public $age;
    public $class;
    public $grade;
    public $gender;

    public function __construct($name, $gender, $age, $class, $grade) {
        $this->name = $name;
        $this->age = $age;
        $this->class = $class;
        $this->grade = $grade;
        $this->gender = $gender;
    }

    // student details
    public function displayStudent() {
        echo "<tbody><strong>Name:</strong> $this->name</tbody>";
        echo "<tbody> || </tbody>";
        echo "<tbody><strong>Gender:</strong> $this->gender</tbody>";
        echo "<tbody> || </tbody>";
        echo "<tbody><strong>Age:</strong> $this->age</tbody>";
        echo "<tbody> || </tbody>";
        echo "<tbody><strong>Class:</strong> $this->class</tbody>";
        echo "<tbody> || </tbody>";
        echo "<tbody><strong>Grade:</strong> $this->grade</tbody>";
        echo "<tbody> || </tbody>";
    }
}

// variable to store students
if (!isset($_SESSION['students'])) {
    $_SESSION['students'] = [];
}

// handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $name = htmlspecialchars($_POST['name']);
    $gender = htmlspecialchars($_POST['gender']);
    $age = htmlspecialchars($_POST['age']);
    $class = htmlspecialchars($_POST['class']);
    $grade = htmlspecialchars($_POST['grade']);

    // create a new student object
    $newStudent = new Student($name, $gender, $age, $class, $grade);
    $_SESSION['students'][] = $newStudent;
}

// handle delete
if (isset($_GET['delete'])) {
    $index = $_GET['delete'];
    unset($_SESSION['students'][$index]);
    $_SESSION['students'] = array_values($_SESSION['students']); // Reindex array
}

// handle edit
if (isset($_GET['edit'])) {
    $index = $_GET['edit'];
    $student = $_SESSION['students'][$index];

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
        // update student data
        $_SESSION['students'][$index]->name = htmlspecialchars($_POST['name']);
        $_SESSION['students'][$index]->gender = htmlspecialchars($_POST['gender']);
        $_SESSION['students'][$index]->age = htmlspecialchars($_POST['age']);
        $_SESSION['students'][$index]->class = htmlspecialchars($_POST['class']);
        $_SESSION['students'][$index]->grade = htmlspecialchars($_POST['grade']);
        header("Location: process.php");
        exit();
    }
}
?>

<!-- students list -->
<h2>All Students</h2>
<?php
if (!empty($_SESSION['students'])) {
    foreach ($_SESSION['students'] as $index => $student) {
        echo "<div>";
        echo "<table>";
        // get student details
        $student->displayStudent(); 
        echo "<tbody><a href='?edit=$index'><button>Edit</button></a></tbody>";
        echo "<tbody> || </tbody>";
        echo "<tbody><a href='?delete=$index'><button>Delete</button></a></tbody>";
        echo "</table>";
        echo "</div>";
        echo "<br>";
    }
} else {
    echo "<p>No students.</p>";
}

// edit students details
if (isset($_GET['edit'])) {
    $index = $_GET['edit'];
    $student = $_SESSION['students'][$index];
    ?>
        <!-- edit form -->
        <h3>Edit Student</h3>
        <form method="POST" action="process.php?edit=<?php echo $index; ?>">
            <input type="text" name="name" value="<?php echo $student->name; ?>" required>
            <input type="text" name="gender" value="<?php echo $student->gender; ?>" required>
            <input type="number" name="age" value="<?php echo $student->age; ?>" required>
            <input type="text" name="class" value="<?php echo $student->class; ?>" required>
            <input type="text" name="grade" value="<?php echo $student->grade; ?>" required>
            <button type="submit" name="update">Update Student</button>
        </form>
        <?php
}
?>
            <!-- add more students -->
            <a href="index.html"><button>Add Student</button></a>