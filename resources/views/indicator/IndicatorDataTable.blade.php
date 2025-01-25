<?php
$servername = "localhost";  // Adjust if necessary
$username = "root";         // Adjust if necessary
$password = "";             // Adjust if necessary
$dbname = "mdq_dashboards"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the indicator table
$sql = "SELECT * FROM indicator"; // Fetch all records from the indicator table
$result = $conn->query($sql);
?>

@php 


dd(indicator);
@endphp


<div class="d-flex flex-column w-tables rounded mt-3 bg-white table-responsive">
    <div class="dataTables_wrapper dt-bootstrap4 no-footer">
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-hover border-0 w-100">
                    <thead>
                        <tr>
                            <th>Branch</th>
                            <th>Department</th>
                            <th>Designation</th>
                            <th>Overall Rating</th>
                            <th>Added By</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $row['branch'] ?></td>
                                    <td><?= $row['department'] ?></td>
                                    <td><?= $row['designation'] ?></td>
                                    <td>
                                        <div class="star-rating" data-rating="<?= $row['rating'] ?>">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <span class="star" data-value="<?= $i ?>">&#9733;</span>
                                            <?php endfor; ?>
                                            <div class="text-dark f-13">(<?= $row['rating'] ?> / 5)</div>
                                        </div>
                                    </td>
                                    <td><?= $row['added_by'] ?></td>
                                    <td><?= $row['created_at'] ?></td>
                                    <td class="text-right pr-20">
                                        <div class="task_view">
                                            <div class="dropdown">
                                                <a class="task_view_more d-flex align-items-center justify-content-center dropdown-toggle" type="link" id="dropdownMenuLink-55" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="icon-options-vertical icons"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-55" tabindex="0">
                                                    <a href="" class="dropdown-item">View</a>
                                                    <a class="dropdown-item openRightModal" href="edit.php?id=<?= $row['id'] ?>">Edit</a>
                                                    <a class="dropdown-item delete-table-row" href="delete.php?id=<?= $row['id'] ?>">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="7">No records found</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
$conn->close();
?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const starContainers = document.querySelectorAll(".star-rating");

        starContainers.forEach(container => {
            const stars = container.querySelectorAll(".star");
            const rating = parseFloat(container.getAttribute("data-rating"));

            stars.forEach((star, index) => {
                const value = index + 1; // Star value
                if (value <= Math.floor(rating)) {
                    star.style.color = "gold"; // Full stars
                } else if (value === Math.ceil(rating) && rating % 1 !== 0) {
                    star.style.backgroundImage = `linear-gradient(90deg, gold ${(rating % 1) * 100}%, #ccc ${(rating % 1) * 100}%)`;
                    star.style.webkitBackgroundClip = "text";
                    star.style.color = "transparent"; // Partial star
                } else {
                    star.style.color = "#ccc"; // Empty stars
                }
            });
        });
    });
</script>